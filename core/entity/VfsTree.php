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
    
}