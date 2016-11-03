<?php

class VfsTree extends DIEntity {

    static function loadDir($treeId){
        $tree = supertable('Tree')->find(array('tree_id' => $treeId)) ?: array();
        $firstLevelNodes = supertable('Node')->select(array('parent_id' => $tree['root_node']));
        $fileList = array();
        foreach ($firstLevelNodes as $k => $v) {
            $fileList[$v['node_id']] = supertable('File')->find(array('file_id' => $v['file_id']));
        }
        dump($fileList);
    }

}