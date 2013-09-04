<?PHP
class PopAddAction extends Action {
	public function view_box_conten( $pid,$rid,$uid ){
		$work_resource = M('resource'); 
		$work_leftbar = M('leftbar');
		$where = ( $pid == 0 ) ? "" : "P_id = ".$pid." or P_id = 0" ;
		$arr_re = $work_resource->where( $where )->select();
		$where = ( $pid == 0 ) ? "R_id = ".$rid : "P_id = ".$pid." AND R_id = ".$rid ;
		$arr_lf = $work_leftbar->where( $where )->select();

		for( $i=0; $i < count($arr_re); $i++ ){
			if( $arr_re[$i]['R_id'] != $rid ) continue;
			$rid_index = $i ; 
		}
		echo "<DIV id=\"pop_window_title\" class=\"pop_window_title\">&nbsp;添加-".$arr_re[$rid_index]['R_name']."<DIV id=\"pop_window_title_close\" class=\"pop_window_title_close\" onClick=removeShade();>关闭</DIV></DIV>";
		echo "<DIV id=\"pop_window_conten\" class=\"pop_window_conten\">";
		echo "<form action=\"/PopAdd/add_box_conten/\" method=\"post\" >";
		echo "资源类型: ";
		// 暂时禁用 资源服务器 选择列表,功能还没做好.
		echo "<select id=\"pop_window_re_select\" name=\"R_id\" disabled=\"disabled\">";
		echo "<option value=".$arr_re[$rid_index]['R_id'].">".$arr_re[$rid_index]['R_name']."</option>";
		for( $i=0; $i < count($arr_re); $i++ ){
			if( $arr_re[$i]['R_id'] == $rid ) continue;
			echo "<option value=".$arr_re[$i]['R_id'].">".$arr_re[$i]['R_name']."</option>";
		} 
		echo "</select>";
		echo "<BR>";
		echo "左栏菜单: ";
		echo "<select id=\"pop_window_lf_select\" name=\"LF_id\" >";
		for( $i=0; $i < count($arr_lf); $i++ ){
			echo "<option value=".$arr_lf[$i]['LF_id'].">".$arr_lf[$i]['LF_name']."</option>";
		}
		echo "</select>";
		echo "<BR>";

		$this->view_box_list( $arr_re[$rid_index]['RT_id'] );
		echo "<input name=\"U_id\" type=\"hidden\" value=\"".$uid."\">";
		echo "<input name=\"P_id\" type=\"hidden\" value=\"".$pid."\"><BR>";
		echo "<input name=\"R_id\" type=\"hidden\" value=\"".$arr_re[$rid_index]['R_id']."\"><BR>";
		echo "<input name=\"RT_id\" type=\"hidden\" value=\"".$arr_re[$rid_index]['RT_id']."\"><BR>";
		echo "<input type=\"submit\" value=\"添加\">";
		echo "</form>";
		echo "</DIV>";
	}

	public function view_box_list( $rtid ){
		switch( $rtid ){
			case "1000" :
				echo "服务器名称:<input name=\"S_name\" type=\"text\"><BR>";
				echo "服务器类型:<input name=\"server['S_type']\" type=\"text\"><BR>";
				echo "服务器备注:<input name=\"server['S_note']\" type=\"text\"><BR>";
				echo "IP:<input name=\"server['S_ip1']\" type=\"text\"><BR>";
				echo "子网掩码:<input name=\"server['S_sub1']\" type=\"text\"><BR>";
				echo "IP2:<input name=\"server['S_ip2']\" type=\"text\"><BR>";
				echo "子网掩码2:<input name=\"server['S_sub2']\" type=\"text\"><BR>";
				echo "<input name=\"server['S_env']\" type=\"hidden\" value=\"23456\"><BR>";
				break;
			case "2" :
				echo "文档名称:<input name=\"D_name\" type=\"text\"><BR>";
				echo "文档大小:<input name=\"D_size\" type=\"text\"><BR>";
				echo "文档类型:<input name=\"D_type\" type=\"text\"><BR>";
				echo "文档备注:<input name=\"D_note\" type=\"text\"><BR>";
				echo "路径:<input name=\"D_path\" type=\"text\"><BR>";
				break;
			case "3" :
				echo "密码名称:<input name=\"PA_name\" type=\"text\"><BR>";
				echo "密码类型:<input name=\"PA_type\" type=\"text\"><BR>";
				echo "密码:<input name=\"PA_pass\" type=\"password\"><BR>";
				echo "密码备注:<input name=\"PA_note\" type=\"text\"><BR>";
				echo "创建时间:<input name=\"PA_C_date\" type=\"text\"><BR>";
				echo "失效时间:<input name=\"PA_E_date\" type=\"text\"><BR>";
				echo "<input name=\"PA_disable\" type=\"hidden\" value=\"0\">";
				break;
			case "4" :
				echo "域名称:<input name=\"N_name\" type=\"text\"><BR>";
				echo "网址:<input name=\"N_FQDN\" type=\"text\"><BR>";
				echo "<input name=\"S_id\" type=\"hidden\" value=\"\1\">";
				break;
			case "5" :
				echo "名称:<input name=\"O_name\" type=\"text\"><BR>";
				echo "内容:<input name=\"O_text\" type=\"text\" size=\"20\"><BR>";
				break;
			default :
		}
	}

	public function add_box_conten( ){
		switch( $_POST['RT_id'] ){
			case "1000" :
					$work_server = D("server");
					if( ! $work_server->create()){
						exit( $work_server->getError() );
					} else {
						$work_server->S_base = json_encode( $_POST['server']) ;
						$work_server->C_date = time();
						$work_server->add() ;
						header("Location: /");
					}
				break;
			case "2" :
					$work_documents = D("documents");
					if( ! $work_documents->create()){
						exit( $work_documents->getError() );
					} else {
						$work_documents->C_date = time();
						$work_documents->add() ;
						header("Location: /");
					}
				break;
			case "3" :
					$work_password = D("password");
					if( ! $work_password->create()){
						exit( $work_password->getError() );
					} else {
						$work_password->C_date = time();
						$work_password->add() ;
						header("Location: /");
					}
				break;
			case "4" :
					$work_fqdn = D("fqdn");
					if( ! $work_fqdn->create()){
						exit( $work_fqdn->getError() );
					} else {
						$work_fqdn->C_date = time();
						$work_fqdn->add() ;
						header("Location: /");
					}
				break;
			case "5" :
					$work_othe = D("othe");
					if( ! $work_othe->create()){
						exit( $work_othe->getError() );
					} else {
						$work_othe->C_date = time();
						$work_othe->add() ;
						header("Location: /");
					}
				break;
			default:
				echo "添加失败";
		}		
	}

	public function view_leftbar_box( $lid,$pid,$rid,$uid ){
		$work_resource = M('resource'); 
		
		$arr_re = $work_resource->where("P_id = 0 OR P_id = ".$pid)->select();

		for( $i=0; $i < count($arr_re); $i++ ){
			if( $arr_re[$i]['R_id'] != $rid ) continue;
			$rid_index = $i ; 
		}
		echo "<DIV id=\"pop_window_title\" class=\"pop_window_title\">&nbsp;添加-".$arr_re[$rid_index]['R_name']."-左栏菜单<DIV id=\"pop_window_title_close\" class=\"pop_window_title_close\" onClick=removeShade();>关闭</DIV></DIV>";
		echo "<DIV id=\"pop_window_conten\" class=\"pop_window_conten\">";
		echo "<form action=\"/PopAdd/add_leftbar_box/\" method=\"post\" >";
		echo "资源类型: ";
		echo "<select id=\"pop_window_select\" name=\"R_id\" disabled=\"disabled\">";
		echo "<option value=".$arr_re[$rid_index]['R_id'].">".$arr_re[$rid_index]['R_name']."</option>";
		for( $i=0; $i < count($arr_re); $i++ ){
			if( $arr_re[$i]['R_id'] == $rid ) continue;
			echo "<option value=".$arr_re[$i]['R_id'].">".$arr_re[$i]['R_name']."</option>";
		} 
		echo "</select>";
		echo "<BR>";
		echo "左栏菜单: ";
		echo "<input type=\"text\" name=\"LF_name\"><BR>";
		echo "左栏备注: ";
		echo "<input type=\"text\" name=\"LF_note\">";
		echo "<input name=\"U_id\" type=\"hidden\" value=\"".$uid."\">";
		echo "<input name=\"P_id\" type=\"hidden\" value=\"".$pid."\">";
		echo "<input name=\"R_id\" type=\"hidden\" value=\"".$rid."\">";
		echo "<BR>";
		echo "<input type=\"submit\" value=\"添加\">";
		echo "</form>";
		echo "</DIV>";
	}

	public function add_leftbar_box(){
		$work_leftbar = D("leftbar");
		$work_leftbar->create();
		if( $work_leftbar->add() ){
			header("Location: /");
		}
	}

	public function view_toolbar_box( $lid,$pid,$rid,$uid ){
		if ( $lid == 0 ){
			echo "<DIV id=\"pop_window_title\" class=\"pop_window_title\">&nbsp;添加-位置<DIV id=\"pop_window_title_close\" class=\"pop_window_title_close\" onClick=removeShade();>关闭</DIV></DIV>";
			echo "<DIV id=\"pop_window_conten\" class=\"pop_window_conten\">";
			echo "<form action=\"/PopAdd/add_toolbar_box/\" method=\"post\" >";
			echo "位置: ";
			echo "<input type=\"text\" name=\"L_name\"><BR>";
			echo "位置描述: ";
			echo "<input type=\"text\" name=\"L_note\"><BR>";
			echo "<input name=\"toolbar\" type=\"hidden\" value=\"tool_bar_m1\">";
		}else if( $pid == 0 && $lid != 0 ){
			$work_location = M("location");
			$lo_name = $work_location->where( "L_id = ".$lid )->getField('L_name');
			echo "<DIV id=\"pop_window_title\" class=\"pop_window_title\">&nbsp;添加-".$lo_name."位置的项目<DIV id=\"pop_window_title_close\" class=\"pop_window_title_close\" onClick=removeShade();>关闭</DIV></DIV>";
			echo "<BR>";
			echo "<form action=\"/PopAdd/add_toolbar_box/\" method=\"post\" >";
			echo "位置: ";
			echo $lo_name."<BR>";
			echo "项目名称: ";
			echo "<input type=\"text\" name=\"P_name\"><BR>";
			echo "项目备注: ";
			echo "<input type=\"text\" name=\"P_note\"><BR>";
			echo "<input name=\"toolbar\" type=\"hidden\" value=\"tool_bar_m2\">";
		}else if( $rid == 0 && $lid != 0 && $pid != 0 ){
			$work_location = M("location");
			$work_project = M("project");
			$lo_name = $work_location->where( "L_id = ".$lid )->getField('L_name');
			$pro_name = $work_project->where( "P_id = ".$pid )->getField('P_name');
			echo "<DIV id=\"pop_window_title\" class=\"pop_window_title\">&nbsp;添加->".$lo_name."-位置->".$pro_name."-项目的资源<DIV id=\"pop_window_title_close\" class=\"pop_window_title_close\" onClick=removeShade();>关闭</DIV></DIV>";
			echo "<BR>";
			echo "<form action=\"/PopAdd/add_toolbar_box/\" method=\"post\" >";
			echo "位置: ";
			echo $lo_name."<BR>";
			echo "项目名称: ";
			echo $pro_name."<BR>";
			echo "资源名称: ";
			echo "<input type=\"text\" name=\"R_name\"><BR>";
			echo "资源类型: ";
			echo "<select name=\"R_type\">";
			echo "<option value=\"1\">服务器类型</option>";
			echo "<option value=\"2\">文档类型</option>";
			echo "<option value=\"3\">密码类型</option>";
			echo "<option value=\"4\">网址类型</option>";
			echo "<option value=\"5\">其它类型</option>";
			echo "</select><BR>";
			echo "资源备注: ";
			echo "<input type=\"text\" name=\"P_note\"><BR>";
			echo "<input name=\"toolbar\" type=\"hidden\" value=\"tool_bar_m3\">";
		}
		echo "<input name=\"L_id\" type=\"hidden\" value=\"".$lid."\">";
		echo "<input name=\"P_id\" type=\"hidden\" value=\"".$pid."\">";
		echo "<input name=\"U_id\" type=\"hidden\" value=\"".$uid."\">";
		echo "<BR>";
		echo "<input type=\"submit\" value=\"添加\">";
		echo "</form>";
		echo "</DIV>";
	}

	public function add_toolbar_box(){
		switch( $_POST['toolbar'] ){
			case "tool_bar_m1" :
				$work_location = D("location");
				if( ! $work_location->create()){
					exit( $work_location->getError() );
				} else {
					$work_location->add() ;
					header("Location: /");
				}
				break;
			case "tool_bar_m2" :
				$work_project = D("project");
				if( ! $work_project->create()){
					exit( $work_project->getError() );
				} else {
					$work_project->add() ;
					// 跳转不到
					// header("Location: /Ajax/tool_bar/menu/tool_bar_m2/index/0/lid/".$_POST['L_id']."/pid/0/uid/2/");
					header("Location: /");
				}
				break;
			case "tool_bar_m3" :
				$work_resource = D("resource");
				if( ! $work_resource->create()){
					exit( $work_resource->getError() );
				} else {
					$work_resource->add() ;
					// 跳转不到
					// header("Location: /Ajax/tool_bar/menu/tool_bar_m3/index/0/lid/".$_POST['L_id']."/pid/".$_POST['P_id']."/uid/2/");
					header("Location: /");
				}
				break;
			default :
				header("Location: /");
		}
	}
}
