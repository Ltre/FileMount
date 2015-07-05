<?php
/**
 * 配置数据库基本信息
 * 【！！强烈建议！！】
 * 不要将本文件中的外网数据库信息提交
 */
$hostname = substr( ($h = $_SERVER['HTTP_HOST']), 0, (false !== ($pos = strpos($h, ':')) ? $pos : strlen($h)) );
if (in_array($hostname, array(
    '127.0.0.1',
    'localhost',
    'filemount.dev',//绑定本地HOSTS
))){
	
    class DIDBConfig {
        static $driver = 'DIMySQL';//驱动类
        static $host = '127.0.0.1';
        static $port = 3306;
        static $db = 'filemount';
        static $user = 'filemount';
        static $pwd = 'filemount';
        static $table_prefix = 'fmt_';//表前缀
    }
    class DIMMCConfig {
        static $domain = 'filemount';
        static $host = '127.0.0.1';
        static $port = 11211;
    }
    
} elseif(in_array($hostname, array(
	'file.larele.com'
))) {
    
    class DIDBConfig {
        static $driver = 'DIMySQL';//驱动类
        static $host = '127.0.0.1';
        static $port = 3306;
        static $db = 'filemount';
        static $user = 'filemount';
        static $pwd = '71f17c2521448e961c4c62c2111f7f391e3b61a1';//m+s
        static $table_prefix = 'fmt_';//表前缀
    }
    class DIMMCConfig {
        static $domain = 'filemount';
        static $host = '127.0.0.1';
        static $port = 11211;
    }
    
} else {
    
    die;//环境不明确，终止
    
}