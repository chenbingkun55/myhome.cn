<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->title = (C("DEBUG_MODE") == 1 ) ? "[Dev]任务调度器" : "任务调度器";
        $task_lib = D('lib');
        $field = "t_id,t_title,t_level,t_status,t_content";
        $field_level = "t_level,count(*) AS total";
        $field_status = "t_status,count(*) AS total";
        $where = "t_status < 6";
        $this->unfinished_task = $task_lib->where($where)->field($field)->order("t_level desc")->select();
        $this->unfinished_task_level_group = $task_lib->where($where)->field($field_level)->group("t_level")->order("t_level")->select();
        $this->unfinished_task_status_group = $task_lib->where($where)->field($field_status)->group("t_status")->order("t_status")->select();

		$this->display();
    }

    public function overview(){
        $this->title = (C("DEBUG_MODE") == 1 ) ? "[Dev]任务概要" : "任务概要";
        $task_lib = D('lib');
        $task_list = $task_lib->field($field)->select();

		$this->display();
    }
}
