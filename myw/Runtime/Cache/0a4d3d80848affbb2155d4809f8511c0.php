<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"><HTML><HEAD><TITLE><?php echo ($title); ?></TITLE><script type="text/javascript" src="/public/js/jquery-2.0.2.min.js"></script><script type="text/javascript" src="/public/js/all.js"></script><style type="text/css"><!--
	body,html{ height: 100%; margin:0px auto;overflow-y:hidden !important;overflow-x:auto !important;}
	body{ margin: 0px;font-family: 微软雅黑,Serif,Tahoma,Arial,Helvetica,sans-serif; font-size: 12px;background-color:#000000;}
	:focus{ outline:0; }

	#main_frame{ width:1024px;height:100%;position: relative;clear:both;}
	#up_frame{ height:124px;background-color:transparent;vertical-align:bottom;margin: 5px 5px 0 px 10px: position: relative;bottom:0px}
	#midd_frame{ position: relative;clear:both;}
	#down_frame{ height:20px:position: relative;clear:both;background-color:#FFFF00;}

	#tool_bar{ position: relative;width:100%;height:24px;float:left;background-color:#FF9900;font-weight:bold;}
	#info_bar{ position: relative;height:24px;float:right;margin : 5px 5px 0px 0px;}
	#title_text{float:left; text-align:center; vertical-align:center; background-color:#CCFF99; height:24px;width:160px;font-size:16px;color:#3366FF; }
	.tool_bar_m{ position: relative; z-index:1000;float:left;background-color: #FF9900; overflow:hidden;}
	#progress_bar{ position: relative; height:100px;clear:both;background-color:transparent;}
	#left_bar{ position: relative; width:140px;height:80%;font-weight:bold;float:left;text-align:center;background-color:#669900;}
	#left_bar_t{ position: relative; width:140px;height:20px;font-family: Serif;background-color: #FF9900;}
	#main_box{ position: relative; width:884px;height:80%;float:right;}
	#title_bar{ position: relative;width:100%;height:20px;background-color:#669900;}
	#title_bar_m{ position: relative; width:100px;height:20px;background-color:#FFFF33;}
	#title_bar_ma{ position: relative; width:100px;height:20px;background-color:#6633FF;}
	#conten_box{ position: relative; }
	#conten_box_m{ position: relative; background-color:#6633FF;}
	#resource_box{position: relative; background-color:#66FF00;}
	#resource_box_m{position: relative; width:120px;height:20px;background-color:#FF9900;margin : 0px 10px 0px 10px;}

	#pop_window_title{position: relative; width:100%;height:30px;background-color:#6666CC;float:left;font-size: 24px;font-family: 微软雅黑,Serif;color:#FFFFFF;}
	#pop_window_conten{padding: 10px 10px 10px 10px;position: relative; background-color:#FFFFFF;float:left;font-size: 12px;font-family: 微软雅黑,Serif;}
	#pop_window_title_close{padding: 5px 10px 0px 0px;position: relative;background-color:#660000;float:right;font-size: 16px;font-family: 微软雅黑,Serif;color:#FFFFFF;}

	.menu{position: relative; height:24px;width:140px;float:left;}
	.menu ul{padding: 0px 5px 0px 5px;text-align:center; vertical-align:center; margin : 5px 0px 0px 0px;}
	.menu ul li{ height:24px; display:inline-block;width:130px;} 
	.menu ul li:hover{background:#CCFF99} 
	.menu ul li ul li{padding-left:5px; position:relative;}
	
	.menu_left ul{padding: 0px 5px 0px 5px;text-align:left; vertical-align:center; margin : 5px 0px 0px 0px;}
	.menu_left ul li{ height:24px; display:inline-block;width:130px;} 
	.menu_left ul li:hover{background:#FF9900;} 
	.menu_left ul li ul li{padding-left:5px; position:relative;}
--!></style></HEAD><BODY><DIV id="main_frame"><DIV id="up_frame" class="up_frame"><DIV id="tool_bar" class="tool_bar"><DIV  id="tool_bar_m1" class="tool_bar_m"></DIV><DIV  id="tool_bar_m2" class="tool_bar_m"></DIV><DIV  id="tool_bar_m3" class="tool_bar_m"></DIV><span id="title_text"><?php echo ($title); ?></span><DIV id="info_bar" class="info_bar">					账号: <a href="#"><?php echo ($username); ?></a>&nbsp;<a href="__ROOT__/admin">设置</a>&nbsp;当前时间: <?php echo ($tdate); ?></DIV></DIV><DIV id="progress_bar" class="progress_bar"></DIV></DIV><DIV id="midd_frame" class="midd_frame"><DIV id="left_bar" class="left_bar"></DIV><DIV id="main_box" class="main_box"><DIV id="title_bar" class="title_bar"></DIV><DIV id="conten_box" class="conten_box"></DIV></DIV></DIV><DIV id="down_frame" class="down_frame">		测试
		</DIV></DIV>