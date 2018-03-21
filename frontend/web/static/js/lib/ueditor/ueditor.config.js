(function () {
    var URL = window.UEDITOR_HOME_URL || getUEBasePath();
    window.UEDITOR_CONFIG = {
	     UEDITOR_HOME_URL: URL, 
        serverUrl: URL + "php/controller.php", 
        toolbars: [[
            /*'fullscreen',*/ 'source', '|', 'fontsize','bold', 'italic', 'underline','strikethrough','forecolor','justifyleft', 'justifycenter', 'justifyright','inserttable','insertimage','imagecenter','imageleft','imageright', 'insertvideo','img_vertical'/*,'formatmatch','autotypeset','blockquote', 'pasteplain', '|','insertorderedlist','subscript','superscript', 'insertunorderedlist', 'selectall', 'cleardoc', '|','fontborder','rowspacingtop', 'rowspacingbottom', 'lineheight', '|','customstyle', 'paragraph', 'fontfamily',  '|','removeformat','directionalityltr', 'directionalityrtl', 'indent', '|',  'justifyjustify', '|', 'touppercase', 'tolowercase', '|','link'*/ ]],
		elementPathEnabled : false,
		wordCount:false,
		zIndex:900
    };

    function getUEBasePath(docUrl, confUrl) {
        return getBasePath(docUrl || self.document.URL || self.location.href, confUrl || getConfigFilePath());
    }

    function getConfigFilePath() {
        var configPath = document.getElementsByTagName('script');
        return configPath[ configPath.length - 1 ].src;
    }

    function getBasePath(docUrl, confUrl) {
        var basePath = confUrl;
        if (/^(\/|\\\\)/.test(confUrl)) {
            basePath = /^.+?\w(\/|\\\\)/.exec(docUrl)[0] + confUrl.replace(/^(\/|\\\\)/, '');
        } else if (!/^[a-z]+:/i.test(confUrl)) {
            docUrl = docUrl.split("#")[0].split("?")[0].replace(/[^\\\/]+$/, '');
            basePath = docUrl + "" + confUrl;
        }
        return optimizationPath(basePath);
    }

    function optimizationPath(path) {
        var protocol = /^[a-z]+:\/\//.exec(path)[ 0 ],
            tmp = null,
            res = [];
        path = path.replace(protocol, "").split("?")[0].split("#")[0];
        path = path.replace(/\\/g, '/').split(/\//);
        path[ path.length - 1 ] = "";
        while (path.length) {
            if (( tmp = path.shift() ) === "..") {
                res.pop();
            } else if (tmp !== ".") {
                res.push(tmp);
            }

        }
        return protocol + res.join("/");
    }
    window.UE = {
        getUEBasePath: getUEBasePath
    };
	
	
	
})();

