<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->title = (C("DEBUG_MODE") == 1 ) ? "[Dev]任务调度器" : "任务调度器";
        $task_lib = D('lib');
        $task_list = $task_lib->select();

		$this->display();
    }

    public function overview(){
        $this->title = (C("DEBUG_MODE") == 1 ) ? "[Dev]任务概要" : "任务概要";
        $task_lib = D('lib');
        $task_list = $task_lib->select();

		$this->display();
    }
}
