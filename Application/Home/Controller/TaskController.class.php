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
        if(strlen($tid) == 0) {
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('TASK_ID_NOT_NULL')."</div>");
        }

        if ( ! IS_GET){
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('QUERY_MODE_DENY')."</div>");
        }

        $task_lib = D('lib');
        $field = "t_id,t_date,t_title,t_level,t_status,t_content";
        $where = "t_id = " . $tid;
        $this->task = $task_lib->field($field)->find($tid);

        if( ! is_array($this->task)) {
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('TASK_ID_NOT_FOUND')."</div>");
        }

        $this->display();
    }

    public function save(){
        $tid = I('tid');
        $is_close = I('is_close');
        $content = I('content');

        if(strlen($tid) == 0) {
            die("<div role=\"alert\" class=\"alert alert-danger alert-dismissible fade in\"> <button aria-label=\"Close\" data-dismiss=\"alert\" class=\"close\" type=\"button\"><span aria-hidden=\"true\">×</span></button>".L('TASK_ID_NOT_NULL')."</div>");
        }
        if(strlen($content) == 0) {
            die("<div role=\"alert\" class=\"alert alert-danger alert-dismissible fade in\"> <button aria-label=\"Close\" data-dismiss=\"alert\" class=\"close\" type=\"button\"><span aria-hidden=\"true\">×</span></button>".L('TASK_CONTENT_NOT_NULL')."</div>");
        }


        if ( ! IS_POST ){
            die("<div role=\"alert\" class=\"alert alert-danger alert-dismissible fade in\"> <button aria-label=\"Close\" data-dismiss=\"alert\" class=\"close\" type=\"button\"><span aria-hidden=\"true\">×</span></button>".L('QUERY_MODE_DENY')."</div>");
        }

        $task_lib = (strcmp($is_close,"yes") == 0) ?  M('cache_lib') : M('lib');
        $task_lib->T_content = $content;
        $task_lib->T_id = $tid;
        $task_lib->T_last_date = time();

        if((strcmp($is_close,"yes") == 0) ? $task_lib->add() : $task_lib->save()){
            echo "<div role=\"alert\" class=\"alert alert-success alert-dismissible fade in\"> <button aria-label=\"Close\" data-dismiss=\"alert\" class=\"close\" type=\"button\"><span aria-hidden=\"true\">×</span></button>".L('TASK_SAVE_SUCCESS')."</div>";
        } else {
            echo "<div role=\"alert\" class=\"alert alert-danger alert-dismissible fade in\"> <button aria-label=\"Close\" data-dismiss=\"alert\" class=\"close\" type=\"button\"><span aria-hidden=\"true\">×</span></button>".L('TASK_SAVE_FIALD')."</div>";
        }
    }

    public function change_to_status(){
        $to_status = I('status');
        if(strlen($tid) == 0) {
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('TASK_ID_NOT_NULL')."</div>");
        }

        if ( ! IS_GET){
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('QUERY_MODE_DENY')."</div>");
        }

        $task_lib = D('lib');
        $field = "t_id,t_date,t_title,t_level,t_status,t_content";
        $where = "t_id = " . $tid;
        $this->task = $task_lib->field($field)->find($tid);

    }
}
