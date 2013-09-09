<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
        $task_lib = D('lib');
        $this->title = "任务调度器";
        $task_list = $task_lib->select();
        $lib_action = new LibAction();
        /*
        * 测试 Unixtime 转换成可以用date array;
        *
        $p = new PublicAction();
        print_r( $p->split_date(time()-7200));
        */

        // date("Y-n-j") ,不带 前导零日期.
        $get_date = is_null($_GET['date']) ? date("Y-m-d") : $_GET['date'];
		$cur_date = date("Y-m-d");
        $last_month['1'] = date("Y-m-d",strtotime("-1 month"));
		$last_month['2'] = date("Y-m-d",strtotime("-2 month"));
		$last_month['3'] = date("Y-m-d",strtotime("-3 month"));
        $last_month['4'] = date("Y-m-d",strtotime("-4 month"));
		$last_month['5'] = date("Y-m-d",strtotime("-5 month"));
		$last_month['6'] = date("Y-m-d",strtotime("-6 month"));
		$next_month['1'] = date("Y-m-d",strtotime("+1 month"));
		$next_month['2'] = date("Y-m-d",strtotime("+2 month"));
		$next_month['3'] = date("Y-m-d",strtotime("+3 month"));
		$next_month['4'] = date("Y-m-d",strtotime("+4 month"));
		$next_month['5'] = date("Y-m-d",strtotime("+5 month"));
		$next_month['6'] = date("Y-m-d",strtotime("+6 month"));

        $cal_date = $lib_action->show_task_cal($get_date);
        $task_list_cur = $lib_action->show_task_today( );
        $task_list_delay = $lib_action->show_task_delay( );
        $task_list_attention = $lib_action->show_task_attention( );
        $cal_date_task = $lib_action->show_task(date("Y-m-d"));


        $this->assign('cal_date',$cal_date);
        $this->assign('cal_date_task',$cal_date_task);
        $this->assign('last_month',$last_month);
        $this->assign('next_month',$next_month);
        $this->assign("cur_date",$cur_date);
        $this->assign("task_list_cur",$task_list_cur);
        $this->assign("task_list_delay",$task_list_delay);
        $this->assign("task_list_attention",$task_list_attention);
		$this->display();
    }
}