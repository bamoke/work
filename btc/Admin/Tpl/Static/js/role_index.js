/**
 * Created by joy.wangxiangyin on 2015/12/16.
 * role_index
 */
require.config({
    'paths':{'jqcommon':'jquery.common'}
})

require(['jqcommon'],function(jqcommon){
    /*加载公用脚本文件*/
    jqcommon.slideMenu()
})