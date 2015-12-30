<?PHP
function show_level_tag( $level ){
    $level_tag = "";
    while ( $level > 0 ){
        $level_tag .= "★";
        $level--;
    }
   return "<font color=\"#336600\">".$level_tag."</font>";
}

function show_level_text( $level ){
    switch( $level ){
        case $level < 2 :
            $bg_color = "#00CC00";
            $title = "一般";
            break;
        case $level < 3 :
            $bg_color = "#9966CC";
            $title = "重要";
            break;
        case $level < 4 :
            $bg_color = "#FF9900";
            $title = "重要紧急";
            break;
        case $level < 5 :
            $bg_color = "#FF3300";
            $title = "重要不紧急";
            break;
        default :
            $bg_color = "#FF0000";
            $title = "非常重要";
    }

   return $title;
}

function show_level_color( $level ){
    $text = "";
    switch( $level ){
        case $level < 2 :
            $text = "default";
            break;
        case $level < 3 :
            $text = "success";
            break;
        case $level < 4 :
            $text = "info";
            break;
        case $level < 5 :
            $text = "warning";
            break;
        default :
            $text = "danger";
    }

   return $text;
}

function show_status_text( $status ){
    $text = "<span style=\"background-color: ";
    switch( $status ){
        case STATUS_NOTSTART:
            $text .= "#7FFFD4;\">未开始";
            break;
        case STATUS_RUNING:
            $text .= "#66CC00;\">运行";
            break;
        case STATUS_PAUSE:
            $text .= "#CC33FF;\">暂停";
            break;
        case STATUS_WAITING:
            $text .= "#CCFF00;\">等待";
            break;
        case STATUS_STOP:
            $text .= "#CC3300;\">停止";
            break;
        case STATUS_FINIED:
            $text .= "#330000;\">完成";
            break;
        case STATUS_DISCARD:
            $text .= "#696969;\">放弃";
            break;
        default :
            $text = "NONE";
    }
    $text .= "</span>";

   return $text;
}

