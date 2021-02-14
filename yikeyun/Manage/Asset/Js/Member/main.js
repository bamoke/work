/**
 * Created by wetz1 on 2017/7/1.
 */

require.config({
});

require(['../Common/init'], function () {
    require(["base"], function () {



        /*************************/
        if($("#js-refresh-btn")) {
            $("#js-refresh-btn").click(function(){
                var url = $(this).data("url")
                console.log(url)
                $.get(url,function(){
                    alert("刷新成功")
                    window.location.reload()
                })
            })
        }



    })
});

