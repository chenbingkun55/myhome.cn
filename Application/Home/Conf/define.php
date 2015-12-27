<?php
    define("PAGE_LINE_NUMBER",20);
    define('TASK_TITLE_LEN','20');
    define('TASK_CONTENT_LEN','300');
    define('TASK_PAUSE_SLIDE_NUMBER','3');
    define('TASK_WAITING_SLIDE_NUMBER','3');
    define('TASK_NOTSTART_SLIDE_NUMBER','9');

    // 任务状态 1-未开始,2-运行,3-暂停,4-等待,5-停止,6-完成,7-放弃',
    define("STATUS_NONE",0);
    define("STATUS_NOTSTART",1);
    define("STATUS_RUNING",2);
    define("STATUS_PAUSE",3);
    define("STATUS_WAITING",4);
    define("STATUS_STOP",5);
    define("STATUS_FINIED",6);
    define("STATUS_DISCARD",7);

    // 任务级别 1-绿色,2-蓝色,3-黄色,4-橙色,5-红色
