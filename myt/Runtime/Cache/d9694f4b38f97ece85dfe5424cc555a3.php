<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title>[▶<?php echo ($task_status); ?> ID=<?php echo ($task_id); ?>]&nbsp;<?php echo ($task_list['T_title']); ?></title>
    <script type="text/javascript" src="/public/js/jquery-2.0.2.min.js"></script>
    <script type="text/javascript" src="/public/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="/public/js/all.js"></script>
    <script charset="utf-8" src="/public/kindeditor-4.1.7/kindeditor.js"></script>
    <script charset="utf-8" src="/public/kindeditor-4.1.7/lang/zh_CN.js"></script>
    <script>
        setTimeout("process_relay()",6000);//每6秒钟刷新一次
        var is_change = false;
		var options = {
				uploadJson : '/myt/index.php/Attached/upload/date/<?php echo (date("Y-m-d",$task_list['T_date'])); ?>',
				fileManagerJson : '/myt/index.php/Attached/manager/',
				allowFileManager : false,
				items : [
								'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
								'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
								'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
								'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
								'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
								'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage',
								'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'map', 'pagebreak',
								'anchor', 'link', 'unlink', 'FinishTab','|', 'about'
					],
            afterChange : function() {
                // alert(is_change);
                is_change = true;
            }

        };

        KindEditor.ready(function(K) {
			window.editor = K.create('#editor_id',options );
            is_change = false;
       });
    </script>

    <style type="text/css">
        body{background-color:#003300;margin: 5px 10px 5px 10px;font-family: 微软雅黑;font-size: 14px;width:800px;height: 600px;}
        input,select{background-color: #FFFFCC; }
		span{cursor:pointer;}
        header,nav,article{padding: 0px;}
        .task_center{position: relative;background-color:#336600;-moz-user-select:none;-webkit-user-select:none;user-select:none;  }
        .task_tools_bar{text-align:center; height:80px;position: relative;background-color:#000000;color:#FFFFFF; margin: 10px 0px 10px 0px;}
		.task_tools_title{font-size: 24px;height: 50px;font-weight:900;overflow:hidden;}
        .task_win_close{margin: 5px;background-color: #CC0000;float: right;}
		.task_win_submit{margin: 5px;background-color: #6666FF;float: left;}
		.task_set_templet{margin: 5px;background-color: #6666FF;float: left;}
		.task_process_box{position: absolute;margin: 0px 0px 0px 220px ;width: 360px;}
		.task_process_step{margin: 2px 10px 2px 5px ;float: left;font-size: 12px;color: #FFFFFF;}
		.task_process_point{margin: 2px;background-color: #000000;color: #FFFFFF;display: none;}
		.task_process_progress_box{position: absolute;background-color:#FFFFCC;margin: 18px 0px 0px 220px ;width: 350px;height: 5px;}
		.task_process_progress_status{margin: 1px ;background-color: #6600FF;height: 3px;width: 0%;}
		.task_process_progress_time{background-color: #9999FF;color: #3300FF;display: none;}
    </style>
</head>
<body>
<div class="task_center">

    <div class="task_tools_bar">
		<div class="task_tools_title"  level="<?php echo ($task_list['T_level']); ?>">任务 <?php echo ($task_id); ?>: <?php echo ($task_list['T_title']); ?></div>
        <div class="task_win_close"><span>关闭</span></div>
        <div class="task_remove" tid="<?php echo ($task_id); ?>" style="margin: 5px;float: right;background-color: #CC0000;"><span>删除</span></div>
		<div class="task_set_templet" ><span><?php if($task_list['T_templet'] == 1): ?>取消周期任务<?php else: ?>设为周期任务<?php endif; ?></span></div>
		<div class="task_win_submit" ><span>更新任务</span></div>

		<div class="task_process_box">
			<span class="task_process_step" style="background-color: #7FFFD4;" sta="1"><span class="task_process_point" <?php if($task_list['T_status'] == 1): ?>style="display: inline;"<?php endif; ?>>▶</span>准备</span>
			<span class="task_process_step" style="background-color: #66CC00;" sta="2"><span class="task_process_point" <?php if($task_list['T_status'] == 2): ?>style="display: inline;"<?php endif; ?>>▶</span>运行</span>
			<span class="task_process_step" style="background-color: #CC33FF;" sta="3"><span class="task_process_point" <?php if($task_list['T_status'] == 3): ?>style="display: inline;"<?php endif; ?>>▶</span>暂停</span>
			<span class="task_process_step" style="background-color: #CCFF00;" sta="4"><span class="task_process_point" <?php if($task_list['T_status'] == 4): ?>style="display: inline;"<?php endif; ?>>▶</span>等待</span>
			<span class="task_process_step" style="background-color: #CC3300;" sta="5"><span class="task_process_point" <?php if($task_list['T_status'] == 5): ?>style="display: inline;"<?php endif; ?>>▶</span>停止</span>
			<span class="task_process_step" style="background-color: #330000;" sta="6"><span class="task_process_point" <?php if($task_list['T_status'] == 6): ?>style="display: inline;"<?php endif; ?>>▶</span>完成</span>
			<span class="task_process_step" style="background-color: #696969;" sta="7"><span class="task_process_point" <?php if($task_list['T_status'] == 7): ?>style="display: inline;"<?php endif; ?>>▶</span>放弃</span>
		</div>
		<div class="task_process_progress_box">
			<div class="task_process_progress_status"></div>
			<div class="task_process_progress_time"></div>
		</div>
    </div>
    <FORM method="post" action="/myt/index.php/Task/update_task/tid/<?php echo ($task_id); ?>/">
        任务标题：<INPUT type="text" name="T_title" size="50" value="<?php echo ($task_list['T_title']); ?>"><br/>
        任务级别：<select name="T_level">
        <?php if($task_list['T_level'] == 1): ?><option value="1" selected="selected">一般</option>
        <?php else: ?>
        <option value="1">一般</option><?php endif; ?>
        <?php if($task_list['T_level'] == 2): ?><option value="2" selected="selected">重要</option>
            <?php else: ?>
            <option value="2">重要</option><?php endif; ?>
        <?php if($task_list['T_level'] == 3): ?><option value="3" selected="selected">重要紧急</option>
            <?php else: ?>
            <option value="3">重要紧急</option><?php endif; ?>
        <?php if($task_list['T_level'] == 4): ?><option value="4" selected="selected">重要不紧急</option>
            <?php else: ?>
            <option value="4">重要不紧急</option><?php endif; ?>
        <?php if($task_list['T_level'] == 5): ?><option value="5" selected="selected">非常重要</option>
            <?php else: ?>
            <option value="5">非常重要</option><?php endif; ?>
    </select><BR/>
        预计开始
        日期: <input type="date" name="T_d_start" value="<?php echo (date("Y-m-d",$task_list['T_date'])); ?>"/>
        时间: <input type="time" name="T_t_start" value="<?php echo (date("H:i",$task_list['T_date'])); ?>">
        预计用时:
        <select name="T_exp_time">
            <option value="0">0分</option>
            <option value="300">5分</option>
            <option value="600">10分</option>
            <option value="900">15分</option>
            <option value="1200">20分</option>
            <option value="1800">30分</option>
            <option value="2700">45分</option>
            <option value="3600">60分</option>
            <option value="5400">90分</option>
            <option value="7200">120分</option>
            <option value="14400">240分</option>
            <option value="<?php echo ($T_exp_time); ?>" selected="selected"><?php echo (round($T_exp_time / 60 )); ?>分</option>
        </select>
        <div class="predict_end_time_div">
            预计结束
            日期: <input type="date" name="T_expd_end" value="<?php echo (date("Y-m-d",$task_list['T_date'] + $T_exp_time)); ?>"/>
            时间: <input type="time" name="T_expt_end" value="<?php echo (date("H:i",$task_list['T_date'] + $T_exp_time)); ?>">
        </div>
        <br/>
        <textarea id="editor_id" name="T_content" style="width:790px;height:400px;"><?php echo ($task_list['T_content']); ?></textarea><BR/>
		<input type="hidden" name="T_id" value="<?php echo ($task_id); ?>"/>
	</FORM>
</div>
</body>
</html>