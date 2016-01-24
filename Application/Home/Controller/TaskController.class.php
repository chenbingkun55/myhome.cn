<?php
namespace Home\Controller;
use Think\Controller;
class TaskController extends Controller {
    public function index(){
        show_status_list();
        //$this->title = (C("DEBUG_MODE") == 1 ) ? "[Dev]任务调度器" : "任务调度器";
        //$task_lib = D('lib');
        //$field = "t_id,t_title,t_level,t_status,t_content";
        //$field_level = "t_level,count(*) AS total";
        //$field_status = "t_status,count(*) AS total";
        //$where = "t_status < 6";
        //$this->unfinished_task = $task_lib->where($where)->field($field)->order("t_level desc")->select();
    }

    public function show(){
        $task_lib = D('lib');
        $data = from_data();

        if(strlen($data["t_id"]) == 0) {
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('TASK_ID_NOT_NULL')."</div>");
        }

        if ( ! IS_GET){
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('QUERY_MODE_DENY')."</div>");
        }

        $field = "t_id,t_date,t_title,t_level,t_status,t_content";
        $where = "t_id = " . $data["t_id"];
        $this->task = $task_lib->field($field)->find($data["t_id"]);

        if( ! is_array($this->task)) {
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('TASK_ID_NOT_FOUND')."</div>");
        }

        $this->display();
    }

    public function add(){
       $task_lib = D("lib");
       $data = from_data();
       $data["c_date"] = time();

       $task_lib->add($data);
    }
    public function delete(){
       $task_lib = D("lib");
        $data = from_data();

        if(strlen($data["t_id"]) == 0) {
            die("<div role=\"alert\" class=\"alert alert-danger alert-dismissible fade in\"> <button aria-label=\"Close\" data-dismiss=\"alert\" class=\"close\" type=\"button\"><span aria-hidden=\"true\">×</span></button>".L('TASK_ID_NOT_NULL')."</div>");
        }

       $task_lib->where("t_id = ".$data['t_id'])->delete();
    }

    public function save(){
        $data = from_data();

        if(strlen($data["t_id"]) == 0) {
            die("<div role=\"alert\" class=\"alert alert-danger alert-dismissible fade in\"> <button aria-label=\"Close\" data-dismiss=\"alert\" class=\"close\" type=\"button\"><span aria-hidden=\"true\">×</span></button>".L('TASK_ID_NOT_NULL')."</div>");
        }
        if(strlen($data["t_content"]) == 0) {
            die("<div role=\"alert\" class=\"alert alert-danger alert-dismissible fade in\"> <button aria-label=\"Close\" data-dismiss=\"alert\" class=\"close\" type=\"button\"><span aria-hidden=\"true\">×</span></button>".L('TASK_CONTENT_NOT_NULL')."</div>");
        }

        $task_lib = (strcmp($data["is_close"],"yes") == 0) ?  M('cache_lib') : M('lib');

        if((strcmp($data["is_close"],"yes") == 0) ? $task_lib->add($data) : $task_lib->save($data)){
            echo "<div role=\"alert\" class=\"alert alert-success alert-dismissible fade in\"> <button aria-label=\"Close\" data-dismiss=\"alert\" class=\"close\" type=\"button\"><span aria-hidden=\"true\">×</span></button>".L('TASK_SAVE_SUCCESS')."</div>";
        } else {
            echo "<div role=\"alert\" class=\"alert alert-danger alert-dismissible fade in\"> <button aria-label=\"Close\" data-dismiss=\"alert\" class=\"close\" type=\"button\"><span aria-hidden=\"true\">×</span></button>".L('TASK_SAVE_FIALD')."</div>";
        }
    }

    public function status_list(){
        $task_lib = D('lib');
        $data = from_data();
        $field = "t_id,t_date,t_title,t_level,t_status";

        if(strlen($data["t_status"]) == 0) {
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('TASK_STATUS_NOT_NULL')."</div>");
        }

        $this->status_list = $task_lib->where("t_status = ".$data["t_status"])->field($field)->select();

        if( ! is_array($this->status_list)) {
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('STATUS_LIST_NULL')."</div>");
        }

        $this->display();
    }

    public function change_to_status(){
        $task_lib = D('lib');
        $data = from_data();

        if(strlen($data["t_id"]) == 0) {
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('TASK_ID_NOT_NULL')."</div>");
        }

       $re = $task_lib->where("t_id = ".$data["t_id"])->count();
       if( $re != 1){
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('TASK_ID_NOT_FOUND')."</div>");
        }

        $task_lib->where("t_id = ".$data["t_id"])->setField($data);
    }
}
