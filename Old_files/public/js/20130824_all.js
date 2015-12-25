$(document).ready(function(){
	$("#tool_bar_m1").load("/Ajax/tool_bar/menu/tool_bar_m1/index/0/lid/0/pid/0/uid/2/");
	$("#tool_bar_m2").load("/Ajax/tool_bar/menu/tool_bar_m2/index/0/lid/0/pid/0/uid/2/");
	$("#tool_bar_m3").load("/Ajax/tool_bar/menu/tool_bar_m3/index/0/lid/0/pid/0/uid/2/");
	$("#left_bar").load("/Ajax/left_bar/index/0/pid/0/rid/0/lfid/0/uid/2/");
	$("#conten_box").load("/Ajax/conten_box/pid/0/rid/0/lfid/0/uid/2/");
	$("#title_bar").load("/Ajax/title_bar/pid/0/rid/0/tid/0/lfid/0/uid/2/");
});

function ajax_select(str,index,lid,pid,rid,tid,lfid,oid){
	// alert 调试用, 不用时关掉它.
	// alert('str='+str+' index='+index+' lid='+lid+' pid='+pid+' rid='+rid+' tid='+tid+' lfid='+lfid+' oid='+oid);
	switch(	str ){
		case "tool_bar_m1" :
			$("#tool_bar_m1").load("/index.php/Ajax/tool_bar/menu/tool_bar_m1/index/"+index+"/lid/"+lid+"/pid/"+pid+"/uid/2/");
			$("#tool_bar_m2").load("/index.php/Ajax/tool_bar/menu/tool_bar_m2/index/0/lid/"+lid+"/pid/"+pid+"/uid/2/");
			$("#tool_bar_m3").load("/index.php/Ajax/tool_bar/menu/tool_bar_m3/index/0/lid/"+lid+"/pid/"+pid+"/uid/2/");
			ajax_select('left_bar',0,lid,pid,rid,lfid,oid);
			break;
		case "tool_bar_m2" :
			$("#tool_bar_m1").load("/index.php/Ajax/tool_bar/menu/tool_bar_m1/index/0/lid/"+lid+"/pid/"+pid+"/uid/2/");
			$("#tool_bar_m2").load("/index.php/Ajax/tool_bar/menu/tool_bar_m2/index/"+index+"/lid/"+lid+"/pid/"+pid+"/uid/2/");
			$("#tool_bar_m3").load("/index.php/Ajax/tool_bar/menu/tool_bar_m3/index/0/lid/"+lid+"/pid/"+pid+"/uid/2/");
			ajax_select('left_bar',0,lid,pid,rid,lfid,oid);
		break;
		case "tool_bar_m3" :
			$("#tool_bar_m3").load("/index.php/Ajax/tool_bar/menu/tool_bar_m3/index/"+index+"/lid/"+lid+"/pid/"+pid+"/uid/2/");
		break;
		case "left_bar" :
			$("#left_bar").load("/index.php/Ajax/left_bar/index/0/pid/"+pid+"/rid/"+rid+"/lfid/"+lfid+"/uid/2/");
			ajax_select('tool_bar_m3',index,lid,pid,rid,lfid,oid);
			ajax_select('title_bar',0,lid,pid,rid,lfid,oid);
			ajax_select('conten_box',0,lid,pid,rid,lfid,oid);
		break;
		case "conten_box" :
			$("#conten_box").load("/index.php/Ajax/conten_box/pid/"+pid+"/rid/"+rid+"/lfid/"+lfid+"/uid/2/");
		break;
		case "title_bar" :
			$("#title_bar").load("/index.php/Ajax/title_bar/pid/"+pid+"/rid/"+rid+"/tid/"+tid+"/lfid/"+lfid+"/uid/2/");
		break;
		case "resource_put" :
			// $("#R"+rid+"LF"+lfid).slideDown("slow");
			if( oid == 0 )
			{
				$("#R"+rid+"LF"+lfid).load("/index.php/Ajax/resource_put/pid/"+pid+"/rid/"+rid+"/lfid/"+lfid+"/oid/"+oid+"/uid/2/");
			} else {
				$("#conten_box").load("/index.php/Ajax/resource_put/pid/"+pid+"/rid/"+rid+"/lfid/"+lfid+"/oid/"+oid+"/uid/2/");
			}
		break;
		default :
	}
}

function pop_add_window( str,lid,pid,rid,lfid,uid ){
	showShade();
   // alert('弹出 添加 服务器窗口.PID='+pid+' RID='+rid+' lfid='+lfid+' uid='+uid);
	$("body").append("<div id='pop_add_window' style='z-index:9100;background:#FFFFFF;position:fixed;top:"+($("body").height()/8)+";left:"+($(window).width()/8)+";width:"+($(window).width()-200)+"px;height:"+($("body").height()-200)+"px;'></div>");
	switch( str ){
		case "title_bar" :	
			fun_str = "view_box_conten" ;
			break;
		case "left_bar" :
			fun_str = "view_leftbar_box" ;
			break;
		case "toolbar" :
			fun_str = "view_toolbar_box" ;
			break;
	}
	$("#pop_add_window").load("/index.php/PopAdd/"+fun_str+"/lid/"+lid+"/pid/"+pid+"/rid/"+rid+"/uid/2/",function(responseTxt,statusTxt,xhr){
		if(statusTxt=="error")
			alert("Error: "+xhr.status+": "+xhr.statusText);
	});
}

function showShade(){
    $("body").append("<div id='shade' style='z-index:9000;background:black;position:fixed;top:0;left:0;width:"+$(window).width()+"px;height:"+($("body").height()+20)+"px;'>&nbsp;</div>");
    $("#shade").fadeTo(0,0,function(){$("#shade").fadeTo(500,0.5);});
}

function removeShade(){
	$("#pop_add_window").remove();
	 $("#shade").remove();
}

