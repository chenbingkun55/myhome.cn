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

    if ( $(document).width() < 800 ){
        $("body").css("width","812px");
    }

    if ( $(document).height() < 600 ){
        $("body").css("height","600px");
    }

	$("#status_bar").css("height","30px");
	$("#tools_bar").css("height","30px");
	$("#cal_tools").css("height","40px");
	
	var box_height = Math.floor(($(document).height() - 60 - 50)/9);
    var day_box_width = Math.floor(($(document).width() - 104)/7);
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

    $(".day_box_min").mouseover(function( ){
        $(".task_level_div").hide();
        //alert( $(this).parent().parent().attr('date'));
        $.get("/myt/index.php/Lib/show_level_task/date/"+$(this).parent().parent().attr('date')+"/level/"+$(this).attr('val')+"/", function(data,status){
            $(".task_level_div").html( data )
        });

        // 获取元素 位置,offset.left 和 offset.top
        var offset = $(this).offset();

        // parseInt($(this).text()) 将Div 里的值转化为 整数.
        var pointTop = offset.top - ( parseInt($(this).text()) * 20) ;
        var pointLeft = offset.left;

        //alert($(".task_level_line").height());
        $(".task_level_div").css("top",pointTop);
        $(".task_level_div").css("left",pointLeft);

        //alert(pointLeft+"-"+pointTop);
        $(".task_level_div").show();
        });

    $(".task_level_div").mouseover(function(){
        $(".task_level_div").fadeTo(1,1);
        $(".task_level_div").stop();
    });

    $(".task_level_div").mouseout(function(){
           $(".task_level_div").fadeOut(2000);
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
        TaskWindow = window.open("/myt/index.php/Task/"+active,val,"width=730,height=510,menubar=no,toolbar=no,location=no,scrollbars=no,status=no,modal=yes");
        TaskWindow.focus();
    });

    $(".day_box").click(function( ){
        var reVlaue = $(this).attr("tid");
        // alert(reVlaue);
        if( "undefined" == typeof reVlaue ){
            var val = $(this).attr("date");
            var active = 'create_task/date/'+val+'/';
        }else{
            var val = $(this).attr("tid");
            var active = 'edit_task/tid/'+val+'/';
        }
        TaskWindow = window.open("/myt/index.php/Task/"+active,val,"width=730,height=510,menubar=no,toolbar=no,location=no,scrollbars=no,status=no,modal=yes");
        TaskWindow.focus();
    });

    $(".task_remove").click(function(){
        // alert($(this).attr("tid"));
        $.get("/myt/index.php/Task/delete_task/tid/"+$(this).attr("tid")+"/",function(){
            self.opener.location.reload();
            window.close();
        });
    });

    /* 这个函数 不知道怎么地死活不能生效.
    $(".task_level_line").live("click",function(){
        var reVlaue = $(this).attr("tid");
        TaskWindow = window.open("/myt/index.php/Task/edit_task/tid/"+ reVlaue+"/","width=730,height=510,menubar=no,toolbar=no,location=no,scrollbars=no,status=no,modal=yes");
        TaskWindow.focus();
    });
    */
});

function TaskEdit( tid ){
    TaskWindow = window.open("/myt/index.php/Task/edit_task/tid/"+tid+"/",tid,"width=730,height=510,menubar=no,toolbar=no,location=no,scrollbars=no,status=no,modal=yes");
    TaskWindow.focus();
}

