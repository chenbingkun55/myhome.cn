<?php
class AjaxAction extends Action {
   public function tool_bar($menu,$index,$lid,$pid,$uid){
	   	$work_location = M('location');
		$work_project = M('project');
		$work_resource = M('resource');

	   switch( $menu){
			case "tool_bar_m1":
				$arr_lo = $work_location->where("U_id=".$uid )->Field('L_id,L_name')->select();
				
				echo "<DIV id=\"tool_bar_m1\" class=\"menu\" onmouseover=this.style.height=\"".((count($arr_lo)+1)*25+25)."px\"; onmouseout=this.style.height=\"24px\";>";
				echo "<ul type=\"square\">";
				if ( $index == 0 && $lid == 0 ){
					echo "<li onClick=ajax_select('tool_bar_m1',0,0,0,0,0,0,0)>所有</li>";
				} else {
					if ( $lid == 0 ){
						echo "<li onClick=ajax_select('tool_bar_m1',".$index.",".$arr_lo[$index-1]['L_id'].",0,0,0,0,0)>".$arr_lo[$index-1]['L_name']."</li>";
					} else {
						for( $i=0; $i < count($arr_lo); $i++ ){
							if ( $arr_lo[$i]['L_id'] == $lid ) 
								echo "<li onClick=ajax_select('tool_bar_m1',".( $i+1 ).",".$arr_lo[$i]['L_id'].",0,0,0,0,0) title=\"".$arr_lo[$i]['L_note']."\">".$arr_lo[$i]['L_name']."</li>";
							}	
					}
					echo "<li onClick=ajax_select('tool_bar_m1',0,0,0,0,0,0,0)>所有</li>";
				}

				for( $i=0; $i < count($arr_lo); $i++ ){
					if ( $i == ( $index -1 ) || $arr_lo[$i]['L_id'] == $lid ) continue;
					echo "<li onClick=ajax_select('tool_bar_m1',".( $i+1 ).",".$arr_lo[$i]['L_id'].",0,0,0,0,0) title=\"".$arr_lo[$i]['L_note']."\">".$arr_lo[$i]['L_name']."</li>";
				}		
				echo "<li onClick=pop_add_window('toolbar',0,0,0,0,".$uid.")>添加</li>";
				echo "</ul>";
				echo "</DIV>";
				break;
			case "tool_bar_m2":
				$arr_pro = $work_project->where("U_id=".$uid)->Field('L_id,P_id,P_name')->select();
				$count_pro = $work_project->where("L_id=".$lid)->count();

				if ( $lid == 0){
					echo "<DIV id=\"tool_bar_m2\" class=\"menu\" onmouseover=this.style.height=\"".((count($arr_pro)+1)*25+25)."px\"; onmouseout=this.style.height=\"24px\";>";
				} else {
					echo "<DIV id=\"tool_bar_m2\" class=\"menu\" onmouseover=this.style.height=\"".(($count_pro+1)*25+25 )."px\"; onmouseout=this.style.height=\"24px\";>";
				}
				echo "<ul type=\"square\">";
				if ( $index == 0 ){
					echo "<li onClick=ajax_select('tool_bar_m2',0,0,0,0,0,0,0)>所有</li>";
				} else {
					echo "<li onClick=ajax_select('tool_bar_m2',".$index.",".$arr_pro[$lid]['L_id'].",".$arr_pro[$index-1]['P_id'].",0,0,0,0)>".$arr_pro[$index-1]['P_name']."</li>";
					echo "<li onClick=ajax_select('tool_bar_m2',0,0,0,0,0,0,0)>所有</li>";
				}

				for( $i=0,$j=0; $i < count($arr_pro); $i++ ){
					if ( $i == $index-1 ) continue;
					if ( $lid == 0 ){
						echo "<li onClick=ajax_select('tool_bar_m2',".( $i+1 ).",".$arr_pro[$i]['L_id'].",".$arr_pro[$i]['P_id'].",0,0,0,0)>".$arr_pro[$i]['P_name']."</li>";
					} else {
						if ( $lid == $arr_pro[$i]['L_id'] ){
							echo "<li onClick=ajax_select('tool_bar_m2',".( $i+1 ).",".$arr_pro[$i]['L_id'].",".$arr_pro[$i]['P_id'].",0,0,0,0)>".$arr_pro[$i]['P_name']."</li>";
						}
					}
					
				}		
				echo "<li onClick=pop_add_window('toolbar',".$lid.",0,0,0,".$uid.")>添加</li>";
				echo "</ul>";
				echo "</DIV>";
				break;
			case "tool_bar_m3":
				$arr_re = $work_resource->where("U_id=".$uid." AND P_id = ".$pid )->Field('P_id,R_id,R_name')->select();
				$count_re = $work_resource->where("U_id = ".$uid." AND P_id = 0 OR P_id = ".$pid)->count();
				
				if ( $pid == 0 ){
					echo "<DIV id=\"tool_bar_m3\" class=\"menu\" onmouseover=this.style.height=\"".((count($arr_re)+1)*25+25)."px\"; onmouseout=this.style.height=\"24px\";>";
				} else {
					echo "<DIV id=\"tool_bar_m3\" class=\"menu\" onmouseover=this.style.height=\"".(($count_re+1)*25+25 )."px\"; onmouseout=this.style.height=\"24px\";>";
				}
				echo "<ul type=\"square\">";
				if ( $index == 0 ){
					echo "<li onClick=ajax_select('left_bar',0,0,".$pid.",0,0,0,0)>所有</li>";
				} else {
					echo "<li onClick=ajax_select('left_bar',0,0,".$pid.",".$arr_re[$index-1]['R_id'].",0,0,0)>".$arr_re[$index-1]['R_name']."</li>";
					echo "<li onClick=ajax_select('left_bar',0,0,".$pid.",0,0,0,0)>所有</li>";
				}

				for( $i=0; $i < count($arr_re); $i++ ){
					if ( $i ==  $index-1 ) continue;
					echo "<li onClick=ajax_select('left_bar',".( $i+1 ).",0,".$pid.",".$arr_re[$i]['R_id'].",0,0,0)>".$arr_re[$i]['R_name']."</li>";
				}	
				// 资源暂定 五 种类型,不自定添加.
				// echo "<li onClick=ajax_select('left_bar',0,0,".$pid.",0,0,0,0)>添加</li>";
				echo "<li onClick=pop_add_window('toolbar',".$lid.",".$pid.",0,0,".$uid.")>添加</li>";
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
			$arr_re = $work_resource->where("U_id=".$uid  )->Field('P_id,R_id,R_name')->select();
		} else {
			$pro_name = ( $rid == 0 ) ? $work_project->where("U_id=".$uid." AND P_id = ".$pid )->getField('P_name') : "资源-".$rid;
			$arr_re = $work_resource->where("U_id=".$uid." AND P_id = 0  OR P_id = ".$pid )->Field('P_id,R_id,R_name')->select();
		}
		if ( $pid == 0 && $rid != 0 ){
			$where =  "U_id = ".$uid ;
		} else {
			$where = "U_id = ".$uid." AND P_id = 0 OR P_id =  ".$pid ;
		}
		
		$arr_lfb = $work_leftbar->where( $where )->Field('LF_id,P_id,R_id,LF_name')->select();
		
			echo "<DIV class=\"menu_left\">";
			echo "<DIV id=\"left_bar_t\" class=\"left_bar_t\"><span ".(( $rid == 0)  ? "onClick=ajax_select('tool_bar_m1',0,0,0,0,0,0,0)" : "onClick=ajax_select('left_bar',0,0,".$pid.",0,0,0,0)" )."  style=\"font-weight:bold;color:#CC3300;\">返回&nbsp;&nbsp;</span>".$pro_name."</DIV>";
			if( $rid == 0 ){
				echo "<ul type=\"square\">";
				for( $i=0; $i < count($arr_re); $i++ ){
					echo "<li onClick=ajax_select('left_bar',".($i+1).",0,".$pid.",".$arr_re[$i]['R_id'].",0,0,0)>".($i+1).".&nbsp;".$arr_re[$i]['R_name']."</li>";
				}
				echo "</ul>";
			} else {
				for( $i=0; $i < count($arr_lfb); $i++ ){
					if ( $arr_lfb[$i]['R_id'] != $rid ) continue;
					echo "<DIV id=\"left_bar_t\"  class=\"left_bar_t\" style=\"text-align:left;\" onmouseover=ajax_select('resource_put',0,0,".$pid.",".$rid.",0,".$arr_lfb[$i]['LF_id'].",0)  onClick=$(\"#R".$arr_lfb[$i]['R_id']."LF".$arr_lfb[$i]['LF_id']."\").slideToggle(\"slow\") >".($i+1).".&nbsp;".$arr_lfb[$i]['LF_name']."</DIV>";
					echo "<DIV id=\"R".$arr_lfb[$i]['R_id']."LF".$arr_lfb[$i]['LF_id']."\" style=\"display: none;color:#6666CC;\">加载中... ...</DIV>";
				}
				echo "<DIV id=\"left_bar_t\"  class=\"left_bar_t\" style=\"text-align:left;\"  onClick=pop_add_window('left_bar',0,".$pid.",".$rid.",".$lfid.",".$uid.") >添加</DIV>";
			}
			echo "</DIV>";
   }

	public function conten_box($pid,$rid,$lfid,$uid){
		$work_conten = M('conten');
		$uid = 1;
		if( $pid == 0 && $rid != 0 ){
			$where = "U_id=".$uid." AND R_id = ".$rid;
		} else {
			$where = ( $pid == 0 ) ? "U_id=".$uid : ( ( $rid == 0 ) ? "U_id=".$uid." AND P_id = ".$pid : "U_id=".$uid." AND P_id = ".$pid." AND R_id = ".$rid ) ;
		}
		$arr_co = $work_conten->where( $where )->Field('C_id,P_id,R_id,C_text')->select();

		switch( $pid ){
			case "0" :
				echo  ( $rid == 0 ) ?   "<script>$('#left_bar_t').html('总预览表')</script>" :  "<script>$('#left_bar_t').html('span onClick=ajax_select('tool_bar_m1',0,0,0,0,0,0,0) style=\"font-weight:bold;color:#CC3300;\">返回&nbsp;&nbsp;</span>总预览表')</script>";
				for( $i = 0; $i < count($arr_co); $i++ ){
					echo "<DIV id=\"conten_box_m\" class=\"conten_box_m\">".$arr_co[$i]['C_text']."</DIV>";
				}
				break;
			default :
				if ( $rid == 0 ){
					echo "<script>$('#left_bar_t').html('<span onClick=ajax_select('tool_bar_m1',0,0,0,0,0,0,0) style=\"font-weight:bold;color:#CC3300;\">返回&nbsp;&nbsp;</span>项目[".$pid."]总览表')</script>";
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

	public function title_bar($pid,$rid,$lfid,$tid,$uid){
		$work_titlebar = M('titlebar');
		$work_resource = M('resource');
		
		$re_name = $work_resource->where("R_id = ".$rid )->getField("R_name");

		if ( $rid == 0 ){
			echo  "<span id=\"title_bar_ma\">所有</span>";
		} else {
			echo "<span id=\"title_bar_ma\" onClick=pop_add_window(\"title_bar\",0,".$pid.",".$rid.",".$lfid.",".$uid."); >新建".$re_name."</span>&nbsp;";
			$where = "U_id=".$uid." AND R_id = ".$rid ;
			$arr_ti = $work_titlebar->where( $where )->order('T_order')->Field('T_id,R_id,T_name')->select();
			
			for( $i=0; $i < count($arr_ti); $i++ ){
				$title_active = ( $i == 0 && $tid == 0 ) ? "title_bar_ma" : ( $arr_ti[$i]['T_id'] == $tid ) ? "title_bar_m" : "title_bar_ma";
				echo "<span id=\"".$title_active."\" onClick=ajax_select('title_bar',0,0,".$pid.",".$rid.",".$arr_ti[$i]['T_id'].",0,0,0)>".$arr_ti[$i]['T_name']."</span>";
				echo "&nbsp;";
			}
			echo "<span id=\"title_bar_m\">添加</span>";
		}
	}

	public function resource_put($pid,$rid,$lfid,$oid,$uid){
		$work_resource = M('resource');
		$work_server = M('server');
		$work_password = M('password');
		$work_fqdn = M('fqdn');
		$work_documents = M('documents');
		$work_othe = M('othe');

		$rt_id = $work_resource->where("U_id=".$uid." AND R_id = ".$rid )->getField('RT_id');
		switch( $rt_id ){
			// 1 = 服务器类型
			case "1000" :
				if( $pid == 0 && $rid ==0 ){
					$where = "U_id = ".$uid."  AND LF_id = ".$lfid ;
				} else {
					$where = ( $oid == 0 ) ? "U_id = ".$uid."  AND R_id = ".$rid." AND LF_id = ".$lfid : "U_id = ".$uid."  AND R_id = ".$rid." AND LF_id = ".$lfid." AND S_id = ".$oid ;
				}
				$arr_ser_temp = $work_server->where( $where )->getField("S_base") ;
				$arr_ser_base = json_decode( $arr_ser_temp, true );
				
						echo "<DIV id =\"resource_box\" class=\"resource_box\">";
						print_r( $arr_ser_base );

						echo "</DIV>";	

				break;
				// 2 = 文档类型
			case "2" :
				if( $pid == 0 && $rid ==0 ){
					$where = "U_id = ".$uid."  AND LF_id = ".$lfid ;
				} else {
					$where = ( $oid == 0 ) ? "U_id = ".$uid."  AND R_id = ".$rid." AND LF_id = ".$lfid : "U_id = ".$uid."  AND R_id = ".$rid." AND LF_id = ".$lfid." AND D_id = ".$oid ;
				}
				
				$arr_doc = $work_documents->where( $where )->select() ;
				
				for( $i=0; $i < count($arr_doc); $i++ ){
					if( $oid == 0 ) {
						echo "<DIV id =\"resource_box_m\" class=\"resource_box_m\" onClick=ajax_select('resource_put',0,0,".$pid.",".$rid.",0,".$lfid.",".$arr_doc[$i]['D_id'].")>".($i+1).".&nbsp;".$arr_doc[$i]['D_name']."</DIV>"  ;
					} else {
						echo "<DIV id =\"resource_box\" class=\"resource_box\">";
						echo "<span>文档名称: ".$arr_doc['0']['D_name']."</span><BR>";
						echo "<span>文档大小: ".$arr_doc['0']['D_size']."</span><BR>";
						echo "<span>文档备注: ".$arr_doc['0']['D_note']."</span><BR>";
						echo "<span>文档路径: ".$arr_doc['0']['D_path'].DIRECTORY_SEPARATOR.$arr_doc['0']['D_name']."</span><BR>";
						echo "</DIV>";	
					}
				}
				break;
				// 3 = 密码类型
			case "3" :
				if( $pid == 0 && $rid ==0 ){
					$where = "U_id = ".$uid."  AND LF_id = ".$lfid ;
				} else {
					$where = ( $oid == 0 ) ? "U_id = ".$uid."  AND R_id = ".$rid." AND LF_id = ".$lfid : "U_id = ".$uid."  AND R_id = ".$rid." AND LF_id = ".$lfid." AND PA_id = ".$oid ;
				}
				$arr_pa = $work_password->where( $where )->select() ;
				
				for( $i=0; $i < count($arr_pa); $i++ ){
					if( $oid == 0 ) {
						echo "<DIV id =\"resource_box_m\" class=\"resource_box_m\" onClick=ajax_select('resource_put',0,0,".$pid.",".$rid.",0,".$lfid.",".$arr_pa[$i]['PA_id'].")>".($i+1).".&nbsp;".$arr_pa[$i]['PA_name']."</DIV>"  ;
					} else {
						echo "<DIV id =\"resource_box\" class=\"resource_box\">";
						echo "<span>密码名称: ".$arr_pa['0']['PA_name']."</span><BR>";
						echo "<span>密码备注: ".$arr_pa['0']['PA_note']."</span><BR>";
						echo "<span>密码: ".$arr_pa['0']['PA_pass']."</span><BR>";
						echo "<span>创建时间: ".$arr_pa['0']['PA_C_date']."</span><BR>";
						echo "<span>到期时间: ".$arr_pa['0']['PA_E_pass']."</span><BR>";
						echo "</DIV>";	
					}
				}
				break;
				// 4 = 域名类型
			case "4" :
				if( $pid == 0 && $rid ==0 ){
					$where = "U_id = ".$uid."  AND LF_id = ".$lfid ;
				} else {
					$where = ( $oid == 0 ) ? "U_id = ".$uid."  AND R_id = ".$rid." AND LF_id = ".$lfid : "U_id = ".$uid."  AND R_id = ".$rid." AND LF_id = ".$lfid." AND N_id = ".$oid ;
				}
				$arr_fqdn = $work_fqdn->where( $where )->select() ;
				
				for( $i=0; $i < count($arr_fqdn); $i++ ){
					if( $oid == 0 ) {
						echo "<DIV id =\"resource_box_m\" class=\"resource_box_m\" onClick=ajax_select('resource_put',0,0,".$pid.",".$rid.",0,".$lfid.",".$arr_fqdn[$i]['N_id'].")>".($i+1).".&nbsp;".$arr_fqdn[$i]['N_name']."</DIV>"  ;
					} else {
						echo "<DIV id =\"resource_box\" class=\"resource_box\">";
						echo "<span>网址名称: ".$arr_fqdn['0']['N_name']."</span><BR>";
						echo "<span>网址: ".$arr_fqdn['0']['N_FQDN']."</span><BR>";
						echo "<span>创建时间: ".$arr_fqdn['0']['C_date']."</span><BR>";
						echo "</DIV>";	
					}
				}
				break;
				// 5 = 其它类型
			case "5" :
				if( $pid == 0 && $rid ==0 ){
					$where = "U_id = ".$uid."  AND LF_id = ".$lfid ;
				} else {
					$where = ( $oid == 0 ) ? "U_id = ".$uid."  AND R_id = ".$rid." AND LF_id = ".$lfid : "U_id = ".$uid."  AND R_id = ".$rid." AND LF_id = ".$lfid." AND O_id = ".$oid ;
				}
				$arr_oth = $work_othe->where( $where )->select() ;
				
				for( $i=0; $i < count($arr_oth); $i++ ){
					if( $oid == 0 ) {
						echo "<DIV id =\"resource_box_m\" class=\"resource_box_m\" onClick=ajax_select('resource_put',0,0,".$pid.",".$rid.",0,".$lfid.",".$arr_oth[$i]['O_id'].")>".($i+1).".&nbsp;".$arr_oth[$i]['O_name']."</DIV>"  ;
					} else {
						echo "<DIV id =\"resource_box\" class=\"resource_box\">";
						echo "<span>其它名称: ".$arr_oth['0']['O_name']."</span><BR>";
						echo "<span>其它内容: ".$arr_oth['0']['O_text']."</span><BR>";
						echo "<span>其它创建时间: ".$arr_oth['0']['O_date']."</span><BR>";
						echo "</DIV>";	
					}
				}
				break;
			default :
				echo "<DIV id =\"resource_box_m\" class=\"resource_box_m\" style=\"color:#FF0000;font-weight:bold;\">没找到资源</DIV>";
		}
	}
}