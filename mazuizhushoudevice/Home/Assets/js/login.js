// 

/**
 * 
 * @param {*} msg 
 * 
 */
$(function () {
    new Wonder({
        el: "#login-background",
        dotsNumber: 100,
        lineMaxLength: 300,
        dotsAlpha: .5,
        speed: 1.5,
        clickWithDotsNumber: 5
    })


    var $Form = $(document.forms["loginform"])
    var oOpt = {
        success:function(r){
            if(r.status){
                window.location.href = r.jump;
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
    $.validator.addMethod("uname", function (val, elem) {
        var oReg = /[\s_\d]/;
        return this.optional(elem) || (oReg.test(val));
    }, "用户名只能由字母、数字、下划线组成");

    //  登录表单验证
    $Form.validate({
        rules: {
            "username": { required: true },
            "password": { required: true },
            "code": { "required": true }
        },
        messages: {
            "username": { "required": "请填写用户名" },
            "password": { "required": "请输入密码" },
            "code": { "required": "请输入验证码" }
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