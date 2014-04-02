<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title>创建任务: <?php echo ($date2); ?></title>
    <script type="text/javascript" src="/public/js/jquery-2.0.2.min.js"></script>
    <script type="text/javascript" src="/public/js/all.js"></script>
    <script charset="utf-8" src="/public/kindeditor-4.1.7/kindeditor.js"></script>
    <script charset="utf-8" src="/public/kindeditor-4.1.7/lang/zh_CN.js"></script>
    <script>
        var is_change = false;
		var options = {
				uploadJson : '/myt/index.php/Attached/upload/date/<?php echo ($date); ?>',
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
        body{background-color: #003300; margin: 5px 10px 5px 10px;font-family: 微软雅黑;font-size: 14px;width:800px;height: 600px;}
        input,select{background-color: #FFFFCC; }
		span{cursor:pointer;}
        header,nav,article{padding: 0px;}
        .task_center{position: relative;background-color:#336600;}
        .task_tools_bar{text-align:center; height:50px;position: relative;background-color: #000000;color:#FFFFFF; margin: 10px 0px 10px 0px;}
		.task_tools_title{font-weight:900;overflow:hidden;}
        .task_win_close_create{margin: 5px;background-color: #CC0000;float: right;}
		.task_win_submit{margin: 5px;background-color: #6666FF;float: left;}
		.task_templet{margin: 5px;background-color: #6666FF;float: left;}
		.task_create_week{margin: 5px;background-color: #6666FF;float: left;}
		.task_create_month{margin: 5px; background-color: #6666FF;float: left;}
        .task_create_part{margin: 5px; background-color: #6666FF;float: left;}
		.task_templet_list{position: absolute;background-color: #6666FF;margin: 20px 0px 0px 5px;height: 500px;overflow: auto;}
		.task_templet_line{overflow:hidden;}
    </style>
</head>
<body>
<div class="task_center" >
    <div class="task_tools_bar">
		<div class="task_tools_title">创建新任务 : <?php echo ($date2); ?></div>
        <div class="task_tools_box">
            <span class="task_win_close_create">关闭</span>
			<span class="task_win_close_create" id = "date" >时间</span>
            <span class="task_templet">周期任务▼</span>
            <span class="task_win_submit" >创建任务</span>
            <span class="task_create_week" >一整周</span>
            <span class="task_create_month" >一整月</span>
            <div class="task_create_part" ><span>一段时间</span>
            隔
                <select name="day">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    </select>
            天,直到<input type=date>结束</div>
        </div>
		<div class="task_templet_list"><div class="task_templet_line"></div></div>
		
    </div>

    <FORM method="post" action="/myt/index.php/Task/add_task/"> 
        任务标题：<INPUT type="text" name="T_title" size="50" value="<?php echo ($templet_arr['T_title']); ?>"><br/>
        任务级别：<select name="T_level">
			<?php if($templet_arr['T_level'] == 1): ?><option value="1" selected="selected">一般</option>
			<?php else: ?>
			<option value="1">一般</option><?php endif; ?>
			<?php if($templet_arr['T_level'] == 2): ?><option value="2" selected="selected">重要</option>
				<?php else: ?>
				<option value="2">重要</option><?php endif; ?>
			<?php if($templet_arr['T_level'] == 3): ?><option value="3" selected="selected">重要紧急</option>
				<?php else: ?>
				<option value="3">重要紧急</option><?php endif; ?>
			<?php if($templet_arr['T_level'] == 4): ?><option value="4" selected="selected">重要不紧急</option>
				<?php else: ?>
				<option value="4">重要不紧急</option><?php endif; ?>
			<?php if($templet_arr['T_level'] == 5): ?><option value="5" selected="selected">非常重要</option>
				<?php else: ?>
				<option value="5">非常重要</option><?php endif; ?>
        </select>
        <div class="predict_start_time_div">
            预计开始
            日期: <input type="date" name="T_d_start" value="<?php echo ($date2); ?>"/>
            时间: <input type="time" name="T_t_start" value="<?php echo (date("H:i",$date)); ?>">
            预计用时:<select name="T_exp_time">
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
                <option value="<?php echo ($templet_arr['T_exp_time']); ?>" selected="selected"><?php echo (round($templet_arr['T_exp_time'] / 60 )); ?>分</option>
            </select>
        </div>
        <div class="predict_end_time_div">
            预计结束
            日期: <input type="date" name="T_expd_end" value="<?php echo ($date2); ?>"/>
            时间: <input type="time" name="T_expt_end" value="<?php echo (date("H:i",$date +60 )); ?>">
        </div>
        <textarea id="editor_id" name="T_content" style="width:790px;height:400px;"><?php echo ($templet_arr['T_content']); ?></textarea>

    </FORM>
</div>
</body>
</html>