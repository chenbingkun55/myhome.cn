<?PHP
class LibAction extends Action {
    // 用来显示出一张日历,传入参为年,月,日 例如: ( 2013,08,01 )
    public function show_cal( $d ){
        list($year, $month, $day ) = split("-",$d);
        $month_L = ( $month-1) < 10 ? '0'.( $month-1) : ( $month-1);
        $month_R = ( $month+1) < 10 ? '0'.( $month+1) : ( $month+1);
       // echo $year, $month, $day,$month_L,$month_R ."TEST<BR>";


        $cal_start = date("N",mktime(0, 0, 0, $month , 1 , $year)) == 1 ? 8 : date("N",mktime(0, 0, 0, $month , 1 , $year));
        $cal_M_day = date("t",mktime(0, 0, 0, $month , 1 , $year));
        $cal_L_day = date("t",mktime(0, 0, 0, $month_L  ,1, $year));

        $cal_data = array();
        $cal_index=0;
        $cal_max_mnu = 42;

        for($i=$cal_start - 2 ;$i>= 0;$i-- ){
            $day_i = ( $cal_L_day - $i) < 10 ? '0'.( $cal_L_day - $i) : ( $cal_L_day - $i);
            $cal_data = array_merge($cal_data,array( $cal_index =>array( "day"=>$year."-".$month_L."-".($day_i),"box"=>"<div class=\"day_box_date\" style=\"background-color:#996666;\">".$month_L."月".$day_i."号<BR>".$this->show_task($year."-".$month_L."-".($day_i))."</div>")));
            $cal_index++;
            $cal_max_mnu--;
        }

            for($i=1;$i<= $cal_M_day;$i++){
                $day_i = $i < 10 ? '0'.$i : $i;
                $cal_data = array_merge($cal_data,array( $cal_index =>array( "day"=>$year."-".$month."-".($day_i),"box"=>"<div class=\"day_box_date\" style=\"background-color:#FFFF99;\">".$month."月".$day_i."号<BR>".$this->show_task($year."-".($month)."-".($day_i))."</div>")));
                $cal_index++;
                $cal_max_mnu--;
        }

        for($i=1;$i<= $cal_max_mnu;$i++){
            $day_i = $i < 10 ? '0'.$i : $i;
            $cal_data = array_merge($cal_data,array( $cal_index =>array( "day"=>$year."-".$month_R."-".($day_i),"box"=>"<div class=\"day_box_date\" style=\"background-color:#99CCFF;\">".$month_R."月".$day_i."号<BR>".$this->show_task($year."-".$month_R."-".($day_i))."</div>")));
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
            $task_list_g .= "<div class=\"day_box_min\" val=".$task_list[$i]['T_level']." title=\"".$title."\" style=\"background-color:".$bg_color.";\"><font color=\"white\"><B>".$task_list[$i]['num']."</B><BR>".$public_action->show_level($task_list[$i]['T_level'])."</font></div>";
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
                switch( $task_list[$i]['T_date'] ){
                    case $task_list[$i]['T_date'] < time()-14400 :
                        $bg_color = "#FF0000";
                        $title = "任务己过去4小时";
                        break;
                    case $task_list[$i]['T_date'] < time()-7200 :
                        $bg_color = "#FFFF00";
                        $title = "任务己过去2小时";
                        break;
                    case $task_list[$i]['T_date'] < time()-1800 :
                        $bg_color = "#9966CC";
                        $title = "任务己过去30分钟";
                        break;
                    case $task_list[$i]['T_date'] < time() :
                        $bg_color = "#00CC00";
                        $title = "当前要做任务";
                        break;
                    default :
                        $bg_color = "#CCFFCC";
                        $title = "今天未完成任务";
                }

                // 当天任务 按重要与否 标注星星.
                $list_array = array_merge($list_array,array( $i =>array( "tid"=>$task_list[$i]['T_id'],"box"=>"<div  class=\"day_box_date\" title=".$title." style=\"background-color:".$bg_color.";\">".date("H:i",$task_list[$i]['T_date'])." ".$public_action->show_level($task_list[$i]['T_level'])."</div><div>".$task_list[$i]['T_title']."</div>")));
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
            if( $task_list[$i]['T_level'] > 4 ) continue;
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
            $list_array = array_merge($list_array,array( $i =>array( "tid"=>$task_list[$i]['T_id'],"box"=>"<div class=\"day_box_date\" title=".$title." style=\"background-color:".$bg_color.";\">".date("m-d",$task_list[$i]['T_date'])." ".date("H:i",$task_list[$i]['T_date'])." ".$public_action->show_level($task_list[$i]['T_level'])."</div><div>".$task_list[$i]['T_title']."</div>")));
        }

        return $list_array;
    }

    public function show_task_attention( ){
        $task_lib = D('lib');
        $list_array = array();

        $public_action = new PublicAction();

        list( $year,$month,$day )= split("-",date("Y-m-d"));

        $today_start = mktime(0,0,0,$month,$day,$year);
        //echo $year,$month,$day."TESET".$today_start." ".$today_end;

        $task_list = $task_lib->where("T_date < '".$today_start."'")->order('T_date')->select();

        for($i=0;$i< count($task_list);$i++){
            if( $task_list[$i]['T_level'] > 4 ) {
                switch( $task_list[$i]['T_date'] ){
                    case $task_list[$i]['T_date'] < ( $today_start - 432000 ) :
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
                    case $task_list[$i]['T_date'] <  ( $today_start ):
                        $bg_color = "#00CC00";
                        $title = "己延期1天任务";
                        break;
                    default :
                        $bg_color = "#00CC00";
                        $title = "没延期";
                }

                // 当天任务 按重要与否 标注星星.
                $list_array = array_merge($list_array,array( $i =>array( "tid"=>$task_list[$i]['T_id'],"box"=>"<div  class=\"day_box_date\" title=".$title." style=\"background-color:".$bg_color.";\">".date("m-d",$task_list[$i]['T_date'])." ".date("H:i",$task_list[$i]['T_date'])." ".$public_action->show_level($task_list[$i]['T_level'])."</div><div>".$task_list[$i]['T_title']."</div>")));
            }
        }
        return $list_array;
    }

    public function show_level_task( $date ,$level ){
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
            echo "<div class=\"task_level_line\" onClick=\"TaskEdit(".$task_list[$i]['T_id'].");\" style=\"background-color:".$bg_color."\"><span>".($i+1).". ".$task_list[$i]['T_title']."</span></div>" ;
        }
    }
}