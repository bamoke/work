/**
 * Created by joy.wangxiangyin on 2015/12/2.
 */
require.config({
    'paths':{'jquery':'/work/yang/Public/Js/jquery-1.10.1.min'}
})

define(['jquery'],function($){
    return {
        //左侧菜单滑动脚本
        'slideMenu':function(){
            $('#sideBar > .cateName').click(function(){
                $(this).next().slideDown("fast").siblings(".childCateList").slideUp("fast")
            })
        }
    }
})