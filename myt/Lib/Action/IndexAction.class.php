<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
        $task_lib = D('lib');
        $this->title = "任务调度器";
        $task_list = $task_lib->select();
        $lib_action = new LibAction();

        // date("Y-n-j") ,不带 前导零日期.
        $cur_date = is_null($_GET['date']) ? date("Y-m-d") : $_GET['date'];
        $cal_date = $lib_action->show_cal($cur_date);
        $task_list_cur = $lib_action->show_task(date("Y-m-d"));


        $this->assign('cal_date',$cal_date);
        $this->assign("cur_date",$cur_date);
        $this->assign("task_list_cur",$task_list_cur);
		$this->display();
    }
}