<?PHP
	// 定义ThinkPHP框架路径(相对于入口文件)

define('THINK_PATH', '../ThinkPHP/');

//  不生成 Runtime/~Runtime 文件
define('APP_DEBUG',true);

//定义项目名称和路径

define('APP_NAME', 'MyTasks');

define('APP_PATH', '');

// 加载框架入口文件

	require(THINK_PATH."/ThinkPHP.php");
?>
