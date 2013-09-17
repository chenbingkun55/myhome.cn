KindEditor.plugin('FinishTab', function(K) {
        var editor = this, name = 'FinishTab';
		var date;
		var unixtime = new Date().getTime()
		unixtime_temp = new Date(unixtime);
		date = unixtime_temp.toLocaleString();
        // 点击图标时执行
        editor.clickToolbar(name, function() {
                editor.insertHtml("<span style=\"font-size:16px;background-color:#009900;color:#FFFFFF;\"><strong>己完成: <span style=\"font-size:9px;\">"+date+"</span></strong></span>");
        });
});