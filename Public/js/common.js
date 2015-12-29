$(function(){
    // 添加任务
    $('.task_add_button').click(function(){
        alert('add');
    });

    // 开始执行任务，打开运行任务弹窗
    $('.task_pause_panel,.task_waiting_panel,.task_notstart_panel').click(function(){
        var url = "/index.php/Home/Task/show?tid=" + $(this).attr('tid');
        $('.task_runing_modal_content').load(url);
        $('.task_runing_modal').modal('show');

        // 动态加载 KindEditor,解决不显示编辑器问题.
        $.getScript('Public/kindeditor/kindeditor.js', function() {
            KindEditor.basePath = 'Public/kindeditor/';
            KindEditor.create('textarea[name="content"]',kindeditor_options);
        });
    });

    // 运行任务关闭，保存并更新为暂停
    $('.task_runing_modal').on('hidden.bs.modal', function (e) {
        // 移除动态加载的 KindEditor
        KindEditor.remove('textarea[name="content"]');
        //alert('save..');

		//// 原因: KindEditor编辑器无法获得提交的数据.
		//// 解决: 添加 editor.sync(); 这一行.
		//editor.sync();
        //alert("Test");

		////$("form").submit();
    });
});
