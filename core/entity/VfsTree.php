<?php

class VfsTree extends DIEntity {

    static function load($treeId){
        $tree = supertable('Tree')->find(array('tree_id' => $treeId)) ?: array();
        $firstLevelNodes = supertable('Node')->select(array('parent_id' => $tree['root_node']));
        dump($firstLevelNodes);die;
    }

}