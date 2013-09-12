<?PHP
class TaskAction extends Action {
    public function create_task( $date){
		$tid = isset($_REQUEST['tid']) ? $_REQUEST['tid'] : "" ;
		$task_lib = D('lib');

		$templet_arr = $task_lib->find($tid);
		
		$this->assign('templet_arr',$templet_arr);
        $this->assign('date',$date);
        $this->assign('time',$time = ( $date == date("Y-m-d")) ? date("H:i") : "09:00");
        $this->display();
    }

    public function edit_task( $tid ){
        $task_lib = D('lib');
		$lib_action = new LibAction();
        $task_list = $task_lib->find($tid);
		$task_status = strip_tags($lib_action->show_task_status( $tid ));

        $this->assign('task_id',$tid);
        $this->assign('task_list',$task_list);
		$this->assign('task_status',$task_status);
        $this->display();
    }

    public function delete_task( $tid ){
        $task_lib = D('lib');
        $task_list = $task_lib->delete($tid);
        if ($task_list > 0 ){
            echo "数据删除成功";
            echo "<script>self.opener.location.reload();window.close();</script>";
        } else{
            echo "<span class=\"task_win_close\" style=\"float: right;background-color: #CC0000\">关闭</span><br><br>";
            echo "数据删除失败";
        }

    }

    public function update_task( ){
            $task_lib = D('lib');

            if( $task_lib->create()){
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
                    echo "<script>self.opener.location.reload();</script>";
					header("Location:/myt/index.php/Task/edit_task/tid/".$_REQUEST['T_id']."/");
                }else{
					//echo "<span class=\"task_win_close\" style=\"float: right;background-color: #CC0000\">关闭</span><br><br>";
                    echo "失败";
					header("Location:/myt/index.php/Task/edit_task/tid/".$_REQUEST['T_id']."/");
                }
            }else{
                //echo "<span class=\"task_win_close\" style=\"float: right;background-color: #CC0000\">关闭</span><br><br>";
                echo "失败";
				header("Location:/myt/index.php/Task/edit_task/tid/".$_REQUEST['T_id']."/");
            }
        }

	public function update_task_status(){
		$task_lib = D('lib');
		
		// echo "tid: ".$_REQUEST['tid'].",status: ".$_REQUEST['status'];
		$res = $task_lib->where('T_id='.$_REQUEST['tid'])->setField('T_status',$_REQUEST['status']);
		if( $res  ){
			echo "成功";
		} else {
			echo "失败";	
		}
	}


	public function update_task_templet(){
		$task_lib = D('lib');
		
		// echo "tid: ".$_REQUEST['tid'].",status: ".$_REQUEST['status'];
		$res = $task_lib->where('T_id='.$_REQUEST['tid'])->setField('T_templet', 1);
		if( $res  ){
			echo "设为模板成功";
		} else {
			echo "己经是模板或设为模板失败";	
		}
	}

    public function add_task( ){
        $task_lib = D('lib');

        if($task_lib->create()){
            /* //input type=datetime-local 返回的时间格式: 2013-09-12T06:06
            list($task_date,$task_time) = split("T",$task_lib->T_date);
            */
            list( $year,$month,$day )= split("-",$_REQUEST['T_d_start']);
            list( $hour,$minute )= split(":",$_REQUEST['T_t_start']);
            $task_lib->T_date = mktime( $hour, $minute, 0, $month ,$day ,$year);

            //echo $_REQUEST['T_time'], $task_lib->T_time."TEST<BR>";

            $task_lib->C_date = time();
            // echo 出 T_date 时间的值.
            //echo "失败".$task_lib->T_date;

            $process_arr = array(
                "predict_start_time" => "",      // 预计 开始时间.
                "predict_end_time" => "",        // 预计 结束时间.
                "run_total_time" => "",          // 运行总时间.
                "run_start_time" => "",          // 运行开始时间
                "run_end_time" => "",            // 运行结束时间
                "pause_total_time" => "",       // 暂停总时间
                "pause_start_time" => "",       // 暂停开始时间
                "pause_end_time" => "",         // 暂停结速时间
                "wait_total_time" => "",        // 等待总时间
                "wait_start_time" => "",        // 等待开始时间
                "wait_end_time" => "",          // 等待结速时间
                "stop_total_time" => "",        // 停止总时间
                "stop_start_time" => "",        // 停止开始时间
                "stop_end_time" => "",          // 停止结速时间
                "done_time" => "",              // 完成时间
                "forgo_time" => "",             // 放弃时间

            );

            $res = $task_lib->add();
            if($res){
                echo "<script>TaskWindow.opener.location.reload();</script>";
				header("Location:/myt/index.php/Task/create_task/date/".date("Y-m-d",mktime( $hour, $minute, 0, $month ,$day ,$year))."/");
                echo "成功";
            }else{
				echo "<span class=\"task_win_close\" style=\"float: right;background-color: #CC0000\">关闭</span><br><br>";
                echo "失败";
            }
        }else{
            echo "<script>TaskWindow.opener.location.reload();</script>";
            header("Location:/myt/index.php/Task/create_task/date/".date("Y-m-d",mktime( $hour, $minute, 0, $month ,$day ,$year))."/");
			echo "失败2";
        }
    }


    public function update_task_process( $tid ){
        $task_lib = D('lib');


        $process_arr1 = json_encode( $process_arr);
        echo $process_arr1."<BR>";
        $process_arr2 =  json_decode($process_arr1, true);
        print_r($process_arr2);
        echo "<BR>". $process_arr2['run']['start_time']."<BR>";


        // echo "tid: ".$_REQUEST['tid'].",status: ".$_REQUEST['status'];
        $res = $task_lib->where("T_id = '500000027'")->setField('T_process', $process_arr1);
        if( $res ){
            echo "成功";
        }else{
            echo "失败";
        }

    }
}