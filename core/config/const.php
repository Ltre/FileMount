<?php

//管理端存放的验证文件，用SHA1加密存储，内容有：管理员账号和密码（其它内容暂定）。一行存储一个键值对，以=>分隔键和值，并用SHA1加密。
define('ADMINISTRATION_VERIFY_FILE_PATH', 'core/data/vfs/admin.verify');
//服务器文件系统采用的字符集，如GBK，GB2312，UTF-8等等。如果编码设置不正确，那么含有中文等特殊字符的文件系统路径无法被读取。
define('CHARSET_IN_SERVER_FILESYSTEM','GBK');
//操作系统：UNIX/LINUX、WINDOWS
define('OS_TYPE','WINDOWS');
//文件路径分隔符：\\、/
define('FILESYSTEM_SEPARATE','\\');
//虚拟文件系统全局配置文件
define('VFS_GLOBAL_SETUPFILE_PATH', 'core/data/vfs/current.global');
//虚拟文件系统全局配置文件的备用文件，在主GLOBAL文件加载错误时，将自动加载这个文件。【这个文件可以保存上次操作后的状态】
define('VFS_GLOBAL_BACKUP_SETUPFILE_PATH', 'core/data/vfs/current.backup.global');
//虚拟文件系统局部配置文件（默认保存名）
define('VFS_PART_SETUPFILE_DEFAULTPATH', 'core/data/vfs/default.part');
//global文件的根元素名称
define('ROOT_ELEMENT_NAME_IN_GLOBAL_FILE', 'root');
//global文件的目录元素名称
define('DIR_ELEMENT_NAME_IN_GLOBAL_FILE', 'dir');
//global文件的文件元素名称
define('FILE_ELEMENT_NAME_IN_GLOBAL_FILE', 'file');
//下载文件的最大值（单位Byte），该值不能超过php.ini所设定的限制。查看php.ini的最大设定值的方法：post_max_size的值小于等于memory_limit时，以post_max_size为准；post_max_size的值超过memory_limit时，将以memory_limit为准
define('MAX_SIZE_ON_DOWNLOAD', 629145600);	//这里限制 300 MB（暂时改为，原值314572800）
//如遇到name属性值为空的节点，则需要自动为其命名。命名规则：【常量字串+时间戳】
define('NAME_VALUE_PREFIX_OF_NODE_ATTR', '未命名');
//当前的ids，用于XML查找文件树
define('FMT_IDS', 'ids');




/**! -- 系统重做后的部分 -- */
