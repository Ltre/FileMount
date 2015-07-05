<?php
class DIRouteRewrite {
    
    /**
     * 自定义路由重写规则
     * 书写原则，特殊在前，通用在后
     * 详见：
     *      DIRoute::rewrite() @ __route.php
     */
    static $rulesMap = array(
        '://filemount.larele.com' => 'main/start', //含有域名的配置最好放在最前面(经验之谈),二级域名要优先于顶级域名,注意DiUrlShell::$_default_shell的覆盖问题
        '://filemount.dev' => 'main/start',
        
        's' => 'shell.shell',
        's.html' => 'shell.shell',
        
        '<D>' => '<D>/start',
        '<D>.htm' => '<D>/start',
        '<D>.html' => '<D>/start',
        
        '<D>/<F>' => '<D>/<F>',
        '<D>-<F>' => '<D>/<F>',
        '<A>.<B>' => '<A>.<B>',
        '<A>.<B>.<C>' => '<A>.<B>.<C>',
    );
    
    /**
     * 不需要重写的
     * 左侧为相对于脚本目录的URI
     * 右侧表示重写失败时是否终止程序
     * 这些规则不受常量DI_KILL_ON_FAIL_REWRITE影响
     */
    static $withoutMap = array(
        'index.php' => false,
        'index.html' => false,
        'index.htm' => false,
        'favicon.ico' => true,
    	'robots.txt' => true,
    );
    
}