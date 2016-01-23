$(document).ready(function(){
    $.extend({notify:function(notify_text,long){
           var set_time = 3000;
           if(long) {
               set_time = 10000;
           }

           alert(notify_text);
    }});

    $.extend({task_add:function(){
        //var send_data = editor.html();

        $.ajax({
          type: 'POST',
          url: '/index.php/Home/Task/add',
          data: { name: 'BBBB', tid: '123' },
          success: function(re_data){ alert(re_data); }
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

    $.extend({task_close_save:function(tid){
        var send_data = editor.html();

        $.ajax({
          type: 'POST',
          url: '/index.php/Home/Task/save',
          data: { tid: tid, is_close: 'yes', content: send_data },
        });
    }});

    // 添加任务
    $('.task_add_button').click(function(){
        $.task_add();
    });

    // 开始执行任务，打开运行任务弹窗
    $('.task_pause_panel,.task_waiting_panel,.task_notstart_panel').click(function(){
        var url = "/index.php/Home/Task/show?tid=" + $(this).attr('tid');

        $('.task_runing_modal_content').load(url);
        $('.task_runing_modal').modal({
            backdrop: false,   // 点击背景不关闭 modal.
            show: true
        });
    });

    $('.task_runing_modal').on('shown.bs.modal', function (e) {
        // 动态加载 KindEditor,解决不显示编辑器问题.
        $.getScript('Public/kindeditor/kindeditor.js', function() {
            KindEditor.basePath = 'Public/kindeditor/';
            editor = KindEditor.create('textarea[name="content"]',kindeditor_options);
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
