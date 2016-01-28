<?PHP
function show_level_tag( $level ){
    $level_tag = "";
    while ( $level > 0 ){
        $level_tag .= "★";
        $level--;
    }
   return "<font color=\"#336600\">".$level_tag."</font>";
}

function show_level_text( $level ){
    switch( $level ){
        case $level < 2 :
            $bg_color = "#00CC00";
            $title = "一般";
            break;
        case $level < 3 :
            $bg_color = "#9966CC";
            $title = "重要";
            break;
        case $level < 4 :
            $bg_color = "#FF9900";
            $title = "重要紧急";
            break;
        case $level < 5 :
            $bg_color = "#FF3300";
            $title = "重要不紧急";
            break;
        default :
            $bg_color = "#FF0000";
            $title = "非常重要";
    }

   return $title;
}

function show_level_color( $level ){
    $text = "";
    switch( $level ){
        case $level < 2 :
            $text = "default";
            break;
        case $level < 3 :
            $text = "success";
            break;
        case $level < 4 :
            $text = "info";
            break;
        case $level < 5 :
            $text = "warning";
            break;
        default :
            $text = "danger";
    }

   return $text;
}

function show_status_color( $status ){
    $color = "";
    switch( $status ){
        case STATUS_NOTSTART:
            $color = "default";
            break;
        case STATUS_RUNING:
            $color = "primary";
            break;
        case STATUS_PAUSE:
            $color = "info";
            break;
        case STATUS_WAITING:
            $color = "warning";
            break;
        case STATUS_STOP:
            $color = "danger";
            break;
        case STATUS_FINIED:
            $color = "success";
            break;
        case STATUS_DISCARD:
            $color = "danger";
            break;
        default :
            $color = "NONE";
    }

   return $color;
}

function show_status_text( $status ){
    $text = "";
    switch( $status ){
        case STATUS_NOTSTART:
            $text = "未开始";
            break;
        case STATUS_RUNING:
            $text = "运行";
            break;
        case STATUS_PAUSE:
            $text = "暂停";
            break;
        case STATUS_WAITING:
            $text = "等待";
            break;
        case STATUS_STOP:
            $text = "停止";
            break;
        case STATUS_FINIED:
            $text = "完成";
            break;
        case STATUS_DISCARD:
            $text = "放弃";
            break;
        default :
            $text = "NONE";
    }

   return $text;
}

function show_status_list(){
    for($status = 1; $status < 8; $status++){
        if($status == STATUS_RUNING) continue;
        echo "<li><a href=\"#\" onClick=\"$.to_status(".$status.")\"><h4><span class=\"col-md-12 label label-".show_status_color($status)." change_to_status\" type=\"button\">".show_status_text($status)."</span></h4></a></li>";
    }
}

function get_progress_num($exp_time,$run_time){
    $precent = number_format(($run_time/$exp_time)*100,2);
    return ($precent > 100) ? 100 : $precent;
}

function show_run_time($process_json){
    $process_arr =  json_decode($process_json, true);
    echo  show_time($process_arr['run_total_time']);
}

function show_progress($process_json){
    $process_arr =  json_decode($process_json, true);

    $done_precent = get_progress_num($process_arr['exp_total_time'],$process_arr['run_total_time']);
    echo "<div class=\"panel\">
          <div class=\"progress-bar progress-bar-success\" role=\"progressbar\" aria-valuenow=\"40\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: ".$done_precent."%\">
                <span style=\"white-space:nowrap;\">Complete: ".$done_precent."%</span>
        </div>
        </div>";

    if($process_arr['run_total_time'] > $process_arr['exp_total_time']) {
        $warning_time = $process_arr['run_total_time'] - $process_arr['exp_total_time'];
        $warning_precent = get_progress_num($process_arr['exp_total_time'],$warning_time);

        echo "<div class=\"panel\">
              <div class=\"progress-bar progress-bar-warning\" role=\"progressbar\" aria-valuenow=\"40\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: ".$warning_precent."%\">
                    <span style=\"white-space:nowrap;\">OverTime: ".$warning_precent."%</span>
            </div>
            </div>";
    }
}

function show_process($process_json){
    $process_arr =  json_decode($process_json, true);

    echo "<div class=\"panel\" style=\"text-align: left;\">";
    echo ($process_arr["start_time"] == 0) ? "<small>开始时间: N/A</small><BR>" : "开始时间: ".date("Y年m月d日 h:i",$process_arr["start_time"])."<BR>";
    echo ($process_arr["run_total_time"] == 0) ? "运行时间: <span class=\"runing_task_run_total_time\">N/A</span><BR>" : "运行时间:  <span class=\"runing_task_run_total_time\">".show_time($process_arr["run_total_time"])."</span><BR>";
    echo ($process_arr["pause_total_time"] == 0) ? "暂停时间: N/A<BR>" : "暂停时间: ".show_time($process_arr["pause_total_time"])."<BR>";
    echo ($process_arr["wait_total_time"] == 0) ? "等待时间: N/A<BR>" : "等待时间: ".show_time($process_arr["wait_total_time"])."<BR>";
    echo ($process_arr["stop_total_time"] == 0) ? "停止时间: N/A<BR>" : "停止时间: ".show_time($process_arr["stop_total_time"])."<BR>";
    echo ($process_arr["done_time"] == 0) ? "完成时间: N/A<BR>" : "完成时间:".date("Y年m月d日 h:i",$process_arr["done_time"])."<BR>";
    echo ($process_arr["forgo_time"] == 0) ? "放弃时间: N/A<BR>" : "放弃时间: ". date("Y年m月d日 h:i",$process_arr["forgo_time"])."<BR>";
    echo "</div>";
}

function process_init($exp_total_time, $exp_start_time,$exp_end_time){
    $process_arr = array(
        "exp_total_time" => $exp_total_time,      // 预计 总时间.
        "exp_start_time" => $exp_start_time,                          // 预计 开始时间.
        "exp_end_time" =>  $exp_end_time,                              // 预计 结束时间.
        "run_total_time" => 0,          // 运行总时间.
        "run_start_time" => "",          // 运行开始时间
        "run_end_time" => "",            // 运行结束时间
        "pause_total_time" => 0,       // 暂停总时间
        "pause_start_time" => "",       // 暂停开始时间
        "pause_end_time" => "",         // 暂停结速时间
        "wait_total_time" => 0,        // 等待总时间
        "wait_start_time" => "",        // 等待开始时间
        "wait_end_time" => "",          // 等待结速时间
        "stop_total_time" => 0,        // 停止总时间
        "stop_start_time" => "",        // 停止开始时间
        "stop_end_time" => "",          // 停止结速时间
        "start_time" => "",              // 开始时间
        "done_time" => "",              // 完成时间
        "forgo_time" => "",            // 放弃时间
    );

    return $process_arr;
}

function show_time($time){
    return gmstrftime("%H:%M:%S",$time);
}

function from_data(){
    if ( ! IS_POST && ! IS_GET ){
        die("<div class=\"alert alert-danger\" role=\"alert\">".L('QUERY_MODE_DENY')."</div>");
    }

    // From 表单字段 与数据库表字段映射。
    $column_array = array(
        "tid" => "t_id",
        "tdate" => "t_date",
        "exp_startdate" => "exp_startdate",
        "exp_enddate" => "exp_enddate",
        "title" => "t_title",
        "content" => "t_content",
        "level" => "t_level",
        "status" => "t_status",
        "templet" => "t_templet",
        "is_close" => "is_close",
        "search" => "search",
    );

    $data = array();
    foreach($column_array as $key => $col_name) {
        if(strlen(I($key)) != 0) {
            $data[$col_name] = I($key);
        }
    }

    $data["t_last_date"] = time();

    return $data;
}
