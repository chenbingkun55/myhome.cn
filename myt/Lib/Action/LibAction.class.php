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
            $cal_data = array_merge($cal_data,array( $cal_index =>array( "day"=>$year."-".$month_L."-".($day_i),"box"=>"<div class=\"day_box\" style=\"background-color:#C0C0C0;\">".$month_L."月".$day_i."号</div>")));
            $cal_index++;
            $cal_max_mnu--;
        }

            for($i=1;$i<= $cal_M_day;$i++){
                $day_i = $i < 10 ? '0'.$i : $i;
                $cal_data = array_merge($cal_data,array( $cal_index =>array( "day"=>$year."-".($month)."-".($day_i),"box"=>"<div class=\"day_box\">".$month."月".$day_i."号</div>")));
                $cal_index++;
                $cal_max_mnu--;
        }

        for($i=1;$i<= $cal_max_mnu;$i++){
            $day_i = $i < 10 ? '0'.$i : $i;
            $cal_data = array_merge($cal_data,array( $cal_index =>array( "day"=>$year."-".$month_R."-".($day_i),"box"=>"<div class=\"day_box\" style=\"background-color:#C0C0C0;\">".$month_R."月".$day_i."号</div>")));
            $cal_index++;
        }

    return $cal_data;
   }

    public function show_task( $date ){
        $task_lib = D('lib');
        $list_array = array();

        // 日期格式: 2013-08-26
        list( $year,$month,$day )= split("-",$date);

        $today_start = mktime(0,0,0,$month,$day,$year);
        $today_end = mktime(23,59,59,$month,$day,$year);
        //echo $year,$month,$day."TESET".$today_start." ".$today_end;

        $task_list = $task_lib->where("T_date between '". $today_start."' and '".$today_end."'" )->order('T_date')->select();
        for($i=0;$i< count($task_list);$i++){
            switch( $task_list[$i]['T_date'] ){
                case $task_list[$i]['T_date'] < time()-14400 :
                    $bg_color = "#FF0000";
                    $title = "任务己超4小时";
                    break;
                case $task_list[$i]['T_date'] < time()-7200 :
                    $bg_color = "#FFFF00";
                    $title = "任务己超2小时";
                    break;
                case $task_list[$i]['T_date'] < time()-1800 :
                    $bg_color = "#6600FF";
                    $title = "任务己超30分钟";
                    break;
                case $task_list[$i]['T_date'] < time() :
                    $bg_color = "#00CC00";
                    $title = "当前要做任务";
                    break;
                default :
                    $bg_color = "#";
                    $title = "将来任务";
            }

            // 当天任务 按重要与否 标注星星.
            $list_array = array_merge($list_array,array( $i =>array( "tid"=>$task_list[$i]['T_id'],"box"=>"<div class=\"day_box\" title=".$title." style=\"background-color:".$bg_color.";\">".date("H:i",$task_list[$i]['T_date'])."<BR>".$task_list[$i]['T_title']."</div>")));
        }
        return $list_array;
    }
}