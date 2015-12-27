$(function(){
    $('#task_add').click(function(){
        alert('add');
    });

    $('.task_pause_panel,.task_waiting_panel,.task_notstart_panel').click(function(){
        var tid = $(this).attr('tid');

        alert('Runting...'+ tid);
    });
});
