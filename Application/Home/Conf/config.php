<?php
include("define.php");  //引入常量定义

return array(
	// 添加数据库配置信息
    'DB_TYPE'   => 'mysqli', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => 'dev_myhomedb', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => '123456', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'task_', // 数据库表前缀

    'LANG_SWITCH_ON'   => true, // 开启语言包功能
    //'LANG_AUTO_DETECT' => true, // 自动侦测语言 开启多语言功能后有效
    'VAR_LANGUAGE'     => 'lang', // 默认语言切换变量<Paste>
    'DEFAULT_LANG'     => 'zh-cn', // 默认语言
    'LANG_LIST'        => 'zh-cn', // 允许切换的语言列表 用逗号分隔

	'DEFAULT_CHARSET'=> 'utf-8',  // 设置编码.
	'DEFAULT_TIMEZONE'=>'Asia/ShangHai', // 设置默认时区为上海
	'APP_DEBUG'=>true, // false-关闭调试模式,会自动开启部署模式.
    'DEBUG_MODE'=>true,
    'DB_FIELD_CACHE' => false,
    'HTML_CACHE_ON' => false,
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
    'DEFAULT_SITE_NAME' => '',

	//'TMPL_L_DELIM' => '<{',
	//'TMPL_R_DELIM' => '}>',
    'URL_ROUTER_ON' => true,
    'URL_ROUTE_RULES' => array(
        'show/:id\d'      => array('Home/Index/index_show?tid=:1'),
    ),
);
