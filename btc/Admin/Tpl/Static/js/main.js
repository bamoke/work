/**
 * Created by joy.wangxiangyin on 2015/12/2.
 */
require.config({
    'paths':{'jqcommon':'jquery.common'}
})

require(['jqcommon'],function(jqcommon){
    /*加载公用脚本文件*/
    jqcommon.slideMenu()
})