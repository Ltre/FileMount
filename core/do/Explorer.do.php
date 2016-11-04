<?php

class ExplorerDo extends DIDo {

    function start(){$uid = 1;//获取已登录的用户ID
        if (empty($uid)) {
            $this->toLogin();
        } else {
            $this->stpl();
        }
    }
    
    
    /**
     * 接口：获取展开列表
     */
    function expandList($nodeId = 0){$uid = 1;//获取已登录的用户ID
        if (empty($uid)) {
            putjson(-1, array(), '未登录');
        }
        if (empty($nodeId)) {
            $tree = VfsTree::getMyTree($uid);
            @$list = VfsTree::loadChildren($tree['root_node']);
        } else {
            $owner = VfsTree::getOwnerByNodeId($nodeId);
            if ($owner != $uid) {
                putjson(-2, array(), '没有读取权限');
            }
            $list = VfsTree::loadChildren($nodeId);
        }
        putjson(0, $list, '获取成功');
    }
    

    function toLogin(){
        $this->stpl();
    }

}