$(document).ready(function(){
  $("button").click(function(){
          var txt="";
          txt+="Document width/height: " + $(document).width();
          txt+="x" + $(document).height() + "\n";
          txt+="Window width/height: " + $(window).width();
          txt+="x" + $(window).height();
          alert(txt);
  });

    $(".day_box_min").mouseover(function( ){
        //alert( $(this).attr('val')+$(this).parent().parent().attr('val'));
        $.get("/myt/index.php/Lib/show_level_task/date/"+$(this).parent().parent().attr('val')+"/level/"+$(this).attr('val')+"/", function(data,status){
        $("body").append().html( data );
        });
    });

	$("#status_bar").css("height","30px");
	$("#tools_bar").css("height","30px");
	$("#cal_tools").css("height","40px");
	
	var box_height = Math.floor(($(document).height() - 60 - 50)/9);
	var day_box_width = Math.floor(($(document).width() -90)/7);
	var cal_box_height = box_height*6;
	var cal_point_height = cal_box_height - 10;
	var day_box_height = box_height - 10;
	$("#today_task").css("height",box_height);
	$("#grade_task").css("height",box_height);
	$("#delay_task").css("height",box_height);
	$("#calendar").css("height",cal_box_height);
	$(".day_box").css("height",day_box_height).css("width",day_box_width);
	$(".title_box").css("width",day_box_width);
	$(".forward_point").css("height",day_box_height).css("width","15px");
	$(".after_point").css("height",day_box_height).css("width","15px");
	$(".cal_forward_point").css("height",cal_point_height);
	$(".cal_after_point").css("height",cal_point_height);


});
