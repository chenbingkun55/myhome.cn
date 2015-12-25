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

	$(' input[name="task_search"]').focus( );

    if ( $(document).width() < 800  ){
        $(".div_body").css({"width":"800px","height":$(document).height() - 20});
		$(".day_box_min").css({"width":"12px","height":"12px"});
		$(".cal_tools_month").css({"margin":"0px 3px 0px 2px"});
		$(".cal_tools_week_day").css({"margin":"0px 36px 0px 36px"});
		witdh_diff = 6 ;
    } else {
        $(".div_body").css({"width":"1000","height":$(document).height() - 20});
        $(".cal_tools_month").css({"margin":"0px 8px 0px 8px"});
        $(".cal_tools_week_day").css({"margin":" 0px 51px 0px 51px"});
    }

    if( $(document).height() < 600 ){
        $(".div_body").css("height","600px");
    }

	$("#status_bar").css("height","35px");
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


//  三个 自动滚动 栏开始.
    function auto_today_task(){
        var today_box_width = day_box_width + 10;
        // alert(box_width);
        $("#today_task").css("left","-"+today_box_width+"px");
        $("#today_task").css("width",(today_box_width * 50)+'px');
        var moveTodayFactor = parseInt($("#today_task").css("left")) - today_box_width ;
        $('#today_task').animate(
            {'left':moveTodayFactor},'slow','linear',function(){
               $("#today_task .day_box:last").after($("#today_task .day_box:first"));
               $('#today_task').css({'left' : "-"+today_box_width+"px"});
            });
    };

    // 当 $(".today_task_total").text()  值大于 7 时，说明 day_box 超过 窗口宽度，需要运行自动滚动功能。
    if(  $(".today_task_total").text() > 7 ){
        move_today_task = setInterval(auto_today_task,5000);
        $(".today_task_total").css({"left": ($("#today_task_outer").offset().left),"top": ($("#today_task_outer").offset().top + 30)});
    } else {
        $("#today_task").css("left","0px");
    }

    function auto_grade_task(){
        var grade_box_width = day_box_width + 10;
        // alert(box_width);
        $("#grade_task").css("left","-"+grade_box_width+"px");
        $("#grade_task").css("width",(grade_box_width * 50)+'px');
        var moveGradeFactor = parseInt($("#grade_task").css("left")) - grade_box_width ;
        $('#grade_task').animate(
            {'left':moveGradeFactor},'slow','linear',function(){
                $("#grade_task .day_box:last").after($("#grade_task .day_box:first"));
                $('#grade_task').css({'left' : "-"+grade_box_width+"px"});
            });
    };

    // 当 $(".today_task_total").text()  值大于 7 时，说明 day_box 超过 窗口宽度，需要运行自动滚动功能。
    if(  $(".grade_task_total").text()  > 7 ){
        move_grade_task = setInterval(auto_grade_task,18000);
        $(".grade_task_total").css({"left": ($("#grade_task_outer").offset().left),"top": ($("#grade_task_outer").offset().top + 30)});
    } else {
        $("#grade_task").css("left","0px");
    }

    function auto_delay_task(){
        var delay_box_width = day_box_width + 10;
        // alert(box_width);
        $("#delay_task").css("left","-"+delay_box_width+"px");
        $("#delay_task").css("width",(delay_box_width * 50)+'px');
        var moveDelayFactor = parseInt($("#delay_task").css("left")) - delay_box_width ;
        $('#delay_task').animate(
            {'left':moveDelayFactor},'slow','linear',function(){
                $("#delay_task .day_box:last").after($("#delay_task .day_box:first"));
                $('#delay_task').css({'left' : "-"+delay_box_width+"px"});
            });
    };

    // 当 $(".today_task_total").text()  值大于 7 时，说明 day_box 超过 窗口宽度，需要运行自动滚动功能。
    // alert($(".delay_task_total").text());
    if(  $(".delay_task_total").text()  > 7 ){
        move_delay_task = setInterval(auto_delay_task,3000);
        $(".delay_task_total").css({"left": ($("#delay_task_outer").offset().left),"top": ($("#delay_task_outer").offset().top + 30)});
    } else {
        $("#delay_task").css("left","0px");
    }


    $("#today_task").hover(function(){
        $(this).stop();
        clearInterval(move_today_task);
    },function(){
        $(this).stop();
        move_today_task = setInterval(auto_today_task,5000);
    });

    $("#grade_task").hover(function(){
        $(this).stop();
        clearInterval(move_grade_task);
    },function(){
        $(this).stop();
        move_grade_task = setInterval(auto_grade_task,18000);
    });

    $("#delay_task").hover(function(){
        $(this).stop();
        clearInterval(move_delay_task);
    },function(){
        $(this).stop();
        move_delay_task = setInterval(auto_delay_task,40000);
    });

//  三个 自动滚动 栏结束.

    // 鼠标经过 Div task_level_div 这版算比较完美了.
    $(".day_box_min").bind("mouseenter",function(){
		$(".task_level_div").html("").css("opacity","0.8").stop();
        //alert( $(this).parent().parent().attr('date')+" level:"+$(this).attr('val'));
		var level = $(this).attr('val');
        $.get("/myt/index.php/Lib/show_task_level/date/"+$(this).parent().parent().attr('date')+"/level/"+level+"/", function(data,status){
            var task_leve_title = "<div style=\"position: relative;width: 240px;height: 20px;background-color: #000000;color: #FFFFFF; padding: 0px 10px 0px 10px ;font-weight: bold;\">任务列表 "+ShowLevel(level)+"</div>"+data;
			$(".task_level_div").html( task_leve_title );

            $(".task_level_line").click(function(){
                var val = $(this).attr("tid");
                // alert( tid );


                if( $.cookie(val) == 1 ){
                    if( EditTaskWindow.closed ){
                        EditTaskWindow = window.open("/myt/index.php/Task/edit_task/tid/"+val+"/",val,"width=820,height=620,menubar=no,toolbar=no,location=no,scrollbars=no,status=no,modal=yes");
                        EditTaskWindow.focus();
                        if( "undefined" != typeof val ){
                            $.cookie(val,1,{expires: 1000 * 60 * 60 * 8, path: '/'});
                        }
                    } else {
                        alert('这个任务己打开!');
                    }
                } else {
                    EditTaskWindow = window.open("/myt/index.php/Task/edit_task/tid/"+val+"/",val,"width=820,height=620,menubar=no,toolbar=no,location=no,scrollbars=no,status=no,modal=yes");
                    EditTaskWindow.focus();
                    if( "undefined" != typeof val ){
                        $.cookie(val,1,{expires: 1000 * 60 * 60 * 8, path: '/'});
                    }
                }
            });
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
            var tid = $(this).parent().attr("tid");
            var active = 'edit_task/tid/'+tid+'/';
        }

        /*
        TaskWinList = $.cookie('task_win_list') ;
        if( typeof(TaskWinList) == "undefined" ){
            TaskWinList = "" ;
        }
        alert(TaskWinList);
        */

        if( $.cookie(tid) == 1 ){
            if( EditTaskWindow.closed ){
                EditTaskWindow = window.open("/myt/index.php/Task/"+active,tid,"width=820,height=620,menubar=no,toolbar=no,location=no,scrollbars=no,status=no,modal=yes");
                EditTaskWindow.focus();
                if( "undefined" != typeof tid ){
                    $.cookie(tid,1,{expires: 1000 * 60 * 60 * 8, path: '/'});
                }
            } else {
                alert('这个任务己打开!');
            }
        } else {
            EditTaskWindow = window.open("/myt/index.php/Task/"+active,tid,"width=820,height=620,menubar=no,toolbar=no,location=no,scrollbars=no,status=no,modal=yes");
            EditTaskWindow.focus();
            if( "undefined" != typeof tid ){
                $.cookie(tid,1,{expires: 1000 * 60 * 60 * 8, path: '/'});
            }
        }
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

    $('.task_win_close_create').click(function(){
        var msg = "任务己修改,确定不更新个任务吗？";
        if( is_change ){
            if (confirm(msg)==true){
                window.close() ;
            }else{
                return false;
            }
        } else {
            window.close() ;
        }
    });


    $('.task_win_close').click(function(){
        var msg = "任务己修改,确定不更新个任务吗？";
        if( is_change ){
            if (confirm(msg)==true){
                $.cookie(window.name,'',{expires: -1, path: '/'});
                window.close() ;
            }else{
                return false;
            }
        } else {
            $.cookie(window.name,'',{expires:-1, path: '/'});
            window.close() ;
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

        setTimeout(self.opener.location.reload(),5000);
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
			if ( data == "成功"){
                self.opener.location.reload();
            } else {
                alert( data );
                location.reload();
            }
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
			self.location.reload();
		});
	}); 
		
	function  process_relay(){
		var url = window.location.href;
		var paras = url.split("/");  // 分拆数组。
		paras.reverse(); // 反转数组，使 tid 排列第一个。
		// alert(paras['1']);
		var get_tid =  paras['1'];
		
		$.get("/myt/index.php/Task/auto_update_task_process/tid/"+get_tid+"/",function(data){ 
		
		}); 

		$.get("/myt/index.php/Lib/show_task_process/tid/"+get_tid+"/",function(data){
			//alert(data);
			var process_arr = $.parseJSON(data);
			var to_ini =  (process_arr['run_total_time'] / process_arr['exp_total_time'] );
			$(".task_process_progress_status").css("width",Math.floor(to_ini * 100)+"%");
		});
	}

	$(".task_process_progress_box").ready( process_relay());

	// $(".task_process_progress_box,.task_process_box").bind("mouseenter",function(){
    $(".task_process_progress_box,.task_process_box").click(function(){
		$(".task_process_progress_time").css("opacity","1").stop();
		var url = window.location.href;
		var paras = url.split("/");  // 分拆数组。
		paras.reverse(); // 反转数组，使 tid 排列第一个。
		// alert(paras['1']);
		var get_tid =  paras['1'];
		
		$.get("/myt/index.php/Lib/show_task_process/tid/"+get_tid+"/",function(data){
			//alert(data);
			var process_arr = $.parseJSON(data);
			var to_ini =  (process_arr['run_total_time'] / process_arr['exp_total_time'] );

			// 这里获取任务各阶段用时情况。
			var progress_status="<div style=\"position: relative;height: 20px;background-color: #000000;color: #FFFFFF; padding: 0px 10px 0px 10px ;font-weight: bold;text-align:left; \"> 总预计："+Math.round( process_arr['exp_total_time'] / 60 )+"分 还剩："+Math.round(((process_arr['exp_total_time'] - process_arr['run_total_time'] ) / 60 ))+" 分 己占用["+Math.round(to_ini * 100)+"%]</div>";
			progress_status  +="<div style=\"position: relative;height: 20px;padding: 0px 10px 0px 10px ;text-align:left; \">己运行："+Math.round(( process_arr['run_total_time'] / 60 ))+" 分</div>";
			progress_status  +="<div style=\"position: relative;height: 20px;padding: 0px 10px 0px 10px ;text-align:left; \">己暂停："+Math.round( process_arr['pause_total_time'] / 60 )+" 分</div>";
			progress_status  +="<div style=\"position: relative;height: 20px;padding: 0px 10px 0px 10px ;text-align:left; \">己等待："+Math.round(process_arr['wait_total_time'] / 60 )+" 分</div>";
			progress_status  +="<div style=\"position: relative;height: 20px;padding: 0px 10px 0px 10px ;text-align:left; \">己停止："+Math.round( process_arr['stop_total_time'] / 60 )+" 分</div>";
			progress_status  +="<div style=\"position: relative;height: 20px;padding: 0px 10px 0px 10px ;text-align:left; \">预计开始时间："+process_arr['exp_start_time']+"</div>";
            progress_status  +="<div style=\"position: relative;height: 20px;padding: 0px 10px 0px 10px ;text-align:left; \">开始时间："+process_arr['start_time']+"</div>";
			progress_status  +="<div style=\"position: relative;height: 20px;padding: 0px 10px 0px 10px ;text-align:left; \">完成时间："+process_arr['done_time']+"</div>";
			progress_status  +="<div style=\"position: relative;height: 20px;padding: 0px 10px 0px 10px ;text-align:left; \">放弃时间："+process_arr['forgo_time']+"</div>";
			$(".task_process_progress_time").html( progress_status ).clearQueue().fadeIn(500);
			$(".task_process_progress_status").css("width",Math.floor(to_ini * 100)+"%");
			//alert('运行：20分钟');
		});
	});

    /*
    $(".task_process_progress_time").bind("mouseenter",function(){
        $(".task_process_progress_time").css("opacity","1");
        $(".task_process_progress_time").stop();
    });
    */

	// $(".task_process_progress_box,.task_process_progress_time,.task_process_box").bind("mouseleave",function(){
    $(".task_process_progress_box,.task_process_progress_time,.task_process_box,.task_process_progress_time").click(function(){
        $(".task_process_progress_time").clearQueue().fadeOut(500);
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
		window.location.replace("/myt/index.php?date="+$(this).attr("date"));
	});

	$(".task_templet").click(function(){
		//alert($(this).attr("date"));
		if ( $(".task_templet_list").text() ){
			$(".task_templet_list").fadeToggle();
		} else {
			$.get("/myt/index.php/Lib/show_task_templet",function(data,status){
				$(".task_templet_list").html(data);
				// alert("Data: " + data + "\nStatus: " + status);


                $('.task_templet_line').click(function (){
                    var url = window.location.href;
                    var tid = $(this).attr('tid');

                    window.location.replace(url+"tid/"+tid+"/");
                });
			});
			// Js 在同一窗口中打开网址。
			// window.open("/myt/index.php/Task/edit_task/tid/300007/");
		}
	});

	$(".task_box_date").click(function(){
		$(".task_day_div").html("").css("opacity","1").stop();
       var val = $(this).parent().attr('tid');
       var active = 'show_task_content/tid/'+val+'/';     

		
        $.get("/myt/index.php/Lib/"+active+"/", function(data,status){
            $(".task_day_div").html( data );
        });

		$(".task_day_div").css("top","235px");
		$(".task_day_div").css("left",($(document).width() - 800)/2 +"px");

        $(".task_day_div").toggle();
	});

	$(".day_box_date").click(function(){
        $(".task_day_div").html("").css("opacity","1").stop();
        //alert( $(this).parent().attr('tid'));
        // 获取元素 位置,offset.left 和 offset.top
        var offset = $(this).offset();
        var task_day_width = 240;
        var pointTop ="";
        var pointLeft = "";

            var val = $(this).parent().attr("date");
            var active = 'show_task_day/date/'+val+'/';
            var task_title = "今日任务 "+$(this).parent().attr('date');
            if( offset.top + 200 > $(".div_body").height() ){
                pointTop = offset.top - 200 ;
            }else{
                pointTop = offset.top - 20 ;
            }

            if( ( offset.left + 240 + day_box_width ) > $(".div_body").width() ){
                pointLeft = offset.left - 240 - 20 ;
            }else{
                pointLeft = offset.left + day_box_width ;
            }

			$.get("/myt/index.php/Lib/"+active+"/", function(data,status){
				var task_day_title = "<div class=\"task_day_line\" style=\"position: relative;width: "+task_day_width+"px;height: 20px;background-color: #000000;color: #FFFFFF; padding: 0px 10px 0px 10px ;font-weight: bold;\">"+task_title+"</div>"+data;
				$(".task_day_div").html( task_day_title );
                //alert($(".task_level_line").height());
                $(".task_day_div").css("top",pointTop);
                $(".task_day_div").css("left",pointLeft);

                //alert(pointLeft+"-"+pointTop);
                $(".task_day_div").toggle();

                $(".task_day_line").click(function(){
                    var tid = $(this).attr("tid");
                    // alert( tid );

                    TaskWindow = window.open("/myt/index.php/Task/edit_task/tid/"+tid+"/",tid,"width=820,height=620,menubar=no,toolbar=no,location=no,scrollbars=no,status=no,modal=yes");
                    TaskWindow.focus();
                });
			});
	});


    $(".task_day_div").bind("mouseenter",function(){
        $(".task_day_div").css("opacity","1");
        $(".task_day_div").stop();
    });

    $(".task_level_div,.day_box_min,.task_day_div,.day_box_date,.task_box_date").bind("mouseleave",function(){
        $(".task_level_div").clearQueue().fadeOut(500);
        $(".task_day_div").clearQueue().fadeOut(1500);
    });

    $('select[name="T_exp_time"]').change(function(){
        //alert('test');
        var val = $('select[name="T_exp_time"]').val();
        if ( val == 0 ){
            $(".predict_end_time_div").show();
        } else {
            $(".predict_end_time_div").hide();
            $('.predict_end_time_div input[name="T_expd_end"]').val("");
            $('.predict_end_time_div input[name="T_expt_end"]').val("");
        }
    });

    /*  实时列出与输入搜索条件相符的任务 */
    $('.tools_bar_search').keydown(function(e){
        e = e.keyCode;
        if( e == 13 || e == 32){
            //alert(e);
            search_data = $('input[name="task_search"]').val();
            if( !search_data && typeof(search_data) != "undefined" ){
                alert('搜索内容不能为空!');
            } else {
                TaskWindow = window.open("/myt/index.php/Lib/task_search/search_data/"+search_data+".html",search_data,"width=820,height=620,menubar=no,toolbar=no,location=no,scrollbars=no,status=no,modal=yes");
                TaskWindow.focus();
            }
        }
    });



    $('#tools_bar_search_button').click(function(){
        search_data = $('input[name="task_search"]').val();
        if( !search_data && typeof(search_data) != "undefined" ){
            alert('搜索内容不能为空!');
        } else {
            TaskWindow = window.open("/myt/index.php/Lib/task_search/search_data/"+search_data+".html",search_data,"width=820,height=620,menubar=no,toolbar=no,location=no,scrollbars=no,status=no,modal=yes");
            TaskWindow.focus();
        }
    });

    $('.task_search_data_line').click(function (){
        var tid = $(this).attr('tid');
        //alert( $(this).attr('tid'));
        TaskWindow = window.open("/myt/index.php/Task/edit_task/tid/"+tid+"/",tid,"width=820,height=620,menubar=no,toolbar=no,location=no,scrollbars=no,status=no,modal=yes");
        TaskWindow.focus();
    });

    $("#task_templet_manager").click(function(){
        TaskWindow = window.open("/myt/index.php/Lib/task_templet/","task_templet_manager","width=820,height=620,menubar=no,toolbar=no,location=no,scrollbars=no,status=no,modal=yes");
        TaskWindow.focus();
    });

    $("#task_files_manager").click(function(){
        TaskWindow = window.open("/myt/attached/","task_files_manager","width=820,height=620,menubar=no,toolbar=no,location=no,scrollbars=yes,status=no,modal=yes");
        TaskWindow.focus();
    });

    $("#ago_page,#after_page").click(function(){
        var total_page = $("#total_page").attr('page');
        var ago_page = $("#ago_page").attr('page');
        var click_this = $(this).attr('page');
        var after_page = $("#after_page").attr('page');
        var url = window.location.href;
        var page_num = 0;

        if ( total_page != 0 && typeof(total_page) != "undefined" && click_this > 0 ){
                if( click_this == after_page && total_page > after_page){
                    $("#ago_page").attr('page',( parseInt(ago_page) + 1 ) );
                    $("#after_page").attr('page',( parseInt(after_page) + 1 ) );
                    page_num = after_page;
                    $("#cur_page").text( parseInt(page_num) + 1 );
                } else if ( click_this == ago_page && ago_page > 0 ){
                    $("#ago_page").attr('page',( parseInt(ago_page) - 1 ) );
                    $("#after_page").attr('page',( parseInt(after_page) - 1 ) );
                    page_num = ( parseInt(ago_page) - 1 );
                    $("#cur_page").text( ( parseInt(after_page) - 1 ) );
                } else {
                    alert('往后没有页可以翻!');
                    page_num = ( parseInt(after_page) - 1 );
                }

                $.get(url+'/page/'+page_num, function(data,status){
                    $(".task_search_data_content").html(data);
                    //alert(page_num);

                    $('.task_search_data_line').click(function (){
                        var tid = $(this).attr('tid');
                        //alert( $(this).attr('tid'));
                        TaskWindow = window.open("/myt/index.php/Task/edit_task/tid/"+tid+"/",tid,"width=820,height=620,menubar=no,toolbar=no,location=no,scrollbars=no,status=no,modal=yes");
                        TaskWindow.focus();
                    });
                });
        } else {
            alert('往前没有页可以翻!');
        }
    });

    $(".day_box_min_count").click(function(){
        var val = $(this).attr('val');
        var date = $(this).attr('date');
        var url = window.location.href;
        //alert( $(this).attr('tid'));
        //alert( date );
        //alert(url+"Lib/list_task_level/level/"+val+"/");
        TaskWindow = window.open("/myt/index.php/Lib/task_level/level/"+val+"/date/"+date,val,"width=820,height=620,menubar=no,toolbar=no,location=no,scrollbars=no,status=no,modal=yes");
        TaskWindow.focus();
    });

    $(".run_task_count").click(function(){
        var date = $(this).attr('date');
        //alert( date );
        TaskWindow = window.open("/myt/index.php/Lib/show_run_task/date/"+date,date,"width=820,height=620,menubar=no,toolbar=no,location=no,scrollbars=no,status=no,modal=yes");
        TaskWindow.focus();
    });

    $(".run_task_count").click(function(){
        var date = $(this).attr('date');
        //alert( date );
        TaskWindow = window.open("/myt/index.php/Lib/show_run_task/date/"+date,date,"width=820,height=620,menubar=no,toolbar=no,location=no,scrollbars=no,status=no,modal=yes");
        TaskWindow.focus();
    });


    $(".month_count").click(function(){
        var date = $(this).attr('date');
        //alert( date );
        TaskWindow = window.open("/myt/index.php/Lib/show_month_task/date/"+date,date,"width=820,height=620,menubar=no,toolbar=no,location=no,scrollbars=no,status=no,modal=yes");
        TaskWindow.focus();
    });

    $('input[name="T_title"],select[name="T_level"],input[name="T_d_start"],input[name="T_t_start"],select[name="T_exp_time"],input[name="T_expd_end"],input[name="T_expt_end"]').change(function(){
        is_change = true;
        // alert(is_change);
    });
});

function ShowLevel( level ){
	 var level_tag = '';
    while ( level > 0 ){
        level_tag =  level_tag+"★";
        level = level - 1;
    }
	return "<font color=\"#FFFFFF\">"+level_tag+"</font>";
}
