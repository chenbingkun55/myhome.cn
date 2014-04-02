/**
 * MI.Capture 截屏控件
 *
 * @namespace MI.Capture 截屏控件
 * @author xhlv@tencent.com
 * @type Object
 */

MI.Capture = {};
(function(_aoWin, _aoUndefine) {
    // 浏览器信息



    var _oNameMap = {
            screencapture : 0,
            // 'UploadFilePartition' : 1, ftn代替了
            uploader : 2,
            ftn : 3,
            dropfile : 4
        },

        _oPicTypeMap = {
            bmp : 0,
            jpg : 1,
            gif : 2
        },

    // 工具函数
        _fParseInt = parseInt,

        _fExtend = function(_aoDest, _aoSrc, _abForce) {
            for (var i in _aoSrc) {
                if (_aoDest[i] == _aoUndefine || _abForce) {
                    _aoDest[i] = _aoSrc[i];
                }
            }
        },

        _fCallback = function(_aoThis, _afCallBack, _aoParamList) {
            try {
                return typeof _afCallBack == "function" ? _afCallBack.call(_aoThis,
                    _aoParamList) : null;
            } catch (e) {
                throw e;
            }
        },

        _fUnikey = function(_asPrefix) {
            return [_asPrefix, +new Date, Math.random()].join("").split(".")
                .join("");
        };

    // 控件信息
    var _sAliasTXGYMailActiveX = 'TXGYMailActiveX.', _sAliasScreenCapture = 'ScreenCapture', _sAliasUploader = 'Uploader', _sAliasFTNUpload = 'FTNUpload', _sActiveXDefaultId = _fUnikey('FF'), _oActiveXInfo = {
        _mbAble : false
    };
    if (_bIsIE) {
        _oActiveXInfo = {
            _msLastWholeVer : '1.0.1.32', // 以1.0.1.32为基点，以后每个控件的版本号+1，对应的位置+1，
            // 比如:
            // 拖拽从1.0.0.8升为1.0.0.9，那么这时版本号为1.0.1.33
            _msCurWholeVer : "", // 整个控件的版本号
            _mbAble : true, // 特别的限制

            // 暂时没用
            // _msPath: "/activex/",
            // _msOnline : "TencentMailActiveX.cab",
            // _msDownload : "TencentMailActiveXInstall.exe",

            _moProgId : [_sAliasTXGYMailActiveX + _sAliasScreenCapture, "",
                _sAliasTXGYMailActiveX + _sAliasUploader,
                "TXFTNActiveX." + _sAliasFTNUpload,
                _sAliasTXGYMailActiveX + "DropFile"],
            _moCurVer : new Array(5),
            _moBaseVer : ["0.0.0.1", "", "1.0.1.31", "1.0.0.12", "1.0.0.8"], // _moBaseVer作为基点，是不变的，用来计算整个控件的版本号
            _moLastVer : ["1.0.1.31", "", "1.0.1.31", "1.0.0.12", "1.0.0.8"],
            _moMiniVer : ["1.0.0.28", "", "1.0.1.28", "1.0.0.10", "1.0.0.7"]
        };
    } else if (_bIsFF) {
        var _oFFVer = _sFFVer.split("."), _sAliasQQMailPlugin = "QQMail Plugin";
        _oActiveXInfo = {
            _msLastWholeVer : '1.0.1.32',
            _msCurWholeVer : "", // 整个控件的版本号
            _mbAble : _bIsWin
                && _bIsFF
                && _oFFVer[0] >= 3
                && (_oFFVer[1] > 0 || _oFFVer[2] >= 8 || parseInt(_oNavigator.buildID
                .substr(0, 8)) >= 20090701),

            // 暂时没用
            // _msPath: "/xpi/",
            // _msOnline : "TencentMailPlugin.xpi",
            // exe : "QQMailFireFoxplugin.exe",

            _moProgId : [_sAliasScreenCapture, "", _sAliasUploader,
                _sAliasFTNUpload, ""],
            _moPluginName : [_sAliasQQMailPlugin, "", _sAliasQQMailPlugin,
                "Tencent FTN plug-in", _sAliasQQMailPlugin],
            _moCurVer : new Array(5),
            _moBaseVer : ["0.0.0.2", "", "1.0.1.32", "1.0.0.1", "1.0.0.0"],
            _moLastVer : ["1.0.1.32", "", "1.0.1.32", "1.0.0.1", "1.0.0.2"],
            _moMiniVer : ["1.0.0.28", "", "1.0.1.28", "1.0.0.1", "1.0.0.0"]
        };
    }
    else if(_bIsWin && _bIsChrome){
        var _sAliasQQMailPlugin = "QQMail Plugin";
        _oActiveXInfo = {
            _msLastWholeVer : '1.0.1.32',
            _msCurWholeVer : "", // 整个控件的版本号
            _mbAble : true,
            _moProgId : [_sAliasScreenCapture, "", _sAliasUploader,
                _sAliasFTNUpload, ""],
            _moPluginName : [_sAliasQQMailPlugin, "", _sAliasQQMailPlugin,
                "Tencent FTN plug-in", _sAliasQQMailPlugin],
            _moCurVer : new Array(5),
            _moBaseVer : ["0.0.0.2", "", "1.0.1.32", "1.0.0.1", ""],
            _moLastVer : ["1.0.1.32", "", "1.0.1.32", "1.0.0.1", ""],
            _moMiniVer : ["1.0.0.28", "", "1.0.1.28", "1.0.0.1", ""]
        };
    } else if(_bIsMac && _bIsWebkit){
        var _sAliasQQMailPlugin = "QQMailPlugin";
        _oActiveXInfo = {
            _msLastWholeVer : '1.0.1.32',
            _msCurWholeVer : "", // 整个控件的版本号
            _mbAble : true,
            _moProgId : [_sAliasScreenCapture, "", _sAliasUploader,
                _sAliasFTNUpload, ""],
            _moPluginName : [_sAliasQQMailPlugin, "", _sAliasQQMailPlugin,
                "", _sAliasQQMailPlugin],
            _moCurVer : new Array(5),
            _moBaseVer : ["0.0.0.2", "", "1.0.1.32", "", ""],
            _moLastVer : ["1.0.1.32", "", "1.0.1.32", "", ""],
            _moMiniVer : ["1.0.0.28", "", "1.0.1.28", "", ""]
        };
    }

    var _qmActivex = {
        /**
         * 整个控件最新版本号
         */
        lastVersion : _oActiveXInfo._msLastWholeVer,

        /**
         * 获取控件的版本号
         *
         * @param {String|Integer}
         *            _asType如果值为screencapture, uploader, ftn,
         *            dropfile，就获取具体的控件的版本号; 否则，就是获取整个控件的版本号；为integer一般为内部用的
         * @return {String} 版本号，如果没有安装控件，返回空字符串
         */
        getVersion : function(_asType) {
            if (!_oActiveXInfo._mbAble) {
                return "";
            }
            var _oSelf = this, _nType = typeof _asType == 'number'
                ? _asType
                : _oNameMap[_asType];
            if (_nType === _aoUndefine) {
                if (_oActiveXInfo._msCurWholeVer) {
                    return _oActiveXInfo._msCurWholeVer;
                }
                // 版本号的策略：看_oInfosIE的定义
                for (var _sConcreteVer, _oVersion = [0, 0, 0, 0], i = 0; i < 5; i++) {
                    if (_sConcreteVer = _oSelf.getVersion(i)) {
                        for (var _oConcreateVer = _sConcreteVer.split('.'), _oBaseVer = _oActiveXInfo._moBaseVer[i]
                            .split('.'), j = 0; j < 4; j++) {
                            _oVersion[j] += parseInt(_oConcreateVer[j])
                                - _oBaseVer[j];
                        }
                    }
                }
                return _oVersion[0] ? (_oActiveXInfo._msCurWholeVer = _oVersion
                    .join('.')) : '';
            } else {
                var _oCurVer = _oActiveXInfo._moCurVer;
                if (!_oCurVer[_nType]) {
                    _oSelf._createActiveX(_nType, _sActiveXDefaultId);
                }
                return _oCurVer[_nType] || '';
            }
        },

        /**
         * 判断当前是否支持运行插件
         *
         * @param {String}
         *            _asType 类型，值为screencapture, uploader, ftn, dropfile
         * @return {Integer} 1: 旧但能用, 2: 最新版的 -1: 太旧不能用 -2: 没安装插件 -3: 浏览器不支持安装控件
         *         -4: 控件不支持该域(只能用在qq.com或foxmail.com中) -5: 参数非法
         *
         */
        isSupport : function(_asType) {
            var _oSelf = this, _sVersion, _nType = _oNameMap[_asType];
            if (_nType !== _aoUndefine) {
                if (!/:\.(qq|foxmail)\.com\//i.test(_aoWin.location.href)
                    && document.domain != 'qq.com') {
                    return -4;
                }
                if (!_oActiveXInfo._mbAble) {
                    return -3;
                }
                if (!(_sVersion = _oSelf.getVersion(_asType))) {
                    return -2;
                }
                if (_sVersion == _oActiveXInfo._moLastVer[_nType]) {
                    return 2;
                }
                for (var _oCurVersion = _sVersion.split('.'), _oMinVersion = _oActiveXInfo._moMiniVer[_nType]
                    .split('.'), i = 0; i < 4; i++) {
                    if (parseInt(_oCurVersion[i]) < parseInt(_oMinVersion[i])) {
                        return -1;
                    }
                }
                return 1;
            }
            return -5;
        },

        /**
         * 判断当前是否支持运行插件
         *
         * @param {String}
         *            _asType 类型，值为screencapture, uploader, ftn, dropfile
         * @return {Object} Object，插件对象 或 null，这时用isSupport看看什么异常
         */
        getInstance : function(_asType) {
            var _oSelf = this, _nType = _oNameMap[_asType];
            if (_oActiveXInfo._mbAble && _nType !== _aoUndefine) {
                try {
                    return new ([_qmActivex._screencapture, null,
                        _qmActivex._uploader, _qmActivex._ftn,
                        _qmActivex._dropfile][_nType])(_qmActivex
                            ._createActiveX(_nType));
                } catch (e) {
                }
            }
            return null;
        },

        /**
         * 打开下载控件的页面
         *
         * @param {Object}
         *            _aoWin 如果是window，那么就window.location.replace，在原来的窗口打开,
         *            如果是null，就新窗口打开
         * @return {Boolean} 是否打开成功
         */
        openDonwload : function(_aoWin) {
            // 由于version用来cache，如果用户调用这个函数，认为控件有更新，version的cache清掉
            var _oSelf = this;
            _oActiveXInfo._msCurWholeVer = '';
            _oActiveXInfo._moCurVer = new Array(5);

            // _oActiveXInfo

            // bingjun todo

            return true;
        },

        // 私有函数//////////////////////////////////////
        /**
         * 获取具体插件的实例
         *
         * 对于FF插件，ftn的每个实例都是一个embed，如果不能太多的实例，就需要传进一个id来命名
         *
         * @param {Integer}
         *            _anActivexId 0, 2, 3, 4 详细看_oNameMap
         * @param {String}
         *            _asAddonInstanceId 只用在FF的ftn，作为id
         * @return {Object} 如果null，获取失败
         */
        _createActiveX : function(_anActivexId, _asAddonInstanceId) {
            var _oSelf = this;
            _oInstance = null;
            if (_bIsIE) {
                try {
                    _oInstance = new ActiveXObject(_oActiveXInfo._moProgId[_anActivexId]);
                    // 顺便获取插件的版本号
                    // IE的activex的DropFile是没有Version的，拿最新那个
                    _oActiveXInfo._moCurVer[_anActivexId] = _anActivexId == 4
                        ? _oActiveXInfo._moLastVer[4]
                        : _oInstance.version;
                } catch (_oError) {
                }
            } else if (_oSelf._checkInstallPlugin(_anActivexId)) {
                var _oDoc = _aoWin.document, _oAddonIns, _sInsid = "QQMailFFPluginIns";
                if (_anActivexId == 3) {
                    _sInsid = _asAddonInstanceId || _sInsid + (+new Date);
                    if (!(_oAddonIns = _oDoc.getElementById(_sInsid))) {
                        _oAddonIns = _oDoc.createElement('embed');
                        _oAddonIns.id = _sInsid;
                        _oAddonIns.type = "application/txftn";
                        // _oAddonIns.hidden = "true";
                        _oAddonIns.setAttribute("hidden", "true");
                        _oDoc.body.appendChild(_oAddonIns);
                    }
                    _oInstance = _oAddonIns.Version ? _oAddonIns : null;
                } else {
                    if (!(_oAddonIns = _oDoc.getElementById(_sInsid))) {
                        _oAddonIns = _oDoc.createElement('embed');
                        _oAddonIns.id = _sInsid;
                        _oAddonIns.type = _bIsFF ? "application/x-tencent-qmail" :  "application/x-tencent-qmail-webkit";
                        // _oAddonIns.hidden = "true";
                        _oAddonIns.setAttribute("hidden", "true");
                        _oDoc.body.appendChild(_oAddonIns);
                    }
                    var _sFun = {
                        0 : "CreateScreenCapture",
                        2 : "CreateUploader",
                        4 : "CreateDragDropManager"
                    }[_anActivexId];
                    if (typeof _oAddonIns[_sFun] != "undefined") {
                        _oInstance = _oAddonIns[_sFun]();
                    }
                }
                if (_oInstance) {
                    // 顺便获取插件的版本号
                    _oActiveXInfo._moCurVer[_anActivexId] = _oInstance.Version;
                }
            }
            return _oInstance;
        },

        /**
         * 检查浏览器有没装插件
         *
         * @param {Integer}
         *            _anPluginId 0, 2, 3, 4 详细看_oNameMap
         * @return {Boolean} 是否安装了插件
         */
        _checkInstallPlugin : function(_anPluginId) {
            var _sName = _oActiveXInfo._moPluginName[_anPluginId], _bCheckPluginVersion = _anPluginId != 3
                && (_sAgent.indexOf("vista") > -1 || /nt 6/gi.test(_sAgent)), _oPlugins = _oNavigator.plugins;
            if (_oActiveXInfo._mbAble && _oPlugins && _sName) {
                for (var i = _oPlugins.length - 1; i >= 0; i--) {
                    if (_oPlugins[i].name.indexOf(_sName) != -1) {
                        // 对vista和window 7用户，永远禁止他们使用第一个版本的FF插件
                        if (_bIsFF && _bCheckPluginVersion
                            && !_oPlugins[i].description.split('#')[1]) {
                            // return false;
                            continue;
                        }
                        return true;
                    }
                }
            }
            return false;
        }
    };

    _qmActivex._uploader = function(_aoActivex) {
        var _oSelf = this;
        _oSelf._moActiveX = _aoActivex;
        _oSelf._moBaseConfig = {};
    };

    _qmActivex._screencapture = function(_aoActivex) {
        this._moActiveX = _aoActivex;
    };

    MI.Capture = _qmActivex;

})(window);
/**
 * 创建控件对象
 *
 * @param {String}
 *            String 对象类型名
 * @return {Object} Object 控件对象
 *         @example
 *         MI.Capture.createActiveX('screencapture');
 *
 */
MI.Capture.createActiveX = function(type) {
    return MI.Capture.getInstance(type)._moActiveX;
}
/**
 * 截屏是否可用
 *
 * @type {Boolean} Boolean 截屏是否可用
 */
MI.Capture.enable = MI.Capture.isSupport('screencapture') > 0;
/**
 * 安装控件
 *
 * @example
 * MI.Capture.install();
 *
 */
MI.Capture.install = function() {
    alert('TESET');
    UI.ready(function() {
        UI.append(
            UI.html('<iframe onload="if(MI && MI.dialog)MI.dialog.hide();" src="'  + (UI.B.mac ? 'http://m191.mail.qq.com/zh_CN//crx/TencentMailPluginForMac.pkg' : 'http://mail.qq.com/cgi-bin/readtemplate?check=false&t=control_install&action=install') + '" style="display:none"></iframe>')[0],
            document.body);
    });
}
UI.ready(function() {
    alert('adsfasdf');
    if (MI.Capture.enable) {
        MI.Capture.screen = MI.Capture.createActiveX('screencapture');
        if (MI.Capture.screen) {
            MI.Capture.screen.OnCaptureFinished = function() {
                MI.Capture.screen.BringToFront(window);
                MI.Capture.upload();
            }
        }
        MI.Capture.uploader = MI.Capture.createActiveX('uploader');
        if (MI.Capture.uploader) {
            MI.Capture.uploader.URL = 'http://upload.t.qq.com/asyn/uploadpic.php';
            MI.Capture.uploader.CodePage = 65001;
            MI.Capture.uploader.AddHeader('cookie', document.cookie);
            MI.Capture.uploader.OnEvent = function(obj, eventID, p1, p2, p3) {
                var percent;
                switch (eventID) {
                    case 1 : // Error
                        break;
                    case 2 : // Progress
                        percent = p1 * 100 / p2;
                        break;
                    case 3 : // Finished
                        if (MI.talkBox) {
                            var json = MI.Capture.uploader.Response.replace(
                                    'parent.MI', 'MI').replace("'image'",
                                    "'fileName':MI.Capture.fileName,'image'");
                            UI.evalScript(json);
                        }
                        break;
                }
            }
        }
        MI.Capture.fileName = '';
        MI.Capture.upload = function() {
            var clipBoardImage = MI.Capture.screen.IsClipBoardImage, clipboardFiles = MI.Capture.uploader
                .GetClipboardFiles(), fileID;
            if ((clipBoardImage || clipboardFiles) && MI.talkBox
                && MI.talkBox.pic) {
                MI.alert('每条广播只能插入一张照片');
                return;
            }
            if (clipBoardImage) {
                fileID = MI.Capture.screen.SaveClipBoardBmpToFile(1);
                MI.Capture.fileName = '截屏.jpg';
            } else if (clipboardFiles) {
                var file = clipboardFiles.split(' ');
                fileID = file[0];
                MI.Capture.fileName = clipboardFiles.replace(fileID + ' ', '')
                    .split('\r')[0];
            }
            if (fileID) {
                MI.Capture.uploader.StopUpload();
                MI.Capture.uploader.ClearFormItems();
                MI.Capture.uploader.AddFormItem('pic', 1, 0, fileID);
                MI.Capture.uploader.StartUpload();
                if (MI.talkBox) {
                    MI.talkBox.uploadPic();
                }
                MI.Bos('btnPicCapture');
            }
        }
    } else if (MI.TalkBox.captureEnable()) {
        MI.Capture.install();
    }
});

