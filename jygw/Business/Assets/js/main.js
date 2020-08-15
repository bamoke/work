// 

/**
 * 
 * @param {*} msg 
 * 
 */
$(function () {



    var $Form = $(document.forms["loginform"])
    var oOpt = {
        success:function(r){
            if(r.status){
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
    $Form.validate({
        rules: {
            "code": { required: true }
        },
        messages: {
            "code": { "required": "请填写优惠券码" }
        },
        errorElement: "div",
        errorPlacement: function (err, elem) {
            err.appendTo(elem.parents(".form-group"));
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit(oOpt)
            return false
        }
    });


    //    刷新验证码
    $("#verifyCode").click(function () {
        var oD = new Date()
        var sUrl =$(this).data("src").replace(".html",'')
            sUrl += "/t/" + oD.getTime();
        this.src = sUrl;
    });
})