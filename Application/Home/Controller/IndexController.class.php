<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->title = (C("DEBUG_MODE") == 1 ) ? "[Dev]任务调度器" : "任务调度器";
        $task_lib = D('lib');
        $field = "t_id,t_date,t_title,t_level,t_exp_time,t_process,t_status";
        $field_level = "t_level,count(*) AS total";
        $field_status = "t_status,count(*) AS total";
        $where = "t_status < 6";

        $this->unfinished_task = $task_lib->where($where)->field($field)->order("t_level desc")->select();
        $this->unfinished_task_level_group = $task_lib->where($where)->field($field_level)->group("t_level")->order("t_level")->select();
        $this->unfinished_task_status_group = $task_lib->where($where)->field($field_status)->group("t_status")->order("t_status")->select();

        $temp_arr = array();
        foreach($this->unfinished_task as  $v){
           $process_arr =  json_decode($v['t_process'], true);
            $temp_arr[$v['t_id']] = get_progress_num($v['t_exp_time'],$process_arr['run_total_time']);
        }
        $this->precent_arr = $temp_arr;

		$this->display();
    }

    public function all_level_chart_data(){
        return $this->level_chart_data(null,null);
    }

    public function current_month_level_chart_data(){
        $start_date = strtotime(date("Y-m-01"));
        $end_date = strtotime(date("Y-m-t"));

        return $this->level_chart_data($start_date,$end_date);
    }

    public function level_chart_data($start_date,$end_date){
        $task_lib = D('lib');
        $field_level_data = "t_level,count(*) AS total";
        $where = "";
        if(strlen($start_date) != 0 && strlen($end_date) != 0) {
            $where = "t_date > ".$start_date." AND t_date < ".$end_date;
        }

        $ld = $task_lib->where($where)->field($field_level_data)->group("t_level")->select();

        // 整理数据
        $text_data = "
            type: 'pie',
            name: 'Browser share',
            data: [";
        $text_temp = "";
        $all_total = 0;
        $is_firest = true;

        for($i = 0; $i < count($ld); $i++ ){
            $all_total += $ld[$i]['total'];
        }

        for($i = 0; $i < count($ld); $i++ ){
            if($is_firest){
                $is_firest = false;
                $text_temp .= "{
                    name: '".show_level_text($ld[$i]['t_level'])."(".$ld[$i]['total'].")',
                    y:  ".$ld[$i]['total'].",
                    sliced: true,
                    selected: true},";
            } else {
                $text_temp .= "['".show_level_text($ld[$i]['t_level'])."(".$ld[$i]['total'].")', ".$ld[$i]['total']."],";
            }
        }

        $text_data .= rtrim($text_temp,',')."]";

        return $text_data;
    }

    public function all_status_chart_data(){
        return $this->status_chart_data(null,null);
    }

    public function unfinished_status_chart_data(){
        return $this->status_chart_data(null,null,true);
    }

    public function current_month_status_chart_data(){
        $start_date = strtotime(date("Y-m-01"));
        $end_date = strtotime(date("Y-m-t"));

        return $this->status_chart_data($start_date,$end_date);
    }

    public function status_chart_data($start_date,$end_date,$unfinished_status = false){
        $task_lib = D('lib');
        $field_status_data = "t_status,count(*) AS total";
        $where = "";
        if(strlen($start_date) != 0 && strlen($end_date) != 0) {
            $where = "t_date > ".$start_date." AND t_date < ".$end_date;
        }

        if($unfinished_status) {
            $where = "t_status < 6";
        }

        $ld = $task_lib->where($where)->field($field_status_data)->group("t_status")->select();

        // 整理数据
        $text_data = "
            type: 'pie',
            name: 'Task Status',
            data: [";
        $text_temp = "";
        $all_total = 0;
        $is_firest = true;

        for($i = 0; $i < count($ld); $i++ ){
            $all_total += $ld[$i]['total'];
        }

        for($i = 0; $i < count($ld); $i++ ){
            if($is_firest){
                $is_firest = false;
                $text_temp .= "{
                    name: '".show_status_text($ld[$i]['t_status'])."(".$ld[$i]['total'].")',
                    y:  ".$ld[$i]['total'].",
                    sliced: true,
                    selected: true},";
            } else {
                $text_temp .= "['".show_status_text($ld[$i]['t_status'])."(".$ld[$i]['total'].")', ".$ld[$i]['total']."],";
            }
        }

        $text_data .= rtrim($text_temp,',')."]";

        return $text_data;
    }

    public function year_premonth_chart_column_data(){
        $task_lib = D('lib');
        $where = "";

        // 整理数据
        $text_data = "
            data: [";
        $text_temp = "";
        $all_total = 0;
        $is_firest = true;


        for($i = 0; $i < 12 ; $i++){
            $start_date = strtotime(date("Y-m-01",strtotime('-'.$i.' month')));
            $end_date = strtotime(date("Y-m-t",strtotime('-'.$i.' month')));

            $where = "t_date > ".$start_date." AND t_date < ".$end_date;

            $month_count = $task_lib->where($where)->field($field)->getField('count(*) AS total');
            $text_temp .= "['".date("Y-m",strtotime('-'.$i.' month'))."',".$month_count."],";
        }

        $text_data .= rtrim($text_temp,',')."],";

        return $text_data;
    }

    public function month_list(){
        $task_lib = D('lib');
        $data = from_data();
        $field = "t_id,t_date,t_title,t_level,t_exp_time,t_process,t_status";
        $where = "";

        $start_date = strtotime(date("Y-m-01"));
        $end_date = strtotime(date("Y-m-t"));

        //$start_date = strtotime(date("Y-m-01",strtotime('-'.$i.' month')));
        //$end_date = strtotime(date("Y-m-t",strtotime('-'.$i.' month')));

        $where = "t_date > ".$start_date." AND t_date < ".$end_date;

        return $task_lib->where($where)->field($field)->select();
    }

    public function content_help(){
        $this->display();
    }

    public function content_process(){
    }

    public function content_home(){
        $task_lib = D('lib');
        $field_level = "t_level,count(*) AS total";
        $field_status = "t_status,count(*) AS total";
        $where = "t_status < 6";

        $this->unfinished_task_level_group = $task_lib->where($where)->field($field_level)->group("t_level")->order("t_level")->select();
        $this->unfinished_task_status_group = $task_lib->where($where)->field($field_status)->group("t_status")->order("t_status")->select();
        $this->all_level_data = $this->all_level_chart_data();
        $this->current_month_level_data = $this->current_month_level_chart_data();
        $this->all_status_data = $this->all_status_chart_data();
        $this->current_month_status_data = $this->current_month_status_chart_data();
        $this->unfinished_status_data = $this->unfinished_status_chart_data();
        $this->year_premonth_data = $this->year_premonth_chart_column_data();

        $this->display();
    }

    public function content_list(){
        $task_lib = D('lib');
        $field = "t_id,t_date,t_title,t_level,t_exp_time,t_process,t_status";
        $where_month = "t_date > ".strtotime(date("Y-m-01"))." AND t_date < ".strtotime(date("Y-m-t"));
        $this->month_list = $task_lib->where($where_month)->field($field)->order("t_date desc")->select();

        $this->display();
    }

    public function index_show(){
        $task_lib = D('lib');
        $data = from_data();

        if(strlen($data["t_id"]) == 0) {
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('TASK_ID_NOT_NULL')."</div>");
        }

        $field = "t_id,t_date,t_process,t_exp_time,t_title,t_level,t_status,t_content";
        $this->task = $task_lib->field($field)->find($data['t_id']);

		$this->display();
    }
}
