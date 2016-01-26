$(document).ready(function(){
    $.extend({notify:function(notify_text,long){
           var set_time = 3000;
           if(long) {
               set_time = 10000;
           }

           alert(notify_text);
    }});

    $.extend({task_add:function(){
        var url = "/index.php/Home/Task/add";

        $('.task_add_modal_content').load(url);
        $('.task_add_modal').modal({
            backdrop: false,   // 点击背景不关闭 modal.
            show: true
        });
    }});


    $.extend({task_save:function(tid){
        var send_data = editor.html();

        $.ajax({
          type: 'POST',
          url: '/index.php/Home/Task/save',
          data: { tid: tid, content: send_data },
          success: function(re_data){ $('.task_runing_modal_content .panel .panel-body').before(re_data); }
        });
    }});

    $.extend({task_delete:function(tid){
        $.ajax({
          type: 'POST',
          url: '/index.php/Home/Task/delete',
          data: { tid: tid },
          success: function(){ $('.runing_task_close').trigger("click"); }
        });
    }});

    $.extend({task_close_save:function(tid){
        var send_data = editor.html();

        $.ajax({
          type: 'POST',
          url: '/index.php/Home/Task/save',
          data: { tid: tid, is_close: 'yes', content: send_data },
        });
    }});

    $.extend({up_level:function(tid){
        $.ajax({
          type: 'POST',
          url: '/index.php/Home/Task/up_level',
          data: { tid: tid },
          success: function(re_level){
                $('.runing_task_level').html(re_level);
          },
        });

    }});

    $.extend({change_to_status:function(tid,status){
        $.ajax({
          type: 'POST',
          url: '/index.php/Home/Task/change_to_status',
          data: { status: status, tid: tid },
        });
    }});

    // 获取Level 列表
    $('.get_level_list').click(function(){
        var level = $(this).attr('level');
        var url = "/index.php/Home/Task/level_list?level=" + level;

        $('.level_list_modal_content').load(url);
        $('.level_list_modal').modal({
            //backdrop: false,   // 点击背景不关闭 modal.
            show: true
        });
    });

    // 获取status 列表
    $('.get_status_list').click(function(){
        var status = $(this).attr('status');
        var url = "/index.php/Home/Task/status_list?status=" + status;

        $('.status_list_modal_content').load(url);
        $('.status_list_modal').modal({
            //backdrop: false,   // 点击背景不关闭 modal.
            show: true
        });
    });

    // 添加任务
    $('.task_add_button').click(function(){
        $.task_add();
    });

    // 开始执行任务，打开运行任务弹窗
    $('.task_pause_panel,.task_waiting_panel,.task_notstart_panel').click(function(){
        var tid = $(this).attr('tid');
        var url = "/index.php/Home/Task/show?tid=" + tid;

        $.change_to_status(tid,2);
        $('.task_runing_modal_content').load(url);
        $('.task_runing_modal').modal({
            backdrop: false,   // 点击背景不关闭 modal.
            show: true
        });
    });

    $('.task_runing_modal,.task_add_modal').on('shown.bs.modal', function (e) {
        // 动态加载 KindEditor,解决不显示编辑器问题.
        $.getScript('Public/kindeditor/kindeditor.js', function() {
            KindEditor.basePath = 'Public/kindeditor/';
            editor = KindEditor.create('textarea[name="content"]',kindeditor_options);
        });

        $.getScript('Public/bootstrap-datetimepicker/bootstrap-datetimepicker.js',function() {
            $(".start_datetime").datetimepicker();
            $(".end_datetime").datetimepicker();
        });
    });


    //// 运行任务关闭，保存并更新为暂停
    //$('.task_runing_modal').on('hidden.bs.modal', function (e) {
        //// 移除动态加载的 KindEditor
        //KindEditor.remove('textarea[name="content"]');
        //alert()
        ////alert('save..');

		////// 原因: KindEditor编辑器无法获得提交的数据.
		////// 解决: 添加 editor.sync(); 这一行.
		////editor.sync();
        ////alert("Test");

		//////$("form").submit();
    //});
});
