<?php

class VfsTree extends DIEntity {

    static function getTree($treeId){
        $tree = supertable('Tree')->find(array('tree_id' => $treeId)) ?: array();
        return $tree;
    }
    
    static function loadChildren($nodeId){
        $N = supertable('Node');
        $F = supertable('File');
        $sql = "
            SELECT f.*, n.* FROM {$N->table} n LEFT JOIN {$F->table} f
            ON n.file_id = f.file_id WHERE n.parent_id = :parent_id";
        $children = $F->query($sql, array('parent_id' => $nodeId));
        foreach ($children as $k => $v) {
            $children[$k]['is_leaf'] = boolval($v['is_leaf']);
        }
        return $children;
    }
    
    //获取节点所在树的所有者ID
    static function getOwnerByNodeId($nodeId){
        $node = supertable('Node')->find(array('node_id' => $nodeId)) ?: array();
        if (@is_numeric($node['node_level']) && $node['node_level'] == 0) {
            $tree = supertable('Tree')->find(array('root_node' => $node['node_id']));
            if ($tree && isset($tree['uid'])) {
                return (int) $tree['uid'];
            } else {
                return -1;//有顶级节点，但无树可归
            }
        } else {
            if (empty($node['parent_id'])) {
                return -2;//找不到该节点的父节点
            } else {
                return self::getOwnerByNodeId($node['parent_id']);
            }
        }
    }
    
    //获取自己创建的文件树（暂定一个人只有一棵树）
    static function getMyTree($uid){
        $tree = supertable('Tree')->find(array('uid' => $uid)) ?: array();
        return $tree;
    }
    
    
    //创建树
    static function createTree($rootNodeId, $uid){
        $T = supertable('Tree');
        $find = $T->find(array('root_node' => $rootNodeId));
        if (empty($find)) {
            $treeId = $T->insert(array('root_node' => $rootNodeId, 'uid' => $uid));
        } else {
            $treeId = $find['tree_id'];
        }
        return $treeId;
    }
    
    //创建节点
    static function createNode($nodeName = '', $fileId = 0, $isLeaf = 0, $parentId = 0){
        $N = supertable('Node');
        $parent = $N->find(array('node_id' => $parentId));
        if ($parentId != 0 && empty($parent)) {
            return -1;//找不到父节点
        } else {
            $nodeId = $N->insert(array(
                'node_name' => $nodeName,
                'parent_id' => $parentId,
                'node_path' => '',//暂时留空，下步更新
                'node_level' => $parent['node_level'] + 1,
                'is_leaf' => $isLeaf, 
                'file_id' => $fileId
            ));
            $N->update(array('node_id' => $nodeId), array('node_path' => "{$parent['node_path']},{$nodeId}"));
            $N->update(array('node_id' => $parentId), array('is_leaf' => 0));
            return $nodeId;
        }
    }
    
    
    //获取节点
    static function getNode($nodeId){
        $N = supertable('Node');
        $F = supertable('File');
        $sql = "
            SELECT f.*, n.* FROM {$N->table} n LEFT JOIN {$F->table} f
            ON f.file_id = n.file_id WHERE n.node_id = :node_id";
        $node = $N->query($sql, array(':node_id' => $nodeId)) ?: array();
        return $node;
    }
    
    
    //修改节点名（即虚拟文件系统里的目录或文件名）
    static function setNodeName($nodeId, $name){
        $can = false;
        $N = supertable('Node');
        $find = $N->find(array('node_id' => $nodeId));
        if (empty($find)) {
            return array('code' => -1, 'msg' => '找不到节点');
        }
        //是顶级节点，则可直接修改名称；否则，需要检查同级的节点是否存在同名的
        if ($find['parent_id'] != 0) {
            $select = $N->select(array('parent_id' => $find['parent_id'])) ?: array();
            foreach ($select as $k => $v) {
                if ($v['node_id'] != $nodeId && $v['node_name'] == $name) {
                    return array('code' => -2, 'msg' => '名称已存在');
                }
            }
        }
        $rs = $N->update(array('node_id' => $nodeId), array('node_name' => $name));
        $success = $rs !== false;
        return array('code' => $success?0:-3, 'msg' => $success?'更新成功':'更新失败');
    }
    
    
    //【待测试】移动到新的父节点
    static function setNewParent($nodeId, $parentId){
        $N = supertable('Node');
        if ($nodeId == $parentId) {
            return array('code' => -1, 'msg' => '不能指定自身为父节点');
        }
        $find = $N->find(array('node_id' => $nodeId));
        if (empty($find)) {
            return array('code' => -2, 'msg' => '找不到节点');
        }
        if ($find['parent_id'] == $parentId) {
            return array('code' => -3, 'msg' => '已经是父节点，没必要移动');
        }
        $findPar = $N->find(array('node_id' => $parentId));
        if (empty($findPar)) {
            return array('code' => -4, 'msg' => '找不到指定的父节点');
        }
        if ($findPar['file_id'] != 0) {
            return array('code' => -5, 'msg' => '父节点不是目录');
        }
        if (self::_hasLoopChildException($nodeId, $parentId)) {
            return array('code' => -6, 'msg' => '触发循环子节点异常');
        }
        $rs = $N->update(array('node_id' => $nodeId), array('parent_id' => $parentId));
        $success = $rs !== false;
        if ($success) {
            //将新的父节点变成非叶子节点
            $N->update(array('node_id' => $parentId), array('is_leaf' => 0));
            //当旧的父节点不存在子节点时，将该父节点变成叶子节点
            if (count($N->select(array('parent_id' => $find['parent_id']))?:array()) == 0) {
                $N->update(array('node_id' => $find['parent_id']), array('is_leaf' => 1));
            }
        }
        return array('code' => $success?0:-7, 'msg' => $success?'更新成功':'更新失败');
    }
    
    
    /*
     * 检查节点被指定新的父节点后，是否会触发“循环子节点异常”。
     * 例如：parentPath=1,4,7,8。n=4, f=7 (X); n=7, f=1 (V)
     */
    static protected function _hasLoopChildException($nodeId, $destParentId){
        $N = supertable('Node');
        $has = false;
        while (1) {
            $find = $N->find(array('node_id' => $destParentId));
            if ($find['parent_id'] == 0) break;//到达顶级节点，结束
            if ($find['parent_id'] == $nodeId) {
                $has = true;//触发循环异常
                break;
            } else {
                $destParentId = $find['parent_id'];
            }
        }
        return $has;
    }
    
}