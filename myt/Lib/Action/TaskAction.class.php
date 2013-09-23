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

        $allow_step = array();
        $before_status = $task_lib->where('T_id='.$_REQUEST['tid'])->getField('T_status');
        switch( $before_status ){
            case 2:
                $allow_step = array('3','4','5','6','7');
                break;
            case 3:
                $allow_step = array('2','4','5','6','7');
                break;
            case 4:
                $allow_step = array('2','3','5','6','7');
                break;
            case 5:
                $allow_step = array('2','3','4','6','7');
                break;
            case 6:
                $allow_step = array('1');
                break;
            case 7:
                $allow_step = array('1');
                break;
            default:
                $allow_step = array('2','7');
                break;
        }
		// echo "tid: ".$_REQUEST['tid'].",status: ".$_REQUEST['status'];
        if( in_array( $_REQUEST['status'], $allow_step,true ) ){
            $res = $task_lib->where('T_id='.$_REQUEST['tid'])->setField('T_status',$_REQUEST['status']);
            if( $res  ){
                echo "成功";
                $this->update_task_process( $_REQUEST['tid'] ,$before_status,$_REQUEST['status'] );
            } else {
                echo "失败";
            }
        } else {
            echo "状态操作不允许!";
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

            list( $year_exp,$month_exp,$day_exp )= split("-",$_REQUEST['T_expd_end']);
            list( $hour_exp,$minute_exp )= split(":",$_REQUEST['T_expt_end']);

            $task_lib->T_date = mktime( $hour, $minute, 0, $month ,$day ,$year);
            $task_lib->T_date_end = mktime( $hour_exp, $minute_exp, 0, $month_exp ,$day_exp ,$year_exp);

            if ( $_REQUEST['T_exp_time'] == 0 ){
                if ( ! isset($_REQUEST['T_expd_start']) && ! isset($_REQUEST['T_expt_start'])){
                    $T_exp_time = ( $task_lib->T_date_end - $task_lib->T_date );
                } else {
                    $T_exp_time = 60;
                }
            } else {
                $T_exp_time = $_REQUEST['T_exp_time'] ;
            }

            $task_lib->T_exp_time = $T_exp_time ;


            //echo $_REQUEST['T_time'], $task_lib->T_time."TEST<BR>";

            $task_lib->C_date = time();
            // echo 出 T_date 时间的值.
            //echo "失败".$task_lib->T_date;

            $process_arr = array(
                "exp_total_time" => $task_lib->T_exp_time,      // 预计 总时间.
                "exp_start_time" => $task_lib->T_date,                          // 预计 开始时间.
                "exp_end_time" => ( $task_lib->T_date + $task_lib->T_exp_time ) ,                              // 预计 结束时间.
                "run_total_time" => 0,          // 运行总时间.
                "run_start_time" => 0,          // 运行开始时间
                "run_end_time" => 0,            // 运行结束时间
                "pause_total_time" => 0,       // 暂停总时间
                "pause_start_time" => 0,       // 暂停开始时间
                "pause_end_time" => 0,         // 暂停结速时间
                "wait_total_time" => 0,        // 等待总时间
                "wait_start_time" => 0,        // 等待开始时间
                "wait_end_time" => 0,          // 等待结速时间
                "stop_total_time" => 0,        // 停止总时间
                "stop_start_time" => 0,        // 停止开始时间
                "stop_end_time" => 0,          // 停止结速时间
				"start_time" => 0,              // 开始时间
                "done_time" => 0,              // 完成时间
                "forgo_time" => 0,            // 放弃时间
            );

            $task_lib->T_process = json_encode( $process_arr ) ;

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

    public function auto_update_task_process( $tid ){
        $task_lib = D('lib');
        $task_list = $task_lib->find($tid);

		$this->update_task_process($tid,0,$task_list['T_status']);
	}

    public function update_task_process( $tid ,$before_status,$status ){
        $task_lib = D('lib');
        $task_list = $task_lib->find($tid);

        $process_arr =  json_decode($task_list['T_process'], true);

        switch( $before_status.$status ){
			case "01" :
			case "06" :
			case "07" :
                break;
			case "02":
				$process_arr['run_end_time'] = time();
                $process_arr['run_total_time'] += ( $process_arr['run_end_time'] - $process_arr['run_start_time']  )  ;
				$process_arr['run_start_time'] = time();
                break;
			case "03":
				$process_arr['pause_end_time'] = time();
                $process_arr['pause_total_time'] += ( $process_arr['pause_end_time'] - $process_arr['pause_start_time']  )  ;
				$process_arr['pause_start_time'] = time();
                break;
			case "04":
				$process_arr['wait_end_time'] = time();
                $process_arr['wait_total_time'] += ( $process_arr['wait_end_time'] - $process_arr['wait_start_time']  )  ;
				$process_arr['wait_start_time'] = time();
                break;
			case "05":
				$process_arr['stop_end_time'] = time();
                $process_arr['stop_total_time'] += ( $process_arr['stop_end_time'] - $process_arr['stop_start_time']  )  ;
				$process_arr['stop_start_time'] = time();
                break;
			case "12":
                // 状态: 运行
                $process_arr['run_start_time'] = $process_arr['start_time'] = time();
                break;
            case "23":
                // 状态: 暂停
                $process_arr['run_end_time'] = time();
                $process_arr['run_total_time'] += ( $process_arr['run_end_time'] - $process_arr['run_start_time']  )  ;
                $process_arr['pause_start_time'] = time();
              break;
            case "24":
                // 状态: 等待
                $process_arr['run_end_time'] = time();
                $process_arr['run_total_time'] += ( $process_arr['run_end_time'] - $process_arr['run_start_time'] );
                $process_arr['wait_start_time'] = time();
                break;
            case "25":
                // 状态: 停止
                $process_arr['run_end_time'] = time();
                $process_arr['run_total_time'] += ( $process_arr['run_end_time'] - $process_arr['run_start_time'] );
                $process_arr['stop_start_time'] = time();
                break;
            case "26":
                // 状态: 完成
                $process_arr['run_end_time'] = time();
                $process_arr['run_total_time'] += ( $process_arr['run_end_time'] - $process_arr['run_start_time'] );
                $process_arr['done_time'] = time();
                break;
            case "27":
                $process_arr['run_end_time'] = time();
                $process_arr['run_total_time'] += ( $process_arr['run_end_time'] - $process_arr['run_start_time'] ) ;
                $process_arr['forgo_time'] = time();
                break;
            case "17":
                $process_arr['forgo_time'] = time();
                break;
            case "32":
                // 状态: 暂停
                $process_arr['pause_end_time'] = time();
                $process_arr['pause_total_time'] += ( $process_arr['pause_end_time'] - $process_arr['pause_start_time']  ) ;
                $process_arr['run_start_time'] = time();
              break;
            case "34":
                // 状态: 暂停
                $process_arr['pause_end_time'] = time();
                $process_arr['pause_total_time'] += ( $process_arr['pause_end_time'] - $process_arr['pause_start_time'] ) ;
                $process_arr['wait_start_time'] = time();
              break;
            case "35":
                // 状态: 暂停
                $process_arr['pause_end_time'] = time();
                $process_arr['pause_total_time'] += ( $process_arr['pause_end_time'] - $process_arr['pause_start_time'])  ;
                $process_arr['stop_start_time'] = time();
              break;
            case "36":
                // 状态: 暂停
                $process_arr['pause_end_time'] = time();
                $process_arr['pause_total_time'] += ( $process_arr['pause_end_time'] - $process_arr['pause_start_time'] )  ;
                $process_arr['done_time'] = time();
              break;
            case "37":
                // 状态: 暂停
                $process_arr['pause_end_time'] = time();
                $process_arr['pause_total_time'] += ( $process_arr['pause_end_time'] - $process_arr['pause_start_time'] )  ;
                $process_arr['forgo_time'] = time();
              break;
            case "42":
                $process_arr['wait_end_time'] = time();
                $process_arr['wait_total_time'] += ( $process_arr['wait_end_time'] - $process_arr['wait_start_time'] )  ;
                $process_arr['run_start_time'] = time();
              break;
            case "43":
                $process_arr['wait_end_time'] = time();
                $process_arr['wait_total_time'] += ( $process_arr['wait_end_time'] - $process_arr['wait_start_time'] ) ;
                $process_arr['pause_start_time'] = time();
              break;
            case "45":
                $process_arr['wait_end_time'] = time();
                $process_arr['wait_total_time'] += ( $process_arr['wait_end_time'] - $process_arr['wait_start_time'] )  ;
                $process_arr['stop_start_time'] = time();
                break;
            case "46":
                $process_arr['wait_end_time'] = time();
                $process_arr['wait_total_time'] += ( $process_arr['wait_end_time'] - $process_arr['wait_start_time'] ) ;
                $process_arr['done_time'] = time();
                break;
            case "47":
                $process_arr['wait_end_time'] = time();
                $process_arr['wait_total_time'] += (  $process_arr['wait_end_time'] - $process_arr['wait_start_time'] ) ;
                $process_arr['forgo_time'] = time();
                break;
            case "52":
                $process_arr['stop_end_time'] = time();
                $process_arr['stop_total_time'] += ( $process_arr['stop_end_time'] - $process_arr['stop_start_time'] ) ;
                $process_arr['run_start_time'] = time();
                break;
            case "53":
                $process_arr['stop_end_time'] = time();
                $process_arr['stop_total_time'] += ( $process_arr['stop_end_time'] - $process_arr['stop_start_time'] );
                $process_arr['pause_start_time'] = time();
                break;
            case "54":
                $process_arr['stop_end_time'] = time();
                $process_arr['stop_total_time'] += ( $process_arr['stop_end_time'] - $process_arr['stop_start_time'] )  ;
                $process_arr['wait_start_time'] = time();
                break;
            case "56":
                $process_arr['stop_end_time'] = time();
                $process_arr['stop_total_time'] += ( $process_arr['stop_end_time'] - $process_arr['stop_start_time'] )  ;
                $process_arr['done_time'] = time();
                break;
            case "57":
                $process_arr['stop_end_time'] = time();
                $process_arr['stop_total_time'] += ( $process_arr['stop_end_time'] - $process_arr['stop_start_time'] ) ;
                $process_arr['forgo_time'] = time();
                break;
            case "61":
				$process_arr['exp_total_time'] = $task_list['T_exp_time'];
                $process_arr['dexp_start_time'] = $task_list['T_date'];
                $process_arr['exp_end_time'] = ( $task_list['T_date'] + $task_list['T_exp_time'] ) ;
                $process_arr['done_time'] = "";
				$process_arr['start_time'] = "";
				$process_arr['forgo_time'] = "";
                $process_arr['run_total_time'] = "";
                $process_arr['run_start_time'] = "";
                $process_arr['run_end_time'] = "";
                $process_arr['pause_total_time'] = "";
                $process_arr['pause_start_time'] = "";
                $process_arr['pause_end_time'] = "";
                $process_arr['wait_total_time'] = "";
                $process_arr['wait_start_time'] = "";
                $process_arr['wait_end_time'] = "";
                $process_arr['stop_total_time'] = "";
                $process_arr['stop_start_time'] = "";
                $process_arr['stop_end_time'] = "";
                break;
            case "71":
				$process_arr['exp_total_time'] = $task_list['T_exp_time'];
                $process_arr['exp_start_time'] = $task_list['T_date'];
                $process_arr['exp_end_time'] = ( $task_list['T_date'] + $task_list['T_exp_time'] ) ;
                $process_arr['forgo_time'] = "";
				$process_arr['start_time'] = "";
				$process_arr['done_time'] = "";
                $process_arr['run_total_time'] = "";
                $process_arr['run_start_time'] = "";
                $process_arr['run_end_time'] = "";
                $process_arr['pause_total_time'] = "";
                $process_arr['pause_start_time'] = "";
                $process_arr['pause_end_time'] = "";
                $process_arr['wait_total_time'] = "";
                $process_arr['wait_start_time'] = "";
                $process_arr['wait_end_time'] = "";
                $process_arr['stop_total_time'] = "";
                $process_arr['stop_start_time'] = "";
                $process_arr['stop_end_time'] = "";
                break;
            default :
                // 状态运行严格按上面的定义执行，如果没有定义过的，运行状态将不可用。
                $process_arr = array();
        }
		
		if( isset( $process_arr ) ){
			$res = $task_lib->where('T_id='.$tid)->setField('T_process', json_encode( $process_arr));

			if ( ! $res ){
				echo "失败";
			}
		} else {
			echo "失败";
		}
    }
}