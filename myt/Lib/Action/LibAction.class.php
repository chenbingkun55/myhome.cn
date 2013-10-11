<?PHP
include("Conf/define.php");  //引入常量定义

class LibAction extends Action {
    public function show_month_task_count( ){
        $task_lib = D('lib');
        $date = ( isset($_REQUEST['date']) ) ? $_REQUEST['date'] : date("Y-m-d");
        list($year, $month, $day ) = split("-",$date);
        $cal_M_day = date("t",mktime(0, 0, 0, $month , 1 , $year));

        $month_start = mktime(0,0,0,$month,1,$year);
        $month_end = mktime(23,59,59,$month,$cal_M_day,$year);

        $search_where = "T_date between '". $month_start."' and '".$month_end."'";
        $run_task_where = "T_status != 7 and T_status != 6";

        $search_count = $task_lib->where( $search_where )->count();
        $run_task_count = $task_lib->where( $run_task_where )->count();
        $task_list = $task_lib->field('T_level,count(*) as num')->where( $search_where )->group('T_level')->select();

        if($task_list){
            for($i=0;$i< count($task_list);$i++){
                switch( $task_list[$i]['T_level'] ){
                    case $task_list[$i]['T_level'] < 2 :
                        $bg_color = "#00CC00";
                        $title = "一般";
                        break;
                    case $task_list[$i]['T_level'] < 3 :
                        $bg_color = "#9966CC";
                        $title = "重要";
                        break;
                    case $task_list[$i]['T_level'] < 4 :
                        $bg_color = "#FF9900";
                        $title = "重要紧急";
                        break;
                    case $task_list[$i]['T_level'] < 5 :
                        $bg_color = "#FF3300";
                        $title = "重要不紧急";
                        break;
                    default :
                        $bg_color = "#FF0000";
                        $title = "非常重要";
                }
                $task_list_g .= "<div class=\"day_box_min_count\" date=\"".$date."\" val=".$task_list[$i]['T_level']." title=\"".$title."\" style=\"background-color:".$bg_color.";\">".$task_list[$i]['num']."</div>";
            }
            $task_list_g .= "<div style=\"position: relative;float:left;font-size: 11px;text-align:left;\">MT:".$search_count."<br><span class=\"run_task_count\" date=\"".$date."\">RW:".$run_task_count."<span></div>";
        } else {
            $task_list_g .= "<div class=\"day_box_min_count\" date=\"".$date."\" val=\"1\" title=\"一般\" style=\"background-color:#00CC00;\">0</div>";
            $task_list_g .= "<div class=\"day_box_min_count\" date=\"".$date."\" val=\"2\" title=\"重要\" style=\"background-color:#9966CC;\">0</div>";
            $task_list_g .= "<div class=\"day_box_min_count\" date=\"".$date."\" val=\"3\" title=\"重要紧急\" style=\"background-color:#FF9900;\">0</div>";
            $task_list_g .= "<div class=\"day_box_min_count\" date=\"".$date."\" val=\"4\" title=\"重要不紧急\" style=\"background-color:#FF3300;\">0</div>";
            $task_list_g .= "<div class=\"day_box_min_count\" date=\"".$date."\" val=\"5\" title=\"非常重要\" style=\"background-color:#FF0000;\">0</div>";
            $task_list_g .= "<div style=\"position: relative;float:left;font-size: 11px;text-align:left;\" date=\"".$date."\">MT:0<br>RW:0</div>";
        }

        return $task_list_g;
    }

    // 用来显示出一张日历,传入参为年,月,日 例如: ( 2013,08,01 )
    public function show_task_cal( $d ){
        list($year, $month, $day ) = split("-",$d);
        $month_L = ( $month-1) < 10 ? '0'.( $month-1) : ( $month-1);
        $month_R = ( $month+1) < 10 ? '0'.( $month+1) : ( $month+1);
		$view_year = $year == date("Y") ?  "" : $year."年" ;
       // echo $year, $month, $day,$month_L,$month_R ."TEST<BR>";


        $cal_start = date("N",mktime(0, 0, 0, $month , 1 , $year)) == 1 ? 8 : date("N",mktime(0, 0, 0, $month , 1 , $year));
        $cal_M_day = date("t",mktime(0, 0, 0, $month , 1 , $year));
        $cal_L_day = date("t",mktime(0, 0, 0, $month_L  ,1, $year));

        $cal_data = array();
        $cal_index=0;
        $cal_max_mnu = 42;

        for($i=$cal_start - 2 ;$i>= 0;$i-- ){
            $day_i = ( $cal_L_day - $i) < 10 ? '0'.( $cal_L_day - $i) : ( $cal_L_day - $i);
            $show_bg_color = ( $year."-".$month_L."-".($day_i) ) == date("Y-m-d") ? "style=\"background-color: #000000;\"" : "" ;
            $cal_data = array_merge($cal_data,array( $cal_index =>array( "day"=>$year."-".$month_L."-".($day_i),"box"=>"<div class=\"day_box_date\" style=\"background-color:#996666;\">".$view_year.$month_L."月".$day_i."日</div><div  class=\"day_box_conten\" ".$show_bg_color." >".$this->show_task($year."-".$month_L."-".($day_i))."</div>")));
            $cal_index++;
            $cal_max_mnu--;
        }

            for($i=1;$i<= $cal_M_day;$i++){
                $day_i = $i < 10 ? '0'.$i : $i;
                $show_bg_color = ( $year."-".$month."-".($day_i) ) == date("Y-m-d") ? "style=\"background-color: #000000;\"" : "" ;
                $cal_data = array_merge($cal_data,array( $cal_index =>array( "day"=>$year."-".$month."-".($day_i),"box"=>"<div class=\"day_box_date\" style=\"background-color:#FFFF99;\">".$view_year.$month."月".$day_i."日</div><div  class=\"day_box_conten\" ".$show_bg_color." >".$this->show_task($year."-".($month)."-".($day_i))."</div>")));
                $cal_index++;
                $cal_max_mnu--;
        }

        for($i=1;$i<= $cal_max_mnu;$i++){
            $day_i = $i < 10 ? '0'.$i : $i;
            $show_bg_color = ( $year."-".$month_R."-".($day_i) ) == date("Y-m-d") ? "style=\"background-color: #000000;\"" : "" ;
            $cal_data = array_merge($cal_data,array( $cal_index =>array( "day"=>$year."-".$month_R."-".($day_i),"box"=>"<div class=\"day_box_date\" style=\"background-color:#99CCFF;\">".$view_year.$month_R."月".$day_i."日</div><div  class=\"day_box_conten\" ".$show_bg_color." >".$this->show_task($year."-".$month_R."-".($day_i))."</div>")));
            $cal_index++;
        }

     return $cal_data;
    }

    public function show_task( $date ){
       // <div class=\"day_box_min\">TEST</div>
        $task_lib = D('lib');
        $public_action = new PublicAction();
        $task_list_g = "";

        // 日期格式: 2013-08-26
        list( $year,$month,$day )= split("-",$date);

        $today_start = mktime(0,0,0,$month,$day,$year);
        $today_end = mktime(23,59,59,$month,$day,$year);
        //echo $year,$month,$day."TESET".$today_start." ".$today_end;

        $task_list = $task_lib->field('T_level,count(*) as num')->where("T_date between '". $today_start."' and '".$today_end."'" )->group('T_level')->select();

        for($i=0;$i< count($task_list);$i++){
            switch( $task_list[$i]['T_level'] ){
                case $task_list[$i]['T_level'] < 2 :
                    $bg_color = "#00CC00";
                    $title = "一般";
                    break;
                case $task_list[$i]['T_level'] < 3 :
                    $bg_color = "#9966CC";
                    $title = "重要";
                    break;
                case $task_list[$i]['T_level'] < 4 :
                    $bg_color = "#FF9900";
                    $title = "重要紧急";
                    break;
                case $task_list[$i]['T_level'] < 5 :
                    $bg_color = "#FF3300";
                    $title = "重要不紧急";
                    break;
                default :
                    $bg_color = "#FF0000";
                    $title = "非常重要";
            }
            $task_list_g .= "<div class=\"day_box_min\" val=".$task_list[$i]['T_level']." title=\"".$title."\" style=\"background-color:".$bg_color.";\">".$task_list[$i]['num']."</div>";
        }
        return $task_list_g ;
    }


    public function show_task_today( ){
            $task_lib = D('lib');
            $list_array = array();

            $public_action = new PublicAction();
            // 日期格式: 2013-08-26
            list( $year,$month,$day )= split("-",date("Y-m-d"));

            $today_start = mktime(0,0,0,$month,$day,$year);
            $today_end = mktime(23,59,59,$month,$day,$year);
            //echo $year,$month,$day."TESET".$today_start." ".$today_end;

            $task_list = $task_lib->where("T_date between '". $today_start."' and '".$today_end."'" )->order('T_date')->select();
            for($i=0;$i< count($task_list);$i++){
				if( $task_list[$i]['T_level'] > 4 || $task_list[$i]['T_status'] > 5 ) continue;
                $total_time = time() + $task_list[$i]['T_exp_time'] ;
                switch( $task_list[$i]['T_date'] ){
                    case $task_list[$i]['T_date'] < $total_time-14400 :
                        $bg_color = "#FF0000";
                        $title = "任务己过去4小时";
                        break;
                    case $task_list[$i]['T_date'] < $total_time-7200 :
                        $bg_color = "#FFFF00";
                        $title = "任务己过去2小时";
                        break;
                    case $task_list[$i]['T_date'] < $total_time-1800 :
                        $bg_color = "#9966CC";
                        $title = "任务己过去30分钟";
                        break;
                    case $task_list[$i]['T_date'] < $total_time :
                        $bg_color = "#00CC00";
                        $title = "当前要做任务";
                        break;
                    default :
                        $bg_color = "#CCFFCC";
                        $title = "还未完成任务";
                }

                // 当天任务 按重要与否 标注星星.
                $list_array = array_merge($list_array,array( $i =>array( "tid"=>$task_list[$i]['T_id'],"box"=>"<div  class=\"task_box_date\" title=".$title." style=\"background-color:".$bg_color.";\">".date("H:i",$task_list[$i]['T_date'])." ".$public_action->show_level_tag($task_list[$i]['T_level'])."</div><div class=\"day_box_conten\">".$task_list[$i]['T_title']."<br>".$this->show_task_status( $task_list[$i]['T_status'] )."</div>")));
            }
        return $list_array;
    }

    public function show_task_delay( ){
        $task_lib = D('lib');
        $list_array = array();

        $public_action = new PublicAction();

        // 日期格式: 2013-08-26
        list( $year,$month,$day )= split("-",date("Y-m-d"));

        $today_start = mktime(0,0,0,$month,$day,$year);
        //echo $year,$month,$day."TESET".$today_start." ".$today_end;

        $task_list = $task_lib->where("T_date < '".$today_start."'" )->order('T_date')->select();

        for($i=0;$i< count($task_list);$i++){
            if( $task_list[$i]['T_level'] > 4 || $task_list[$i]['T_status'] > 5 ) continue;
            switch( $task_list[$i]['T_date'] ){
                case $task_list[$i]['T_date'] < ( $today_start - 432000 ) :
                    $bg_color = "#FF0000";
                    $title = "严重超期任务";
                    break;
                case $task_list[$i]['T_date'] < ( $today_start - 345600 ) :
                    $bg_color = "#FF0000";
                    $title = "己延期5天任务";
                    break;
                case $task_list[$i]['T_date'] < ( $today_start - 172800 ) :
                    $bg_color = "#FFFF00";
                    $title = "己延期3天任务";
                    break;
                case $task_list[$i]['T_date'] < ( $today_start  - 86400 ) :
                    $bg_color = "#9966CC";
                    $title = "己延期2天任务";
                    break;
                default :
                    $bg_color = "#00CC00";
                    $title = "己延期1天任务";
            }

            // 当天任务 按重要与否 标注星星.
            $list_array = array_merge($list_array,array( $i =>array( "tid"=>$task_list[$i]['T_id'],"box"=>"<div class=\"task_box_date\" title=".$title." style=\"background-color:".$bg_color.";\">".date("m-d",$task_list[$i]['T_date'])." ".date("H:i",$task_list[$i]['T_date'])." ".$public_action->show_level_tag($task_list[$i]['T_level'])."</div><div class=\"day_box_conten\">".$task_list[$i]['T_title']."<br>".$this->show_task_status( $task_list[$i]['T_status'] )."</div>")));
        }

        return $list_array;
    }

    public function show_task_attention( ){
        $task_lib = D('lib');
        $list_array = array();

        $public_action = new PublicAction();

        list( $year,$month,$day )= split("-",date("Y-m-d"));

        $today_start = mktime(0,0,0,$month,$day+7,$year);
		$today = mktime(0,0,0,$month,$day,$year);
        //echo $year,$month,$day."TESET".$today_start." ".$today_end;

        $task_list = $task_lib->where("T_date < '".$today_start."'")->order('T_date')->select();

        for($i=0;$i< count($task_list);$i++){
			if( $task_list[$i]['T_status'] > 5 ) continue;
            if( $task_list[$i]['T_level'] > 4 ) {
                switch( $task_list[$i]['T_date'] ){
					case $task_list[$i]['T_date'] < ( $today - 604800 ) :
                        $bg_color = "#FF0000";
                        $title = "严重超期任务";
                        break;
                    case $task_list[$i]['T_date'] < ( $today - 432000 ) :
                        $bg_color = "#FF0000";
                        $title = "己延期5天任务";
                        break;
                    case $task_list[$i]['T_date'] < ( $today - 172800 ) :
                        $bg_color = "#FFFF00";
                        $title = "己延期3天任务";
                        break;
                    case $task_list[$i]['T_date'] < ( $today  - 86400 ) :
                        $bg_color = "#9966CC";
                        $title = "己延期2天任务";
                        break;
                    case $task_list[$i]['T_date'] <  ( $today ):
                        $bg_color = "#00CC00";
                        $title = "己延期1天任务";
                        break;
                    default :
                        $bg_color = "#CCFFCC";
                        $title = "将来的任务";
                }

                // 当天任务 按重要与否 标注星星.
                $list_array = array_merge($list_array,array( $i =>array( "tid"=>$task_list[$i]['T_id'],"box"=>"<div  class=\"task_box_date\" title=".$title." style=\"background-color:".$bg_color.";\">".date("m-d",$task_list[$i]['T_date'])." ".date("H:i",$task_list[$i]['T_date'])." ".$public_action->show_level_tag($task_list[$i]['T_level'])."</div><div class=\"day_box_conten\">".$task_list[$i]['T_title']."<br>".$this->show_task_status( $task_list[$i]['T_status'] )."</div>")));
            }
        }
        return $list_array;
    }

    public function show_task_level( $date ,$level ){
        $task_lib = D('lib');
        $list_array = array();


        list( $year,$month,$day )= split("-",$date);

        $today_start = mktime(0,0,0,$month,$day,$year);
        $today_end = mktime(23,59,59,$month,$day,$year);
        //echo $year,$month,$day."TESET".$today_start." ".$today_end;

        $task_list = $task_lib->where("T_date between '". $today_start."' and '".$today_end."' and T_level = '".$level."'" )->order('T_date')->select();

        for($i=0;$i< count($task_list);$i++){
            switch( $task_list[$i]['T_level'] ){
                case $task_list[$i]['T_level'] < 2 :
                    $bg_color = "#00CC00";
                    $title = "一般";
                    break;
                case $task_list[$i]['T_level'] < 3 :
                    $bg_color = "#9966CC";
                    $title = "重要";
                    break;
                case $task_list[$i]['T_level'] < 4 :
                    $bg_color = "#FF9900";
                    $title = "重要紧急";
                    break;
                case $task_list[$i]['T_level'] < 5 :
                    $bg_color = "#FF3300";
                    $title = "重要不紧急";
                    break;
                default :
                    $bg_color = "#FF0000";
                    $title = "非常重要";
            }
            echo "<div class=\"task_level_line\"  tid=\"".$task_list[$i]['T_id']."\" style=\"color: #FFFFFF; background-color:".$bg_color.";padding: 0px 10px 0px 10px ;\"><span>".$this->show_task_status( $task_list[$i]['T_status'] )." <span style=\"background-color: #000000;\">".date("H:i",$task_list[$i]['T_date'])."</span> ".$task_list[$i]['T_title']."</span></div>" ;
        }
    }

    public function show_task_day( $date ){
        $task_lib = D('lib');
        $list_array = array();


        list( $year,$month,$day )= split("-",$date);

        $today_start = mktime(0,0,0,$month,$day,$year);
        $today_end = mktime(23,59,59,$month,$day,$year);
        //echo $year,$month,$day."TESET".$today_start." ".$today_end;

        $task_list = $task_lib->where("T_date between '". $today_start."' and '".$today_end."'" )->order('T_date')->select();

        if( $task_list) {
            for($i=0;$i< count($task_list);$i++){
                switch( $task_list[$i]['T_level'] ){
                    case $task_list[$i]['T_level'] < 2 :
                        $bg_color = "#00CC00";
                        $title = "一般";
                        break;
                    case $task_list[$i]['T_level'] < 3 :
                        $bg_color = "#9966CC";
                        $title = "重要";
                        break;
                    case $task_list[$i]['T_level'] < 4 :
                        $bg_color = "#FF9900";
                        $title = "重要紧急";
                        break;
                    case $task_list[$i]['T_level'] < 5 :
                        $bg_color = "#FF3300";
                        $title = "重要不紧急";
                        break;
                    default :
                        $bg_color = "#FF0000";
                        $title = "非常重要";
                }
                echo "<div class=\"task_day_line\" tid=\"".$task_list[$i]['T_id']."\" style=\"color: #FFFFFF; background-color:".$bg_color.";padding: 0px 10px 0px 10px ;\"><span>".($i+1).". ".$this->show_task_status( $task_list[$i]['T_status'] )." <span style=\"background-color: #000000;\">".date("H:i",$task_list[$i]['T_date'])."</span> ".$task_list[$i]['T_title']."</span></div>" ;
            }
        }else {
            echo "<div class=\"task_day_line\" style=\"background-color:#FFFFCC;padding: 0px 10px 0px 10px ;\"> -_~|  今天没有任务</div>" ;
        }
    }

	public function show_task_status( $status_id ){
        $re = $status_id ;
		switch( $re ){
			case ( $re == 7) :
				$str = "<span style=\"background-color: #696969; color: #FFFFFF;\" >放弃</span>";
				break;
			case ( $re == 6) :
				$str = "<span style=\"background-color: #330000; color: #FFFFFF;\" >完成</span>";
				break;
			case ( $re == 5) :
				$str = "<span style=\"background-color: #CC3300; color: #FFFFFF;\" >停止</span>";
				break;
			case ( $re == 4) :
				$str = "<span style=\"background-color: #CCFF00; color: #FFFFFF;\" >等待</span>";
				break;
			case ( $re == 3) :
				$str = "<span style=\"background-color: #CC33FF; color: #FFFFFF;\" >暂停</span>";
				break;
			case ( $re == 2) :
				$str = "<span style=\"background-color: #66CC00; color: #FFFFFF;\" >运行</span>";
				break;
			default :
				$str = "<span style=\"background-color: #7FFFD4; color: #FFFFFF;\" >准备</span>";
				break;
		}
		return $str;
	}
    public function show_task_content( $tid ){
        $task_lib = D('lib');
        $public_action = new PublicAction();
        $task_action = new TaskAction();

        $task_list = $task_lib->find($tid);

        $task_status = strip_tags($this->show_task_status( $task_list['T_status'] ));
        $process_arr =  json_decode($task_list['T_process'], true);

        $use_time = round($process_arr['run_total_time'] / 60 );
        $over_time = round(($task_list['T_exp_time'] - $process_arr['run_total_time']) / 60) ;
        $exp_time = round($task_list['T_exp_time'] /60) ;
        $use_percent = round(( $process_arr['run_total_time'] / $process_arr['exp_total_time'] ) * 100) ;

        $task_action->auto_update_task_process( $tid );


		// print_r( $task_list );
        $this->assign('task_id',$tid);
        $this->assign('task_level_tag', $public_action->show_level_tag( $task_list['T_level'] ));
        $this->assign('task_list',$task_list);
        $this->assign('use_time',$use_time);
        $this->assign('over_time',$over_time);
        $this->assign('exp_time',$exp_time);
        $this->assign('task_status',$task_status);
        $this->assign('use_percent',$use_percent);
        $this->display();
    }

	public function show_task_templet( ){
        $task_lib = D('lib');

        $task_list = $task_lib->where("T_templet = 1")->select();
		if( $task_list ){
            for($i=0;$i< count($task_list);$i++){
                echo "<div class=\"task_templet_line\"  tid=\"".$task_list[$i]['T_id']."\"  style=\"text-align:left;width: 300px; height: 20px ;padding: 2px;\"><span>No ".($i+1).".  ".$task_list[$i]['T_title']."</span></div>" ;
            }
        } else {
            echo "<div class=\"task_templet_line\" style=\"text-align:left;width: 300px; height: 20px ;padding: 2px;\"><span>还没有设置周期任务</span></div>";
        }

	}

    public function task_templet( ){
        $task_lib = D('lib');
        $public_action = new PublicAction();
        $page = $_REQUEST['page'];
        $page_limit_num = PAGE_LINE_NUMBER;

        $search_where = " T_templet = 1 ";
        $search_limit = ( $page > 0 )  ?  ( $page_limit_num * $page ).",".$page_limit_num : "0,".$page_limit_num ;
        $search_date_count = ( $page_limit_num * $page );

        $search_count = $task_lib->where( $search_where )->count();
        $res_data = $task_lib->where( $search_where )->limit( $search_limit )->select();


        if( ! $res_data ){
            $this->assign('no_search_data',"没有搜索到相关周期任务!");
        }

        $search_date_line = "";

        for( $i = 0; $i < count($res_data); $i++){
            $search_date_count++;
            $process_arr =  json_decode($res_data[$i]['T_process'], true);
            $done_time = ($process_arr['done_time'] == 0 ) ? "未完成" : date("Y-m-d H:i", $process_arr['done_time']) ;

            $search_date_line .= "<div tid=\"".$res_data[$i]['T_id']."\" class=\"task_search_data_line\">";
            $search_date_line .= "<span class=\"task_search_data_num_block\">".$search_date_count.".</span>";
            $search_date_line .= "<span class=\"task_search_data_level_block\">".$public_action->show_level_tag($res_data[$i]['T_level'])."</span>";
            $search_date_line .= "<span class=\"task_search_data_status_block\">".$this->show_task_status( $res_data[$i]['T_status'])."</span>";
            $search_date_line .= "<span class=\"task_search_data_title_block\">".$res_data[$i]['T_title']."</span>";
            $search_date_line .= "<span class=\"task_search_data_runtim_block\">".round($process_arr['run_total_time'] / 60)."分</span>";
            $search_date_line .= "<span class=\"task_search_data_done_time_block\">".$done_time."</span>";
            $search_date_line .= "</div>";
        }
        $page_num = ceil ( $search_count / $page_limit_num );

        if( isset($page) ) {
            echo $search_date_line ;
        } else {
            $this->assign('title',"周期任务管理");
            $this->assign('page_num',$page_num);
            $this->assign('total_num',$search_count);
            $this->assign('search_date_line',$search_date_line);
            $this->display();
        }
    }

	public function show_task_process( $tid ){
        $task_lib = D('lib');

        $process_list = $task_lib->where('T_id = '.$tid )->getField('T_process');
		$process_arr =  json_decode($process_list, true);
        $process_arr['exp_start_time'] = ($process_arr['exp_start_time'] == 0) ? ""  : date("Y-m-d H:i",$process_arr['exp_start_time']);
		$process_arr['start_time'] = ($process_arr['start_time'] == 0) ? ""  : date("Y-m-d H:i",$process_arr['start_time']);
		$process_arr['done_time'] = ($process_arr['done_time'] == 0) ? ""  : date("Y-m-d H:i",$process_arr['done_time']);
		$process_arr['forgo_time'] = ($process_arr['forgo_time'] == 0) ? ""  : date("Y-m-d H:i",$process_arr['forgo_time']);

		print_r( json_encode($process_arr) );
	}

    public function task_search( $search_data ){
        $task_lib = D('lib');
        $public_action = new PublicAction();
        $page = $_REQUEST['page'];
        $page_limit_num = PAGE_LINE_NUMBER;

        $trim_search_data = trim($search_data);
        $search_where = " T_title like '%".$trim_search_data."%' OR T_content like '%".$trim_search_data."%' ";
        $search_limit = ( $page > 0 )  ?  ( $page_limit_num * $page ).",".$page_limit_num : "0,".$page_limit_num ;
        $search_date_count = ( $page_limit_num * $page );

        $search_count = $task_lib->where( $search_where )->count();
        $res_data = $task_lib->where( $search_where )->limit( $search_limit )->select();


        if( ! $res_data ){
            $this->assign('no_search_data',"没有搜索到相关任务!");
        }

        $search_date_line = "";

        for( $i = 0; $i < count($res_data); $i++){
            $search_date_count++;
            $process_arr =  json_decode($res_data[$i]['T_process'], true);
            $done_time = ($process_arr['done_time'] == 0 ) ? "未完成" : date("Y-m-d H:i", $process_arr['done_time']) ;

            $search_date_line .= "<div tid=\"".$res_data[$i]['T_id']."\" class=\"task_search_data_line\">";
            $search_date_line .= "<span class=\"task_search_data_num_block\">".$search_date_count.".</span>";
            $search_date_line .= "<span class=\"task_search_data_level_block\">".$public_action->show_level_tag($res_data[$i]['T_level'])."</span>";
            $search_date_line .= "<span class=\"task_search_data_status_block\">".$this->show_task_status( $res_data[$i]['T_status'])."</span>";
            $search_date_line .= "<span class=\"task_search_data_title_block\">".$res_data[$i]['T_title']."</span>";
            $search_date_line .= "<span class=\"task_search_data_runtim_block\">".round($process_arr['run_total_time'] / 60)."分</span>";
            $search_date_line .= "<span class=\"task_search_data_done_time_block\">".$done_time."</span>";
            $search_date_line .= "</div>";
        }
        $page_num = ceil ( $search_count / $page_limit_num );

        if( isset($page) ) {
            echo $search_date_line ;
        } else {
            $this->assign('title',$search_data);
            $this->assign('page_num',$page_num);
            $this->assign('total_num',$search_count);
            $this->assign('search_date_line',$search_date_line);
            $this->display();
        }
    }


    public function task_level( $level ){
        $task_lib = D('lib');
        $public_action = new PublicAction();
        $page = $_REQUEST['page'];
        $page_limit_num = PAGE_LINE_NUMBER;

        $date = ( isset($_REQUEST['date']) ) ? $_REQUEST['date'] : date("Y-m-d");
        list($year, $month, $day ) = split("-",$date);
        $cal_M_day = date("t",mktime(0, 0, 0, $month , 1 , $year));

        $month_start = mktime(0,0,0,$month,1,$year);
        $month_end = mktime(23,59,59,$month,$cal_M_day,$year);


        $search_where = "T_date between '". $month_start."' and '".$month_end."' and T_level = ".$level;
        $search_limit = ( $page > 0 )  ?  ( $page_limit_num * $page ).",".$page_limit_num : "0,".$page_limit_num ;
        $search_date_count = ( $page_limit_num * $page );

        $search_count = $task_lib->where( $search_where )->count();
        $res_data = $task_lib->where( $search_where )->limit( $search_limit )->select();

        if( ! $res_data ){
            $this->assign('no_search_data',"没有搜索到相关级别任务!");
        }

        $level_date_line = "";

        for( $i = 0; $i < count($res_data); $i++){
            $search_date_count++;
            $process_arr =  json_decode($res_data[$i]['T_process'], true);
            $done_time = ($process_arr['done_time'] == 0 ) ? "未完成" : date("Y-m-d H:i", $process_arr['done_time']) ;

            $level_date_line .= "<div tid=\"".$res_data[$i]['T_id']."\" class=\"task_search_data_line\">";
            $level_date_line .= "<span class=\"task_search_data_num_block\">".$search_date_count.".</span>";
            $level_date_line .= "<span class=\"task_search_data_level_block\">".$public_action->show_level_tag($res_data[$i]['T_level'])."</span>";
            $level_date_line .= "<span class=\"task_search_data_status_block\">".$this->show_task_status( $res_data[$i]['T_status'])."</span>";
            $level_date_line .= "<span class=\"task_search_data_title_block\">".$res_data[$i]['T_title']."</span>";
            $level_date_line .= "<span class=\"task_search_data_runtim_block\">".round($process_arr['run_total_time'] / 60)."分</span>";
            $level_date_line .= "<span class=\"task_search_data_done_time_block\">".$done_time."</span>";
            $level_date_line .= "</div>";
        }
        $page_num = ceil ( $search_count / $page_limit_num );

        if( isset($page) ) {
            echo $level_date_line ;
        } else {
            $this->assign('title',"等级任务列表");
            $this->assign('level',$public_action->show_level_tag($level));
            $this->assign('page_num',$page_num);
            $this->assign('total_num',$search_count);
            $this->assign('search_date_line',$level_date_line);
            $this->display();
        }
    }


    public function show_run_task( ){
        $task_lib = D('lib');
        $public_action = new PublicAction();
        $page = $_REQUEST['page'];
        $page_limit_num = PAGE_LINE_NUMBER;


        $search_where = "T_status != 6 and T_status != 7";
        $search_limit = ( $page > 0 )  ?  ( $page_limit_num * $page ).",".$page_limit_num : "0,".$page_limit_num ;
        $search_date_count = ( $page_limit_num * $page );

        $search_count = $task_lib->where( $search_where )->count();
        $res_data = $task_lib->where( $search_where )->limit( $search_limit )->select();

        if( ! $res_data ){
            $this->assign('no_search_data',"没有搜索到未完成的任务!");
        }

        $level_date_line = "";

        for( $i = 0; $i < count($res_data); $i++){
            $search_date_count++;
            $process_arr =  json_decode($res_data[$i]['T_process'], true);
            $done_time = ($process_arr['done_time'] == 0 ) ? "未完成" : date("Y-m-d H:i", $process_arr['done_time']) ;

            $level_date_line .= "<div tid=\"".$res_data[$i]['T_id']."\" class=\"task_search_data_line\">";
            $level_date_line .= "<span class=\"task_search_data_num_block\">".$search_date_count.".</span>";
            $level_date_line .= "<span class=\"task_search_data_level_block\">".$public_action->show_level_tag($res_data[$i]['T_level'])."</span>";
            $level_date_line .= "<span class=\"task_search_data_status_block\">".$this->show_task_status( $res_data[$i]['T_status'])."</span>";
            $level_date_line .= "<span class=\"task_search_data_title_block\">".$res_data[$i]['T_title']."</span>";
            $level_date_line .= "<span class=\"task_search_data_runtim_block\">".round($process_arr['run_total_time'] / 60)."分</span>";
            $level_date_line .= "<span class=\"task_search_data_done_time_block\">".$done_time."</span>";
            $level_date_line .= "</div>";
        }
        $page_num = ceil ( $search_count / $page_limit_num );

        if( isset($page) ) {
            echo $level_date_line ;
        } else {
            $this->assign('title',"未完成任务列表");
            $this->assign('page_num',$page_num);
            $this->assign('total_num',$search_count);
            $this->assign('search_date_line',$level_date_line);
            $this->display();
        }
    }
}