<?php
namespace Home\Controller;
use Think\Controller;
class TaskController extends Controller {
    public function index(){
        //$this->title = (C("DEBUG_MODE") == 1 ) ? "[Dev]任务调度器" : "任务调度器";
        //$task_lib = D('lib');
        //$field = "t_id,t_title,t_level,t_status,t_content";
        //$field_level = "t_level,count(*) AS total";
        //$field_status = "t_status,count(*) AS total";
        //$where = "t_status < 6";
        //$this->unfinished_task = $task_lib->where($where)->field($field)->order("t_level desc")->select();
    }

    public function show(){
        $tid = I(tid);
        if(strlen($tid) == 0) echo "null";

        $task_lib = D('lib');
        $field = "t_id,t_title,t_level,t_status,t_content";
        $where = "t_id = " . $tid;
        $this->task = $task_lib->field($field)->find($tid);

        $this->display();
    }
}
