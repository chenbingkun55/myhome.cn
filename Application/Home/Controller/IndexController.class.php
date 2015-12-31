<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->title = (C("DEBUG_MODE") == 1 ) ? "[Dev]任务调度器" : "任务调度器";
        $task_lib = D('lib');
        $field = "t_id,t_date,t_title,t_level,t_status,t_content";
        $field_level = "t_level,count(*) AS total";
        $field_status = "t_status,count(*) AS total";
        $where = "t_status < 6";
        $this->unfinished_task = $task_lib->where($where)->field($field)->order("t_level desc")->select();
        $this->unfinished_task_level_group = $task_lib->where($where)->field($field_level)->group("t_level")->order("t_level")->select();
        $this->unfinished_task_status_group = $task_lib->where($where)->field($field_status)->group("t_status")->order("t_status")->select();
        $this->month_level_data = $this->month_level_chart_data();

		$this->display();
    }

    public function month_level_chart_data(){
        $task_lib = D('lib');
        $field_level_data = "t_level,count(*) AS total";
        $ld = $task_lib->field($field_level_data)->group("t_level")->select();

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

    public function overview(){
        $this->title = (C("DEBUG_MODE") == 1 ) ? "[Dev]任务概要" : "任务概要";
        $task_lib = D('lib');
        $task_list = $task_lib->field($field)->select();

		$this->display();
    }
}
