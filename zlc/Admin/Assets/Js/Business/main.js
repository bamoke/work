/**
 * Created by joy.wangxiangyin on 2017/6/24.
 */
require.config({

});

require(['../Common/init'],function(){
    require(["base"],function(bs){


        if($(".js-verify-btn")){
            $(".js-verify-btn").click(function(){
                $.ajax({
                    url:$(this).data("url"),
                    type:"get",
                    success:function(res){
                        if(res.status){
                            alert("操作成功")
                            window.location.href = res.jump
                        }
                    }
                })
            })
        }







   })
});