// 

/**
 * 
 * @param {*} msg 
 * 
 */
$(function () {



    var $closureFrom = $("#closureFrom")
    var oOpt = {
        success:function(r){
            if(r.status){
                alert("操作成功")
                window.location.reload();
            }else {
                window.alert(r.msg);
            }
        }
    };

    /**
 * 添加自定义用户名验证规则
 * @param name      string
 * @param method    function
 * @param message   string
 * */

    //  登录表单验证
    $closureFrom.validate({
        rules: {
            "code": { required: true }
        },
        messages: {
            "code": { "required": "请填写优惠券码" }
        },
        errorElement: "div",
        errorPlacement: function (err, elem) {
            err.appendTo(elem.parents(".closure-form"));
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit(oOpt)
            return false
        }
    });



})