<?php

class ExplorerDo extends DIDo {

    function start(){$uid = 1;//获取已登录的用户ID
        if (empty($uid)) {
            $this->toLogin();
        } else {
            $treeId = $this->_getTreeId($uid);
            $this->root = VfsTree::load($treeId);
            $this->stpl();
        }
    }

    private function _getTreeId($uid){
        return 1;
    }

    function toLogin(){
        $this->stpl();
    }

}