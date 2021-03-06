<?php
/**
 * 参照__env.php建议，按己所需，重新定制特性
 */
$hostname = substr( ($h = $_SERVER['HTTP_HOST']), 0, (false !== ($pos = strpos($h, ':')) ? $pos : strlen($h)) );
switch ($hostname) {
    //以下使用本地
	case '127.0.0.1':
    case '192.168.1.100':
	case 'localhost':
	case 'filemount.dev':
    case 'filemount.webdev.duowan.com':
	    {
	        define('DI_ROUTE_REWRITE', true);
	        break;
	    }

	//以下使用可写空间(正式环境)
	case 'file.larele.com'://linode tokyo
    	{
    	    define('DI_DEBUG_MODE', false);
    	    define('DI_IO_RWFUNC_ENABLE', true);
    	    define('DI_ROUTE_REWRITE', true);
    	    break;
    	}
    //以下使用可写空间(测试环境)
	case 'test.file.larele.com'://待定
	    {
	        define('DI_DEBUG_MODE', true);
	        define('DI_IO_RWFUNC_ENABLE', true);
	        break;
	    }
	default:die;//环境不明确，终止执行
}
