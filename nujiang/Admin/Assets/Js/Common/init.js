/**
 * Created by joy.wangxiangyin on 2016/9/2.
 */
require.config({
    "paths":{
        "jq":rootDir + "/Assets/Plugins/jquery/jquery-1.10.1.min",
        "bt":rootDir + "/Assets/Plugins/bootstrap/js/bootstrap.min",
        "base":"../Common/base",
        "joypjax":"../Common/joypjax"
    },
    "shim":{
        "bt":{"deps":["jq"]},
        "joypjax":{"deps":["jq"]},
        "base":{"deps":['jq'],"exports":"bs"}
    }
});

require(["joypjax"],function(pjax){
    pjax.init();
});
