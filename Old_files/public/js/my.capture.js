$(document).ready(function(_aoWin, _aoUndefine){
    MI.Capture = {};
    var _oNavigator = navigator, _sAgent = _oNavigator.userAgent.toLowerCase(), _bIsWin = /(windows|win32)/
        .test(_sAgent),_bIsMac = _sAgent.indexOf("mac")>-1, _bIsOpera = _sAgent.indexOf("opera") > -1, _bIsIE = (_sAgent
        .indexOf("compatible") > -1 && !_bIsOpera)
        || _sAgent.indexOf("msie") > -1, _bIsKHTML = /(khtml|konqueror|applewebkit)/
        .test(_sAgent), _bIsFF = _sAgent.indexOf("gecko") > -1
        && !_bIsKHTML, _sFFVer = /firefox\/((\d|\.)+)/i.test(_sAgent)
        && RegExp.$1,_bIsWebkit = _sAgent.indexOf("applewebkit")>-1,_bIsChrome=_bIsWebkit&&_sAgent.indexOf("chrome") >-1;

    alert(_oNavigator);
});
