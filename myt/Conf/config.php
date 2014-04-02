<?php
return array(
	// 添加数据库配置信息
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => 'myhome', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => '`123qwer', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'task_', // 数据库表前缀

	'DEFAULT_CHARSET'=> 'utf-8',  // 设置编码.
	'DEFAULT_TIMEZONE'=>'Asia/ShangHai', // 设置默认时区为上海
	'APP_DEBUG'=>true, // false-关闭调试模式,会自动开启部署模式.
    'DEBUG_MODE'=>true,
    'WEB_LOG_RECORD'=>true,
    'SHOW_ERROR_MSG'=>true,
/* SHOW_PAGE_TRACE 己包含.
	 'SHOW_RUN_TIME'    => false, // true-运行时间显示
	'SHOW_ADV_TIME'    => true, // 显示详细的运行时间
	 'SHOW_DB_TIMES'    => true, // 显示数据库查询和写入次数
	'SHOW_CACHE_TIMES' => true, // 显示缓存操作次数
	'SHOW_USE_MEM'     => true, // 显示内存开销
	'SHOW_LOAD_FILE'   => true, // 显示加载文件数
	'SHOW_FUN_TIMES'   => true, // 显示函数调用次数
*/

	'SHOW_PAGE_TRACE' =>true, // 显示页面Trace信息
    'WEATHER_LOCATION' => "福州",

	//'TMPL_L_DELIM' => '<{',
	//'TMPL_R_DELIM' => '}>',
);
?>
