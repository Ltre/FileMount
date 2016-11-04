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
            SELECT f.*, n.* FROM {$F->table} f, {$N->table} n 
            WHERE f.file_id = n.file_id AND n.parent_id = :parent_id";
        $children = $F->query($sql, array('parent_id' => $nodeId));
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
                return self::getOwnerByNodeId($nodeId);
            }
        }
    }
    
    //获取自己创建的文件树（暂定一个人只有一棵树）
    static function getMyTree($uid){
        $tree = supertable('Tree')->find(array('uid' => $uid)) ?: array();
        return $tree;
    }

}