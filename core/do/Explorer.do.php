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
     * 例如：http://filemount.dev/explorer/expandList/10
     */
    function expandList($nodeId = 0){$uid = 1;//获取已登录的用户ID
        if (empty($uid)) {
            putjson(-1, array(), '未登录');
        }
        if (empty($nodeId)) {
            $tree = VfsTree::getMyTree($uid);
            if (empty($tree)) {
                putjson(-1, array(), '该用户未创建目录树');
            }
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
    
    
    /**
     * 接口：创建目录
     * 参数：ltre-crypt加密的目录名
     * 例如：http://filemount.dev/explorer/createFolder/13?foldername=%E4%BD%8D%E4%BA%8E13%E8%8A%82%E7%82%B9%E4%B8%8B%E6%9F%90%E4%B8%AA
     */
    function createFolder($parentId = 0){$uid = 1;//获取已登录的用户ID
        if (empty($uid)) {
            putjson(-1, array(), '未登录');
        }
        $foldername = arg('foldername');
        if (null === $foldername) {
            putjson(-1, array(), '参数错误');
        }
        if (empty($parentId)) {
            $tree = VfsTree::getMyTree($uid);
            if (empty($tree)) {
                $rootNodeId = VfsTree::createNode('', 0, 0, 0);
                VfsTree::createTree($rootNodeId, $uid);
            } else {
                $rootNodeId = $tree['root_node'];
            }
            $newNodeId = VfsTree::createNode($foldername, 0, 1, $rootNodeId);
        } else {
            $newNodeId = VfsTree::createNode($foldername, 0, 1, $parentId);
        }
        $node = VfsTree::getNode($newNodeId);
        putjson(0, $node, '创建成功');
    }
    
    
    
    /**
     * 接口：创建文件
     * 参数：ltre-crypt加密的文件ID
     * 两种方式：1、选取服务器现有文件；2、上传新文件，再选取服务器现有文件
     */
    function createFile(){
        
    }
    
    

    function toLogin(){
        $this->stpl();
    }

}