<?php if (!defined('THINK_PATH')) exit();?><div class="show_div_body">
<div class="task_center" >
    <div class="task_tools_bar">
        <div class="task_tools_title"  level="<?php echo ($task_list['T_level']); ?>"><?php echo ($task_level_tag); ?> 任务 <?php echo ($task_id); ?>: <?php echo ($task_list['T_title']); ?></div>
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
            <div class="task_process_progress_status" style="width: <?php echo ($use_percent); ?>%;"></div>
            <div class="task_process_progress_time"></div>
        </div>
    </div><?php echo ($use_percent); ?>%
        任务标题：<INPUT type="text" name="T_title" size="50" value="<?php echo ($task_list['T_title']); ?>" disabled="true"><br/>
        任务级别：<select name="T_level" disabled="true">
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
        日期: <input type="date" name="T_d" value="<?php echo (date("Y-m-d",$task_list['T_date'])); ?>"disabled="true" />
        时间: <input type="time" name="T_t" value="<?php echo (date("H:i",$task_list['T_date'])); ?>" disabled="true">
        &nbsp;<label class="task_process_exp_time">总数: <?php echo ($exp_time); ?>分  己用: <?php echo ($use_time); ?>分  剩余: <?php echo ($over_time); ?>分 </label><br/>
        <div class="task_content" ><?php echo ($task_list['T_content']); ?></div>
		<input type="hidden" name="T_id" value="<?php echo ($task_id); ?>"/>
        <input type="hidden" name="T_id" value="<?php echo ($task_id); ?>" disabled="true"/>
</div>
</div>