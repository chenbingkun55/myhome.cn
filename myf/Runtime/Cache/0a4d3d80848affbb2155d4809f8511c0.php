<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"><HTML><HEAD><TITLE><?php echo ($title); ?></TITLE><script type="text/javascript" src="/public/js/all.js"></script><script type="text/javascript" src="/public/js/jquery-2.0.2.min.js"></script><script>	var txt1="<option value='5'>测试</option>";
	$(document).ready(function(){
		$('.menu1').change(function(){
			if ($(this).find('option:selected').val() == '')
			{
				$('.menu2').empty();
				$('.menu2').append(txt1);
				$('.menu3').empty();
				$('.menu3').append(txt1);
			} else {
				$('.menu2').append(txt1);
			}
		});
	});


</script><style type="text/css"><!--

	#main_frame{ position: relative; width:1007px; clear:both;}
	#up_frame{ position: relative;height:124px; clear:both;}
	#down_frame{ position: relative; height:100%; clear:both;}

	#tool_bar{ position: relative; height:24px;width:100%;float:left;background-color:#FF9900;}
	#info_bar{ position: relative; height:24px;float:right;}
	.menu_bar{ position: relative; z-index:100;  float:left;background-color: #FF9900; border: 1 solid #000000;overflow:hidden;}
	#progress_bar{ position: relative; z-index:10;height:100px;width:100%;clear:both;background-color:#FFCC66;}
	#left_bar{ position: relative; width:100px;height:80%;float:left;background-color:#3399FF;}
	#main_box{ position: relative; width:907px;height:80%;float:right;}
	#title_bar{ position: relative; z-index:10;width:100%;height:20px;background-color:#669900;}
	#conten_box{ position: relative; width:100%px;height:80%;}
	

	body{font:12px Simsun;margin:0px; background-image:url(/images/bg.png);}
--!></style></HEAD><BODY><DIV id="main_frame"><DIV id="up_frame"><DIV id="tool_bar"><DIV  id="menu1" class="menu_bar" style="width:<?php echo ($l_max_width); ?>px; height: <?php echo ($l_hieght); ?>px;" onmouseover=this.style.height="<?php echo ($l_max_hieght); ?>"; onmouseout=this.style.height="<?php echo ($l_hieght); ?>px";><DIV id="l_all" name="all"  onClick=chenge_contenbox() onmouseover=switch_color(this) onmouseout=switch_color(this)  style="height:<?php echo ($p_hieght); ?>px;cursor:default;font-family: Tahoma; font-size: 12px;   
		font-weight: bold;"><label for='all' >所有</label><IMG src="/public/img/down.png" style="float:right;"></IMG></DIV><?php if(is_array($locations)): $i = 0; $__LIST__ = $locations;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lo): $mod = ($i % 2 );++$i;?><DIV  name="lo<?php echo ($lo["L_id"]); ?>" onClick=chenge_contenbox() onmouseover=switch_color(this) onmouseout=switch_color(this)  style="height:<?php echo ($l_hieght); ?>px;cursor:default;font-family: Tahoma; font-size: 12px;   
    font-weight: bold" ><label  for='<?php echo ($lo["L_id"]); ?>' ><?php echo ($lo["L_name"]); ?></label></DIV><?php endforeach; endif; else: echo "" ;endif; ?></DIV><DIV style="float:left;"></DIV><DIV  id="menu2"  class="menu_bar" style="width: <?php echo ($p_max_width); ?>; height: <?php echo ($p_hieght); ?>px;" onmouseover=this.style.height="<?php echo ($p_max_hieght); ?>"; onmouseout=this.style.height="<?php echo ($p_hieght); ?>px";><DIV name="all" onClick=aaa(this) onmouseover=switch_color(this) onmouseout=switch_color(this)  style="height:<?php echo ($p_hieght); ?>px;cursor:default;font-family: Tahoma; font-size: 12px;   
		font-weight: bold" ><label for='all' >所有</label><IMG src="/public/img/down.png" style="float:right;"></IMG></DIV><?php if(is_array($projects)): $i = 0; $__LIST__ = $projects;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pro): $mod = ($i % 2 );++$i;?><DIV name="pro<?php echo ($pro["P_id"]); ?>" onClick=chenge_hs() onmouseover=switch_color(this) onmouseout=switch_color(this)  style="height:<?php echo ($p_hieght); ?>px;cursor:default;font-family: Tahoma; font-size: 12px;   
    font-weight: bold" ><label for='<?php echo ($lo["P_id"]); ?>' ><?php echo ($pro["P_name"]); ?></label></DIV><?php endforeach; endif; else: echo "" ;endif; ?></DIV><DIV style="float:left;">&nbsp;</DIV><DIV  id="menu3" class="menu_bar" style="width:<?php echo ($r_max_width); ?>; height: <?php echo ($r_hieght); ?>px;" onmouseover=this.style.height="<?php echo ($r_max_hieght); ?>"; onmouseout=this.style.height="<?php echo ($r_hieght); ?>px";><DIV name="all" onClick=chenge_title() onmouseover=switch_color(this) onmouseout=switch_color(this)  style="height:<?php echo ($p_hieght); ?>px;cursor:default;font-family: Tahoma; font-size: 12px;   
		font-weight: bold" ><label for='all' >所有</label><IMG src="/public/img/down.png" style="float:right;"></IMG></DIV><?php if(is_array($resources)): $i = 0; $__LIST__ = $resources;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$re): $mod = ($i % 2 );++$i;?><DIV name="re<?php echo ($re["R_id"]); ?>" onClick=chenge_title() onmouseover=switch_color(this) onmouseout=switch_color(this)  style="height:<?php echo ($r_hieght); ?>px;cursor:default;font-family: Tahoma; font-size: 12px;   
    font-weight: bold" ><label for='<?php echo ($re["R_id"]); ?>' ><?php echo ($re["R_name"]); ?></label></DIV><?php endforeach; endif; else: echo "" ;endif; ?></DIV><b><?php echo ($title); ?></b><DIV id="info_bar">使用者: <a href="#"><?php echo ($username); ?></a>&nbsp;<a href="#">设置</a>&nbsp;当前时间: <?php echo ($tdate); ?></DIV></DIV><DIV id="progress_bar">				进度栏
			</DIV></DIV><DIV id="down_frame"><DIV id="left_bar">				左边栏<br><a href="http://localhost">重要</a></DIV><DIV id="main_box"><DIV id="title_bar"><a href="http://localhost">标题栏</a></DIV><DIV id="conten_box"><?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; echo ($vo["id"]); ?> -- <?php echo ($vo["data"]); ?><br/><?php endforeach; endif; else: echo "" ;endif; ?></DIV></DIV></DIV></DIV>