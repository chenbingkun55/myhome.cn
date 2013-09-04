<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"><HTML xmlns="http://www.w3.org/1999/xhtml"><HEAD><meta http-equiv="Content-Type" content="text/html; charset=utf8" /><TITLE><?php echo ($title); ?></TITLE><script type="text/javascript" src="/public/js/jquery-2.0.2.min.js"></script><script type="text/javascript" src="/public/js/all.js"></script><script charset="utf-8" src="/public/kindeditor-4.1.7/kindeditor.js"></script><script charset="utf-8" src="/public/kindeditor-4.1.7/lang/zh_CN.js"></script><script>   KindEditor.ready(function(K) {
       window.editor = K.create('#editor_id');
   });
</script><style type="text/css">	body{background-color:#003300;margin: 5px 10px 5px 10px;}
	header,nav,article{padding: 0px;}
	header{}
		#status_bar{position: relative;background-color:#000000;text-align:center;color:#FFFFFF;}
		#tools_bar{position: relative;background-color:000000;}
	nav{}
		#today_task{background-color:#6699FF;}
		#grade_task{background-color:#FFFF99;}
		#delay_task{background-color:#FF6699;}
		.day_box{float:left;background-color:#FFFFFF;margin: 5px}
		.forward_point{float:left;background-color:#000000;color:#FFFFFF;margin: 5px;}
		.after_point{float:right;background-color:#000000;color:#FFFFFF;margin: 5px;}
		.cal_title_forward_point{float:left;background-color:#000000;color:#FFFFFF;margin: 5px}
		.cal_forward_point{float:left;background-color:#000000;color:#FFFFFF;margin: 5px}
		.cal_after_point{float:right;background-color:#000000;color:#FFFFFF;margin: 5px}
	article{}
		#cal_tools{position: relative;background-color:#000000;color:#FFFFFF;text-align:center}
		#calendar{position: relative;background-color:#009966;}
</style></HEAD><BODY><header><div id="status_bar"><B>任务管理器</B></div><div id="tools_bar">工具栏</div></header><nav><div id="today_task" title="当天事务"><div class="forward_point"><<</div><?php if(is_array($task_list_cur)): $i = 0; $__LIST__ = $task_list_cur;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$d): $mod = ($i % 2 );++$i;?><a href="/myt/index.php/Task/edit_task/tid/<?php echo ($d["tid"]); ?>/"><?php echo ($d["box"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?><div class="after_point">>></div></div><div id="grade_task" title="重要事务"><div class="forward_point"><<</div><div id="today_task_1" class="day_box" style="background-color:#6600FF;">测试一天</div><div id="today_task_2" class="day_box" style="background-color:#FFFF00;">测试二天</div><div id="today_task_2" class="day_box" style="background-color:#FF0000;">测试二天</div><div id="today_task_2" class="day_box" style="background-color:#00CC00;">测试二天</div><div class="after_point">>></div></div><div id="delay_task" title="延期事务"><div class="forward_point"><<</div><div id="today_task_1" class="day_box" style="background-color:#6600FF;">测试一天</div><div id="today_task_2" class="day_box" style="background-color:#FFFF00;">测试二天</div><div id="today_task_2" class="day_box" style="background-color:#FF0000;">测试二天</div><div id="today_task_2" class="day_box" style="background-color:#00CC00;">测试二天</div><div class="after_point">>></div></div></nav><article><div id="cal_tools"><B><?php echo ($cur_date); ?></B><BR>		&nbsp;星期一&nbsp;星期二&nbsp;星期三&nbsp;星期四&nbsp;星期五&nbsp;星期六&nbsp;星期日
	</div><div id="calendar"><?php if(is_array($cal_date)): $i = 0; $__LIST__ = $cal_date;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$d): $mod = ($i % 2 );++$i;?><a href="/myt/index.php/Task/create_task/date/<?php echo ($d["day"]); ?>/"><?php echo ($d["box"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?></div></article></BODY></HTML>