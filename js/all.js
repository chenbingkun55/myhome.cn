$(document).ready(function(){

    /*
    $("button").click(function(){
            var txt="";
            txt+="Document width/height: " + $(document).width();
            txt+="x" + $(document).height() + "\n";
            txt+="Window width/height: " + $(window).width();
            txt+="x" + $(window).height();
            alert(txt);
    });
    */
	// day_box_min 弹出 div 的左偏差量。
	var witdh_diff = 0;
	// 用来保存 全局提示;
	var msg = '';

    if ( $(document).width() < 800  ){
        $(".div_body").css({"width":"800px","height":$(document).height() - 20});
		$(".day_box_min").css({"width":"12px","height":"12px"});
		$(".cal_tools_month").css({"margin":"0px 3px 0px 2px"});
		$(".cal_tools_week_day").css({"margin":"0px 36px 0px 36px"});
		witdh_diff = 6 ;
    } else {
        $(".div_body").css({"width":"1000","height":$(document).height() - 20});
        $(".cal_tools_month").css({"margin":"0px 10px 0px 10px"});
        $(".cal_tools_week_day").css({"margin":" 0px 51px 0px 51px"});
    }

    if( $(document).height() < 600 ){
        $(".div_body").css("height","600px");
    }

	$("#status_bar").css("height","30px");
	$("#tools_bar").css("height","30px");
	$("#cal_tools").css("height","40px");

    var box_height = Math.floor(($(".div_body").height() - 60 - 50 - 12)/9);
    var day_box_width = Math.floor(($(".div_body").width() - 80)/7);
	var cal_box_height = box_height*6;
	var cal_point_height = cal_box_height - 10;
	var day_box_height = box_height - 10;
	$("#today_task").css("height",box_height);
	$("#grade_task").css("height",box_height);
	$("#delay_task").css("height",box_height);
	$("#calendar").css("height",cal_box_height);
	$(".day_box").css("height",day_box_height).css("width",day_box_width);
	$(".title_box").css("width",day_box_width);
    $(".cal_tools_week").css("word-spacing",day_box_width - 36  );
	$(".day_box_conten").css({"width":$(".day_box").width(),"height":$(".day_box").height() - 20 })

	// 鼠标经过 Div task_level_div 这版算比较完美了.
    $(".day_box_min").bind("mouseenter",function(){
		$(".task_level_div").html("").css("opacity","0.8").stop();
        //alert( $(this).parent().parent().attr('date')+" level:"+$(this).attr('val'));
		var level = $(this).attr('val');
        $.get("/myt/index.php/Lib/show_task_level/date/"+$(this).parent().parent().attr('date')+"/level/"+level+"/", function(data,status){
            var task_leve_title = "<div style=\"position: relative;width: 240px;height: 20px;background-color: #000000;color: #FFFFFF; padding: 0px 10px 0px 10px ;font-weight: bold;\">任务列表 "+ShowLevel(level)+"</div>"+data;
			$(".task_level_div").html( task_leve_title );
        });

        // 获取元素 位置,offset.left 和 offset.top
        var offset = $(this).offset();
		//alert("Left: "+offset.left+"-Top: "+offset.top);

        // parseInt($(this).text()) 将Div 里的值转化为 整数.
		//alert(parseInt($(this).text()));
        var pointTop = offset.top - ( ( parseInt($(this).text()) +1 ) * 20 ) ;
		if ( offset.left > ( $(document).width()-160) )
		{
			var pointLeft = offset.left - 238 - witdh_diff;
		} else {
			var pointLeft = offset.left;	
		}

        //alert($(".task_level_line").height());
        $(".task_level_div").css("top",pointTop);
        $(".task_level_div").css("left",pointLeft);

        //alert(pointLeft+"-"+pointTop);
        $(".task_level_div").clearQueue().fadeIn(1000);
    });

    $(".task_level_div").bind("mouseenter",function(){
        $(".task_level_div").css("opacity","1");
        $(".task_level_div").stop();
    });

	// 这里用 mouseout 一直有个问题,达不到要求.
	// 相关文档: http://dunhuangmi.iteye.com/blog/1745214
	// 原因: 当鼠标经过或离开子元素的时候，浏览器认为这样也触发了mouseover和mouseout事件
	// 解决: jquery的mouseenter和mouseleave方法已经修复了这个问题，可以直接用来替代mouseover和mouseout
	// 解决: jQuery 中同时用两个选择器来工作.
    $(".task_level_div,.day_box_min").bind("mouseleave",function(){
           $(".task_level_div").clearQueue().fadeOut(1000);
        });

    $(".task_level_line").click(function( ){
        var reVlaue = $(this).attr("tid");
        // alert(reVlaue);
        if( "undefined" == typeof reVlaue ){
            var val = $(this).attr("date");
            var active = 'create_task/date/'+val+'/';
        }else{
            var val = $(this).attr("tid");
            var active = 'edit_task/tid/'+val+'/';
        }
        TaskWindow = window.open("/myt/index.php/Task/"+active,val,"width=820,height=620,menubar=no,toolbar=no,location=no,scrollbars=no,status=no,modal=yes");
        TaskWindow.focus();
    });

    $(".day_box_conten").click(function( ){
        var reVlaue = $(this).parent().attr("tid");
        //alert(reVlaue);
        if( "undefined" == typeof reVlaue ){
            var val = $(this).parent().attr("date");
            var active = 'create_task/date/'+val+'/';
        }else{
            var val = $(this).parent().attr("tid");
            var active = 'edit_task/tid/'+val+'/';
        }
        TaskWindow = window.open("/myt/index.php/Task/"+active,val,"width=820,height=620,menubar=no,toolbar=no,location=no,scrollbars=no,status=no,modal=yes");
        TaskWindow.focus();
    });


    $(".task_remove").click(function(){
        // alert($(this).attr("tid"));
		var msg = "确定要删除这个任务吗？";
		if (confirm(msg)==true){
			$.get("/myt/index.php/Task/delete_task/tid/"+$(this).attr("tid")+"/",function(){
				self.opener.location.reload();
				window.close();
			});
		}else{
			return false;
		}
    });

    /* 这个函数 不知道怎么地死活不能生效.
    $(".task_level_line").live("click",function(){
        var reVlaue = $(this).attr("tid");
        TaskWindow = window.open("/myt/index.php/Task/edit_task/tid/"+ reVlaue+"/","width=820,height=620,menubar=no,toolbar=no,location=no,scrollbars=no,status=no,modal=yes");
        TaskWindow.focus();
    });
    */

	$(".task_win_submit").click(function(){
		// 原因: KindEditor编辑器无法获得提交的数据.
		// 解决: 添加 editor.sync(); 这一行.
		editor.sync();
		$("form").submit();
		self.opener.location.reload();
	}); 

	$(".task_tools_title").prepend( ShowLevel( $(".task_tools_title").attr("level"))+" ");

	// 移动 进程指标器。
	$(".task_process_step").click(function(){
		$(".task_process_point").hide();
		$(this).children("span").css("display","inline");
		// 这里添加 更新状态[0-6]数据，写回数据库，
		// alert( $(this).attr("sta"));
		var url = window.location.href;
		var paras = url.split("/");  // 分拆数组。
		paras.reverse(); // 反转数组，使 tid 排列第一个。
		// alert(paras['1']);
		var get_tid =  paras['1'];
		// alert(document.title);
		// alert( $(this).text());

		// 使用 replace() 函数替换 title 里的状态。
		document.title = document.title.replace(/(▶准备|▶运行|▶暂停|▶等待|▶停止|▶完成|▶放弃)/,$(this).text());

		$.get("/myt/index.php/Task/update_task_status/tid/"+get_tid+"/status/"+$(this).attr("sta")+"/",function(data){
			msg= data;
			self.opener.location.reload();
		});
	});

	$(".task_set_templet").click(function(){
		var url = window.location.href;
		var paras = url.split("/");  // 分拆数组。
		paras.reverse(); // 反转数组，使 tid 排列第一个。
		// alert(paras['1']);
		var get_tid =  paras['1'];
		//alert( get_tid );

		$.get("/myt/index.php/Task/update_task_templet/tid/"+get_tid+"/",function(data){
			alert(data);
			self.opener.location.reload();
		});
	}); 

	$(".task_process_progress_box").bind("mouseenter",function(){
		$(".task_process_progress_time").css("opacity","0.8").stop();
		// 这里获取任务各阶段用时情况。
		var progress_status="<div style=\"position: relative;height: 20px;background-color: #000000;color: #FFFFFF; padding: 0px 10px 0px 10px ;font-weight: bold;text-align:left; \">己完成[20%] 总预计：60分钟 还剩：20分钟</div>";
		progress_status  +="<div style=\"position: relative;height: 20px;padding: 0px 10px 0px 10px ;text-align:left; \">运行：20分钟</div>";
		progress_status  +="<div style=\"position: relative;height: 20px;padding: 0px 10px 0px 10px ;text-align:left; \">等待：20分钟</div>";
		progress_status  +="<div style=\"position: relative;height: 20px;padding: 0px 10px 0px 10px ;text-align:left; \">暂停：20分钟</div>";
		$(".task_process_progress_time").html( progress_status ).clearQueue().fadeIn(1000);
		//alert('运行：20分钟');
	});

    $(".task_process_progress_time").bind("mouseenter",function(){
        $(".task_process_progress_time").css("opacity","1");
        $(".task_process_progress_time").stop();
    });

	$(".task_process_progress_box,.task_process_progress_time").bind("mouseleave",function(){
        $(".task_process_progress_time").clearQueue().fadeOut(1000);
    });

	$(".cal_tools_month").click(function(){
		/* 用 .get 方法，当使用 F5 刷新时，会跳转到当前时间。
		//alert($(this).attr("date"));
		$.get("/myt/index.php?date="+$(this).attr("date")+"/",function(data,status){
			$("body").html(data);
			// alert("Data: " + data + "\nStatus: " + status);
		});
		*/
		// 使用 replace 方法，使用 F5 刷新时，日期才不会跳转。
		window.location.replace("/myt/index.php?date="+$(this).attr("date")+"/");
	});

	$(".task_templet").click(function(){
		//alert($(this).attr("date"));
		if ( $(".task_templet_list").text() ){
			$(".task_templet_list").fadeToggle();
		} else {
			$.get("/myt/index.php/Lib/show_task_templet",function(data,status){
				$(".task_templet_list").html(data);
				// alert("Data: " + data + "\nStatus: " + status);
			});
			// Js 在同一窗口中打开网址。
			// window.open("/myt/index.php/Task/edit_task/tid/300007/");
		}
	});

	$(".day_box_date").click(function(){
		alert('这里添加一个整天的任务列表');
	})
});

function TaskEdit( tid ){
    TaskWindow = window.open("/myt/index.php/Task/edit_task/tid/"+tid+"/",tid,"width=820,height=620,menubar=no,toolbar=no,location=no,scrollbars=no,status=no,modal=yes");
    TaskWindow.focus();
}

function ShowLevel( level ){
	 var level_tag = '';
    while ( level > 0 ){
        level_tag =  level_tag+"★";
        level = level - 1;
    }
	return "<font color=\"#FFFFFF\">"+level_tag+"</font>";
}

function CreateTemplet( tid ){
		var url = window.location.href;
		var paras = url.split("/");  // 分拆数组。
		paras.reverse(); // 反转数组，使 tid 排列第一个。
		// alert(paras['1']);
		var get_date =  paras['1'];
		window.location.replace(window.location.href+"tid/"+tid+"/");
		// TempletWindow = window.open(window.location.href+"tid/"+tid+"/",tid,"width=820,height=620,menubar=no,toolbar=no,location=no,scrollbars=no,status=no,modal=yes");
		// TempletWindow.focus();
		// self.opener.window.close();
		self.opener.location.reload();
}