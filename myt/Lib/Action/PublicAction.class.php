<?php
// 本类由系统自动生成，仅供测试用途
class PublicAction extends Action {
    public function show_level_tag( $level ){
		$level_tag = "";
        while ( $level > 0 ){
            $level_tag .= "★";
            $level--;
        }
       return "<font color=\"#336600\">".$level_tag."</font>";
    }

    public function split_date( $unixtime ){
        $date_arr = array();
        $unixtime = is_null($unixtime) ? time() : $unixtime ;

        $date = date("Y-m-d",$unixtime);
        $time = date("H:i",$unixtime);

        list( $year,$month,$day )= split("-",$date);
        list( $hour,$minute )= split(":",$time);
        $date_arr['Y'] = $year;
        $date_arr['M'] = $month;
        $date_arr['D'] = $day;
        $date_arr['H'] = $hour;
        $date_arr['I'] = $minute;

        return $date_arr;
    }
}