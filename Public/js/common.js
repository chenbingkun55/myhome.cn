$(function(){
    // 添加任务
    $('.task_add_button').click(function(){
        alert('add');
    });

    // 开始执行任务，打开运行任务弹窗
    $('.task_pause_panel,.task_waiting_panel,.task_notstart_panel').click(function(){
        var url = "index.php/Home/Task/show?tid=" + $(this).attr('tid');

        $('.task_runing_modal_content').load(url);
        $('.task_runing_modal').modal('show');
    });

    // 运行任务关闭，保存并更新为暂停
    $('.task_runing_modal').on('hidden.bs.modal', function (e) {
        alert('save..');
    });
});
