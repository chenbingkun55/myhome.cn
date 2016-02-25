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

        $field = "t_id,t_date,t_process,t_exp_time,t_title,t_level,t_status,t_content";
        $where = "t_id = " . $data["t_id"];
        $this->task = $task_lib->field($field)->find($data["t_id"]);

        if( ! is_array($this->task)) {
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('TASK_ID_NOT_FOUND')."</div>");
        }

        $process_arr =  json_decode($this->task['t_process'], true);
        $this->done_precent = get_progress_num($this->task['t_exp_time'],$process_arr['run_total_time']);
        $this->display();
    }

    public function search_list(){
        $task_lib = D('lib');
        $data = from_data();

        $trim_search_data = trim($data['search']);
        $where = "t_title like '%".addslashes($trim_search_data)."%' OR t_content like '%".addslashes($trim_search_data)."%' ";

        $this->search_list = $task_lib->where($where)->select();
        $this->display();
    }

    public function templet_list(){
        $task_lib = D('lib');
        $index_num = 1;

        $field = "t_id,t_title";
        $where = "t_templet = 1";

        $templet_list = $task_lib->where($where)->select();

        echo "<li><a href=\"#\" onClick=\"$.task_add(0);\">".$index_num." - 空模板</a></li>";
        foreach($templet_list as $item){
            $index_num++;
            echo "<li><a href=\"#\" onClick=\"$.task_add(".$item['t_id'].");\">".$index_num." - ".$item['t_title']."</a></li>";
        }
    }

    public function add(){
        $task_lib = D("lib");
        $data = from_data();
        $field = "t_title,t_level,t_status,t_content";
        $where = "t_templet = 1 AND t_id = ".$data["t_id"];

        $this->templet_task = NULL;
        if(strlen($data["t_id"]) != 0) {
            $this->templet_task = $task_lib->where($where)->field($field)->find();
        }

        $this->display();
    }

    public function add_handle(){
       $task_lib = D("lib");
       $data = from_data();
       $data["t_date"] = strtotime($data["exp_startdate"]);
       $exp_end_time = strtotime($data["exp_enddate"]);
       $exp_total_time = $exp_end_time - $data["t_date"];
       $data["t_exp_time"] = $exp_total_time;
       $data["c_date"] = time();

        $data["t_process"] = json_encode(process_init($exp_total_time,$data['t_date'],$exp_end_time)) ;

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

    public function level_list(){
        $task_lib = D('lib');
        $data = from_data();
        $field = "t_id,t_date,t_title,t_level,t_status";
        $where = "t_level = ".$data["t_level"] ." AND t_status < 6";

        if(strlen($data["t_level"]) == 0) {
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('TASK_LEVEL_NOT_NULL')."</div>");
        }

        $this->level_list = $task_lib->where($where)->field($field)->order("t_date desc")->select();

        if( ! is_array($this->level_list)) {
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('LEVEL_LIST_NULL')."</div>");
        }

        $this->display();
    }


    public function status_list(){
        $task_lib = D('lib');
        $data = from_data();
        $field = "t_id,t_date,t_title,t_level,t_status";

        if(strlen($data["t_status"]) == 0) {
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('TASK_STATUS_NOT_NULL')."</div>");
        }

        $this->status_list = $task_lib->where("t_status = ".$data["t_status"])->field($field)->order("t_date desc")->select();

        if( ! is_array($this->status_list)) {
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('STATUS_LIST_NULL')."</div>");
        }

        $this->display();
    }

    public function get_level(){
        $task_lib = D('lib');
        $data = from_data();

        if(strlen($data["t_id"]) == 0) {
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('TASK_ID_NOT_NULL')."</div>");
        }

       $re_level = $task_lib->where("t_id = ".$data["t_id"])->getField('t_level');
       echo show_level_tag($re_level);
    }

    public function up_title(){
        $task_lib = D('lib');
        $data = from_data();

        if(strlen($data["t_id"]) == 0) {
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('TASK_ID_NOT_NULL')."</div>");
        }

        if(strlen($data["t_title"]) == 0) {
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('TASK_TITLE_NOT_NULL')."</div>");
        }

       $re = $task_lib->where("t_id = ".$data["t_id"])->count();
       if( $re != 1){
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('TASK_ID_NOT_FOUND')."</div>");
        }

        $task_lib->where("t_id = ".$data["t_id"])->setField('t_title',$data["t_title"]);
    }


    public function up_level(){
        $task_lib = D('lib');
        $data = from_data();

        if(strlen($data["t_id"]) == 0) {
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('TASK_ID_NOT_NULL')."</div>");
        }

       $re = $task_lib->where("t_id = ".$data["t_id"])->count();
       if( $re != 1){
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('TASK_ID_NOT_FOUND')."</div>");
        }

       $cur_level = $task_lib->where("t_id = ".$data["t_id"])->getField('t_level');

       $to_level = ++$cur_level;
       if($to_level < 0 ||$to_level > 5 ){
           $to_level = 1;
       }

        $task_lib->where("t_id = ".$data["t_id"])->setField('t_level',$to_level);
       echo show_level_tag($to_level);
    }

    public function change_to_status(){
        $task_lib = D('lib');
        $data = from_data();

        if($data["t_status"] == STATUS_RESTART){
            $data["t_status"] = STATUS_NOTSTART;
        }

        if(strlen($data["t_id"]) == 0) {
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('TASK_ID_NOT_NULL')."</div>");
        }

       $re = $task_lib->where("t_id = ".$data["t_id"])->count();
       if( $re != 1){
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('TASK_ID_NOT_FOUND')."</div>");
        }

       $cur_status = $task_lib->where("t_id = ".$data["t_id"])->getField('t_status');

        $task_lib->where("t_id = ".$data["t_id"])->setField('t_status',$data["t_status"]);
        $this->update_task_process($data["t_id"],$cur_status,$data["t_status"]);
    }

    public function auto_update_runing_process( $tid ){
        $task_lib = D('lib');
        $data = from_data();

        if(strlen($data["t_id"]) == 0) {
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('TASK_ID_NOT_NULL')."</div>");
        }

       $process_json = $task_lib->where("t_id = ".$data["t_id"])->getField('t_process');
       if(strlen($process_json) == 0 ){
           $process_arr = process_init(600,time(),time());
       } else {
           $process_arr =  json_decode($process_json, true);
           $process_arr['run_end_time'] = time();
           $process_arr['run_total_time'] += ($process_arr['run_start_time'] > $process_arr['run_end_time'] ) ?  0 : ( $process_arr['run_end_time'] - $process_arr['run_start_time'] );
           $process_arr['run_start_time'] = time();
       }

	   $task_lib->where('t_id='.$data['t_id'])->setField('t_process', json_encode( $process_arr));
       show_process($process_json);
    }

    public function auto_update_runing_progress( $tid ){
        $task_lib = D('lib');
        $data = from_data();

        if(strlen($data["t_id"]) == 0) {
            die("<div class=\"alert alert-danger\" role=\"alert\">".L('TASK_ID_NOT_NULL')."</div>");
        }

       $process_json = $task_lib->where("t_id = ".$data["t_id"])->getField('t_process');
       show_progress($process_json,true);
    }

    public function update_task_process( $tid ,$before_status,$status ){
        $task_lib = D('lib');
        $task_list = $task_lib->find($tid);

        $process_arr =  json_decode($task_list['t_process'], true);

        switch( $before_status.$status ){
			case "01" :
                $process_arr['start_time'] = time();
                break;
			case "02":
				$process_arr['run_start_time'] = time();
				$process_arr['run_end_time'] = time();
                $process_arr['run_total_time'] = 0;
                break;
			case "03":
				$process_arr['pause_start_time'] = time();
				$process_arr['pause_end_time'] = time();
                $process_arr['pause_total_time'] = 0;
                break;
			case "04":
				$process_arr['wait_start_time'] = time();
				$process_arr['wait_end_time'] = time();
                $process_arr['wait_total_time'] = 0;
                break;
			case "05":
				$process_arr['stop_start_time'] = time();
				$process_arr['stop_end_time'] = time();
                $process_arr['stop_total_time'] = 0;
                break;
			case "06" :
                $process_arr['done_time'] = time();
                break;
			case "07" :
                $process_arr['forgo_time'] = time();
                break;
			case "12":
                // 状态: 运行
                $process_arr['run_start_time'] = $process_arr['start_time'] = time();
                break;
            case "21":
                $process_arr = process_init($task_list['t_exp_time'],$task_list['t_date'],$task_list['t_date'] + $task_list['t_exp_time']);
                break;
            case "23":
                // 状态: 暂停
                $process_arr['run_end_time'] = time();
                $process_arr['run_total_time'] += ( $process_arr['run_end_time'] - $process_arr['run_start_time']  )  ;
                $process_arr['pause_start_time'] = time();
              break;
            case "24":
                // 状态: 等待
                $process_arr['run_end_time'] = time();
                $process_arr['run_total_time'] += ( $process_arr['run_end_time'] - $process_arr['run_start_time'] );
                $process_arr['wait_start_time'] = time();
                break;
            case "25":
                // 状态: 停止
                $process_arr['run_end_time'] = time();
                $process_arr['run_total_time'] += ( $process_arr['run_end_time'] - $process_arr['run_start_time'] );
                $process_arr['stop_start_time'] = time();
                break;
            case "26":
                // 状态: 完成
                $process_arr['run_end_time'] = time();
                $process_arr['run_total_time'] += ( $process_arr['run_end_time'] - $process_arr['run_start_time'] );
                $process_arr['done_time'] = time();
                break;
            case "27":
                $process_arr['run_end_time'] = time();
                $process_arr['run_total_time'] += ( $process_arr['run_end_time'] - $process_arr['run_start_time'] ) ;
                $process_arr['forgo_time'] = time();
                break;
            case "17":
                $process_arr['forgo_time'] = time();
                break;
            case "32":
                // 状态: 暂停
                $process_arr['pause_end_time'] = time();
                $process_arr['pause_total_time'] += ( $process_arr['pause_end_time'] - $process_arr['pause_start_time']  ) ;
                $process_arr['run_start_time'] = time();
              break;
            case "34":
                // 状态: 暂停
                $process_arr['pause_end_time'] = time();
                $process_arr['pause_total_time'] += ( $process_arr['pause_end_time'] - $process_arr['pause_start_time'] ) ;
                $process_arr['wait_start_time'] = time();
              break;
            case "35":
                // 状态: 暂停
                $process_arr['pause_end_time'] = time();
                $process_arr['pause_total_time'] += ( $process_arr['pause_end_time'] - $process_arr['pause_start_time'])  ;
                $process_arr['stop_start_time'] = time();
              break;
            case "36":
                // 状态: 暂停
                $process_arr['pause_end_time'] = time();
                $process_arr['pause_total_time'] += ( $process_arr['pause_end_time'] - $process_arr['pause_start_time'] )  ;
                $process_arr['done_time'] = time();
              break;
            case "37":
                // 状态: 暂停
                $process_arr['pause_end_time'] = time();
                $process_arr['pause_total_time'] += ( $process_arr['pause_end_time'] - $process_arr['pause_start_time'] )  ;
                $process_arr['forgo_time'] = time();
              break;
            case "42":
                $process_arr['wait_end_time'] = time();
                $process_arr['wait_total_time'] += ( $process_arr['wait_end_time'] - $process_arr['wait_start_time'] )  ;
                $process_arr['run_start_time'] = time();
              break;
            case "43":
                $process_arr['wait_end_time'] = time();
                $process_arr['wait_total_time'] += ( $process_arr['wait_end_time'] - $process_arr['wait_start_time'] ) ;
                $process_arr['pause_start_time'] = time();
              break;
            case "45":
                $process_arr['wait_end_time'] = time();
                $process_arr['wait_total_time'] += ( $process_arr['wait_end_time'] - $process_arr['wait_start_time'] )  ;
                $process_arr['stop_start_time'] = time();
                break;
            case "46":
                $process_arr['wait_end_time'] = time();
                $process_arr['wait_total_time'] += ( $process_arr['wait_end_time'] - $process_arr['wait_start_time'] ) ;
                $process_arr['done_time'] = time();
                break;
            case "47":
                $process_arr['wait_end_time'] = time();
                $process_arr['wait_total_time'] += (  $process_arr['wait_end_time'] - $process_arr['wait_start_time'] ) ;
                $process_arr['forgo_time'] = time();
                break;
            case "52":
                $process_arr['stop_end_time'] = time();
                $process_arr['stop_total_time'] += ( $process_arr['stop_end_time'] - $process_arr['stop_start_time'] ) ;
                $process_arr['run_start_time'] = time();
                break;
            case "53":
                $process_arr['stop_end_time'] = time();
                $process_arr['stop_total_time'] += ( $process_arr['stop_end_time'] - $process_arr['stop_start_time'] );
                $process_arr['pause_start_time'] = time();
                break;
            case "54":
                $process_arr['stop_end_time'] = time();
                $process_arr['stop_total_time'] += ( $process_arr['stop_end_time'] - $process_arr['stop_start_time'] )  ;
                $process_arr['wait_start_time'] = time();
                break;
            case "56":
                $process_arr['stop_end_time'] = time();
                $process_arr['stop_total_time'] += ( $process_arr['stop_end_time'] - $process_arr['stop_start_time'] )  ;
                $process_arr['done_time'] = time();
                break;
            case "57":
                $process_arr['stop_end_time'] = time();
                $process_arr['stop_total_time'] += ( $process_arr['stop_end_time'] - $process_arr['stop_start_time'] ) ;
                $process_arr['forgo_time'] = time();
                break;
            case "68":
            case "61":
				$process_arr['exp_total_time'] = $task_list['t_exp_time'];
                $process_arr['exp_start_time'] = $task_list['t_date'];
                $process_arr['exp_end_time'] = ( $task_list['t_date'] + $task_list['t_exp_time'] ) ;
                $process_arr['done_time'] = "";
				$process_arr['start_time'] = "";
				$process_arr['forgo_time'] = "";
                $process_arr['run_total_time'] = 0;
                $process_arr['run_start_time'] = "";
                $process_arr['run_end_time'] = "";
                $process_arr['pause_total_time'] = 0;
                $process_arr['pause_start_time'] = "";
                $process_arr['pause_end_time'] = "";
                $process_arr['wait_total_time'] = 0;
                $process_arr['wait_start_time'] = "";
                $process_arr['wait_end_time'] = "";
                $process_arr['stop_total_time'] = 0;
                $process_arr['stop_start_time'] = "";
                $process_arr['stop_end_time'] = "";
                break;
            case "62":
                $process_arr['done_time'] = "";
                break;
            case "78":
            case "71":
				$process_arr['exp_total_time'] = $task_list['t_exp_time'];
                $process_arr['exp_start_time'] = $task_list['t_date'];
                $process_arr['exp_end_time'] = ( $task_list['t_date'] + $task_list['t_exp_time'] ) ;
                $process_arr['forgo_time'] = "";
				$process_arr['start_time'] = "";
				$process_arr['done_time'] = "";
                $process_arr['run_total_time'] = 0;
                $process_arr['run_start_time'] = "";
                $process_arr['run_end_time'] = "";
                $process_arr['pause_total_time'] = 0;
                $process_arr['pause_start_time'] = "";
                $process_arr['pause_end_time'] = "";
                $process_arr['wait_total_time'] = 0;
                $process_arr['wait_start_time'] = "";
                $process_arr['wait_end_time'] = "";
                $process_arr['stop_total_time'] = 0;
                $process_arr['stop_start_time'] = "";
                $process_arr['stop_end_time'] = "";
                break;
            case "72":
                $process_arr['forgo_time'] = "";
                break;
            default :
                // 状态运行严格按上面的定义执行，如果没有定义过的，运行状态将不可用。
                $process_arr = null;
        }

		if( is_array( $process_arr ) ){
			$res = $task_lib->where('t_id='.$tid)->setField('t_process', json_encode( $process_arr));
		}
    }
}
