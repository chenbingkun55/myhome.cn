<?php
class AjaxAction extends Action {
   public function tool_bar($menu,$index,$lid,$pid,$uid){
	   	$work_location = M('location');
		$work_project = M('project');
		$work_resource = M('resource');

	   switch( $menu){
			case "tool_bar_m1":
				$arr_lo = $work_location->where("U_id=".$uid)->Field('L_id,L_name')->select();
				
				echo "<DIV id=\"menu\" class=\"menu\" onmouseover=this.style.height=\"".((count($arr_lo)+1)*25)."px\"; onmouseout=this.style.height=\"24px\";>";
				echo "<ul type=\"square\">";
				if ( $index == 0 && $lid == 0 ){
					echo "<li onClick=tool_bar('m1',0,0,0)>所有</li>";
				} else {
					if ( $lid == 0 ){
						echo "<li onClick=tool_bar('m1',".$index.",".$arr_lo[$index-1]['L_id'].",0)>".$arr_lo[$index-1]['L_name']."</li>";
					} else {
						for( $i=0; $i < count($arr_lo); $i++ ){
							if ( $arr_lo[$i]['L_id'] == $lid ) 
								echo "<li onClick=tool_bar('m1',".( $i+1 ).",".$arr_lo[$i]['L_id'].",0)>".$arr_lo[$i]['L_name']."</li>";
							}	
					}
					echo "<li onClick=tool_bar('m1',0,0,0)>所有</li>";
				}

				for( $i=0; $i < count($arr_lo); $i++ ){
					if ( $i == ( $index -1 )) continue;
					echo "<li onClick=tool_bar('m1',".( $i+1 ).",".$arr_lo[$i]['L_id'].",0)>".$arr_lo[$i]['L_name']."</li>";
				}		
				echo "</ul>";
				echo "</DIV>";
				break;
			case "tool_bar_m2":
				$arr_pro = $work_project->where("U_id=".$uid)->Field('L_id,P_id,P_name')->select();
				$count_pro = $work_project->where("L_id=".$lid)->count();

				if ( $lid == 0){
					echo "<DIV id=\"m2\" class=\"menu\" onmouseover=this.style.height=\"".((count($arr_pro)+1)*25)."px\"; onmouseout=this.style.height=\"24px\";>";
				} else {
					echo "<DIV id=\"m2\" class=\"menu\" onmouseover=this.style.height=\"".(($count_pro+1)*25 )."px\"; onmouseout=this.style.height=\"24px\";>";
				}
				echo "<ul type=\"square\">";
				if ( $index == 0 ){
					echo "<li onClick=tool_bar('m2',0,0,0)>所有</li>";
				} else {
					echo "<li onClick=tool_bar('m2',".$index.",".$arr_pro[$lid]['L_id'].",".$arr_pro[$pid-1]['P_id'].")>".$arr_pro[$pid-1]['P_name']."</li>";
					echo "<li onClick=tool_bar('m2',0,0,0)>所有</li>";
				}

				for( $i=0,$j=0; $i < count($arr_pro); $i++ ){
					if ( $i == $pid-1 ) continue;
					if ( $lid == 0 ){
						echo "<li onClick=tool_bar('m2',".( $i+1 ).",".$arr_pro[$i]['L_id'].",".$arr_pro[$i]['P_id'].")>".$arr_pro[$i]['P_name']."</li>";
					} else {
						if ( $lid == $arr_pro[$i]['L_id'] ){
							echo "<li onClick=tool_bar('m2',".( $i+1 ).",".$arr_pro[$i]['L_id'].",".$arr_pro[$i]['P_id'].")>".$arr_pro[$i]['P_name']."</li>";
						}
					}
					
				}		
				echo "</ul>";
				echo "</DIV>";
				break;
			case "tool_bar_m3":
				$arr_re = $work_resource->where("U_id=".$uid)->Field('P_id,R_id,R_name')->select();
				$count_re = $work_resource->where("P_id=".$pid)->count();
				
				if ( $pid == 0 ){
					echo "<DIV id=\"m3\" class=\"menu\" onmouseover=this.style.height=\"".((count($arr_re)+1)*25)."px\"; onmouseout=this.style.height=\"24px\";>";
				} else {
					echo "<DIV id=\"m3\" class=\"menu\" onmouseover=this.style.height=\"".(($count_re+1)*25 )."px\"; onmouseout=this.style.height=\"24px\";>";
				}
				echo "<ul type=\"square\">";
				if ( $index == 0 ){
					echo "<li onClick=left_bar(0,".$pid.",0,0)>所有</li>";
				} else {
					echo "<li onClick=left_bar(0,".$pid.",".$arr_re[$index-1]['R_id'].",0)>".$arr_re[$index-1]['R_name']."</li>";
					echo "<li onClick=left_bar(0,".$pid.",0,0)>所有</li>";
				}

				for( $i=0; $i < count($arr_re); $i++ ){
					// 此处的 $lid 是$rid,因为 tool_bar(str,index,lid,pid) 没有定义$rid 参数,用得不多,暂时先这样子.
					if ( $i ==  $lid-1 ) continue;
					if ( $pid == 0 ){
						echo "<li onClick=left_bar(".( $i+1 ).",0,".$arr_re[$i]['R_id'].",0)>".$arr_re[$i]['R_name']."</li>";
					} else {
						if ( $pid == $arr_re[$i]['P_id'] ){
							echo "<li onClick=left_bar(".( $i+1 ).",".$pid.",".$arr_re[$i]['R_id'].",0)>".$arr_re[$i]['R_name']."</li>";
						}
					}
				}		
				echo "</ul>";
				echo "</DIV>";
				break;
			default:
				echo "默认";
	   }
   }

   public function left_bar($index,$pid,$rid,$lfid,$uid){
		$work_location = M('location');
		$work_project = M('project');
		$work_resource = M('resource');
		$work_leftbar = M('leftbar');
		
		if( $pid == 0 ){
			$pro_name = "所有";
			$arr_re = $work_resource->where("U_id=".$uid )->Field('P_id,R_id,R_name')->select();
			$where = ( $rid == 0 ) ? "U_id = ".$uid : "U_id = ".$uid." AND R_id = ".$rid ;
		} else {
			$pro_name = ( $rid == 0 ) ? $work_project->where("U_id=".$uid." AND P_id = ".$pid )->getField('P_name') : "资源-".$rid;
			$arr_re = $work_resource->where("U_id=".$uid." AND P_id = ".$pid )->Field('P_id,R_id,R_name')->select();
			$where = ( $rid == 0 ) ? "U_id = ".$uid." AND P_id = ".$pid : "U_id = ".$uid." AND P_id = ".$pid." AND R_id = ".$rid ;
		}

		$arr_lfb = $work_leftbar->where( $where )->Field('LF_id,P_id,R_id,LF_name')->select();
		
		switch( $pid ){
			case "0" :
				echo "<DIV class=\"menu_left\">";
				echo "<DIV id=\"left_bar_t\" class=\"left_bar_t\">".$pro_name."</DIV>";
				echo "<ul type=\"square\">";
				for( $i=0; $i < count($arr_re); $i++ ){
					echo "<li onClick=left_bar(".$arr_re[$i]['R_id'].",0,0)>".($i+1).".&nbsp;".$arr_re[$i]['R_name']."</li>";
				}
				echo "</ul>";
				echo "</DIV>";
				break;
			default :
				echo "<DIV class=\"menu_left\">";
				echo "<DIV id=\"left_bar_t\" class=\"left_bar_t\"><span ".(( $rid == 0)  ? "onClick=tool_bar('m1',0,0,0)" : "onClick=left_bar(0,".$pid.",0)" )."  style=\"font-weight:bold;color:#CC3300;\">返回&nbsp;&nbsp;</span>".$pro_name."</DIV>";
				if( $rid == 0 ){
					echo "<ul type=\"square\">";
					for( $i=0; $i < count($arr_re); $i++ ){
						if ( $arr_re[$i]['P_id'] != $pid ) continue;
							echo "<li onClick=left_bar(".$arr_re[$i]['R_id'].",".$pid.",".$arr_re[$i]['R_id'].")>".($i+1).".&nbsp;".$arr_re[$i]['R_name']."</li>";
					}
					echo "</ul>";
				} else {
					for( $i=0; $i < count($arr_lfb); $i++ ){
						if ( $arr_lfb[$i]['R_id'] != $rid ) continue;
						echo "<DIV id=\"left_bar_t\"  class=\"left_bar_t\" style=\"text-align:left;\" onmouseover=resource_select(".$pid.",".$rid.",".$arr_lfb[$i]['LF_id'].")  onClick=$(\"#R".$arr_lfb[$i]['R_id']."LF".$arr_lfb[$i]['LF_id']."\").slideToggle(\"slow\") >".($i+1).".&nbsp;".$arr_lfb[$i]['LF_name']."</DIV>";
						echo "<DIV id=\"R".$arr_lfb[$i]['R_id']."LF".$arr_lfb[$i]['LF_id']."\" style=\"display: none;color:#6666CC;\">加载中... ...</DIV>";
					}
				}

				echo "</DIV>";
		}
   
   }

	public function conten_box($pid,$rid,$lfid,$uid){
		$work_conten = M('conten');
		$uid = 1;
		
		$where = ( $rid == 0 ) ? "U_id=".$uid : "U_id=".$uid." AND R_id = ".$rid ;
		$arr_co = $work_conten->where( $where )->Field('C_id,R_id,C_text')->select();

		switch( $pid ){
			case "0" :
				echo "<script>$('#left_bar_t').html('总预览表')</script>";
				for( $i = 0; $i < count($arr_co); $i++ ){
					echo "<DIV id=\"conten_box_m\" class=\"conten_box_m\">".$arr_co[$i]['C_text']."</DIV>";
				}
				break;
			default :
				if ( $rid == 0 ){
					echo "<script>$('#left_bar_t').html('<span onClick=tool_bar('m1',0,0,0) style=\"font-weight:bold;color:#CC3300;\">返回&nbsp;&nbsp;</span>项目[".$pid."]总览表')</script>";
					for( $i = 0; $i < count($arr_co); $i++ ){
						echo "<DIV id=\"conten_box_m\" class=\"conten_box_m\">".$arr_co[$i]['C_text']."</DIV>";
					}
				} else {
					for( $i = 0; $i < count($arr_co); $i++ ){
						if( $rid  == $arr_co[$i]['R_id'] ){
							echo "<DIV id=\"conten_box_m\" class=\"conten_box_m\">".$arr_co[$i]['C_text']."</DIV>";
						}
					}
				}
		}
   
	}

	public function title_bar($rid,$tid,$uid){
		$work_titlebar = M('titlebar');
		
		if ( $rid == 0 ){
			echo  "<span id=\"title_bar_ma\">所有</span>";
		} else {
			$where = "U_id=".$uid." AND R_id = ".$rid ;
			$arr_ti = $work_titlebar->where( $where )->order('T_order')->Field('T_id,R_id,T_name')->select();
			
			for( $i=0; $i < count($arr_ti); $i++ ){
				$title_active = ( $i == 0 && $tid == 0 ) ? "title_bar_ma" : ( $arr_ti[$i]['T_id'] == $tid ) ? "title_bar_m" : "title_bar_ma";
				echo "<span id=\"".$title_active."\" onClick=title_bar(".$rid.",".$arr_ti[$i]['T_id'].")>".$arr_ti[$i]['T_name']."</span>";
				echo "&nbsp;";
			}
			echo "<span id=\"title_bar_m\">新建标签</span>";
		}
	}

	public function resource_select($pid,$rid,$lfid,$uid){
		$work_resource = M('resource');
		$work_server = M('server');
		$work_password = M('password');
		$work_fqdn = M('fqdn');
		$work_documents = M('documents');

		$r_type = $work_resource->where("U_id=".$uid." AND R_id = ".$rid )->getField('R_type');

		switch( $r_type ){
			// 1 = 服务器类型
			case "1" :
				$where = "U_id = ".$uid." AND P_id = ".$pid." AND R_id = ".$rid." AND LF_id = ".$lfid ;
				$arr_ser = $work_server->where( $where )->select() ;
				
				for( $i=0; $i < count($arr_ser); $i++ ){
					echo "<DIV id =\"resource_box_m\" class=\"resource_box_m\" onClick=resource_conten(".$pid.",".$rid.",".$lfid.",".$arr_ser[$i]['S_id'].")>".($i+1).".&nbsp;".$arr_ser[$i]['S_name']."</DIV>";
				}
				break;
				// 2 = 文档类型
			case "2" :
				$where = "U_id = ".$uid." AND P_id = ".$pid." AND R_id = ".$rid." AND LF_id = ".$lfid ;
				$arr_doc = $work_documents->where( $where )->select() ;
				
				for( $i=0; $i < count($arr_doc); $i++ ){
					echo "<DIV id =\"resource_box_m\" class=\"resource_box_m\" onClick=resource_conten(0,0)>".$arr_doc[$i]['D_name']."</DIV>";
				}
				break;
				// 3 = 密码类型
			case "3" :
				$where = "U_id = ".$uid." AND P_id = ".$pid." AND R_id = ".$rid." AND LF_id = ".$lfid ;
				$arr_pa = $work_password->where( $where )->select() ;
				
				for( $i=0; $i < count($arr_pa); $i++ ){
					echo "<DIV id =\"resource_box_m\" class=\"resource_box_m\" onClick=resource_conten(0,0)>".$arr_pa[$i]['PA_name']."</DIV>";
				}
				break;
				// 4 = 域名类型
			case "4" :
				$where = "U_id = ".$uid." AND P_id = ".$pid." AND R_id = ".$rid." AND LF_id = ".$lfid ;
				$arr_fqdn = $work_fqdn->where( $where )->select() ;
				
				for( $i=0; $i < count($arr_fqdn); $i++ ){
					echo "<DIV id =\"resource_box_m\" class=\"resource_box_m\" onClick=resource_conten(0,0)>".$arr_fqdn[$i]['N_name']."</DIV>";
				}
				break;
			default :
				echo "<DIV id =\"resource_box_m\" class=\"resource_box_m\" style=\"color:#FF0000;font-weight:bold;\">没找到资源</DIV>";
		}
	}

	public function resource_conten($pid,$rid,$lfid,$oid,$uid){
		$work_resource = M('resource');
		$work_server = M('server');
		$work_password = M('password');
		$work_fqdn = M('fqdn');
		$work_documents = M('documents');

		$r_type = $work_resource->where("U_id=".$uid." AND R_id = ".$rid )->getField('R_type');
		switch( $r_type ){
			// 1 = 服务器类型
			case "1" :
				$where = "U_id = ".$uid." AND P_id = ".$pid." AND R_id = ".$rid." AND LF_id = ".$lfid." AND S_id = ".$oid;
				$arr_ser = $work_server->where( $where )->select() ;
				
				echo "<DIV id =\"resource_box\" class=\"resource_box\">";
				echo "<span>服务器名称: ".$arr_ser['0']['S_name']."</span><BR>";
				echo "<span>服务器备注: ".$arr_ser['0']['S_note']."</span><BR>";
				echo "<span>服务器IP: ".$arr_ser['0']['S_ip1']."</span><BR>";
				echo "</DIV>";
				break;
				// 2 = 文档类型
			case "2" :
				$where = "U_id = ".$uid." AND P_id = ".$pid." AND R_id = ".$rid." AND LF_id = ".$lfid ;
				$arr_doc = $work_documents->where( $where )->select() ;
				
				for( $i=0; $i < count($arr_doc); $i++ ){
					echo "<DIV id =\"resource_box_m\" class=\"resource_box_m\" onClick=resource_conten(0,0)>".$arr_doc[$i]['D_name']."</DIV>";
				}
				break;
				// 3 = 密码类型
			case "3" :
				$where = "U_id = ".$uid." AND P_id = ".$pid." AND R_id = ".$rid." AND LF_id = ".$lfid ;
				$arr_pa = $work_password->where( $where )->select() ;
				
				for( $i=0; $i < count($arr_pa); $i++ ){
					echo "<DIV id =\"resource_box_m\" class=\"resource_box_m\" onClick=resource_conten(0,0)>".$arr_pa[$i]['PA_name']."</DIV>";
				}
				break;
				// 4 = 域名类型
			case "4" :
				$where = "U_id = ".$uid." AND P_id = ".$pid." AND R_id = ".$rid." AND LF_id = ".$lfid ;
				$arr_fqdn = $work_fqdn->where( $where )->select() ;
				
				for( $i=0; $i < count($arr_fqdn); $i++ ){
					echo "<DIV id =\"resource_box_m\" class=\"resource_box_m\" onClick=resource_conten(0,0)>".$arr_fqdn[$i]['N_name']."</DIV>";
				}
				break;
			default :
				echo "<DIV id =\"resource_box_m\" class=\"resource_box_m\" style=\"color:#FF0000;font-weight:bold;\">没找到资源</DIV>";
		}
	}
}