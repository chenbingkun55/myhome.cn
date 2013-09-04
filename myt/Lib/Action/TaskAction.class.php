<?PHP
class TaskAction extends Action {
    public function create_task( $date){
        $this->assign('date',$date);
        $this->assign('time',$time = ( $date == date("Y-m-d")) ? date("H:i") : "09:00");
        $this->display();
    }

    public function edit_task( $tid ){
        $task_lib = D('lib');
        $task_list = $task_lib->find($tid);
        $this->assign('task_id',$tid);
        $this->assign('task_list',$task_list);
        $this->display();
    }

    public function update_task( ){
            $task_lib = D('lib');

            if($task_lib->create()){
                /* //input type=datetime-local 返回的时间格式: 2013-09-12T06:06
                list($task_date,$task_time) = split("T",$task_lib->T_date);
                */
                list( $year,$month,$day )= split("-",$_REQUEST['T_d']);
                list( $hour,$minute )= split(":",$_REQUEST['T_t']);
                $task_lib->T_date = mktime( $hour, $minute, 0, $month ,$day ,$year);

                //echo $_REQUEST['T_time'], $task_lib->T_time."TEST<BR>";

                // echo 出 T_date 时间的值.
                //echo "失败".$task_lib->T_date;

                $res = $task_lib->save();
                if($res){
                    echo "成功";
                    header('Location:/myt');
                }else{
                    echo "失败";
                }
            }else{
                echo "失败";
            }
        }

    public function add_task( ){
        $task_lib = D('lib');

        if($task_lib->create()){
            /* //input type=datetime-local 返回的时间格式: 2013-09-12T06:06
            list($task_date,$task_time) = split("T",$task_lib->T_date);
            */
            list( $year,$month,$day )= split("-",$_REQUEST['T_d']);
            list( $hour,$minute )= split(":",$_REQUEST['T_t']);
            $task_lib->T_date = mktime( $hour, $minute, 0, $month ,$day ,$year);

            //echo $_REQUEST['T_time'], $task_lib->T_time."TEST<BR>";

            $task_lib->C_date = time();
            // echo 出 T_date 时间的值.
            //echo "失败".$task_lib->T_date;

            $res = $task_lib->add();
            if($res){
                echo "成功";
                header('Location:/myt');
            }else{
                echo "失败";
            }
        }else{
            echo "失败";
        }
    }
}