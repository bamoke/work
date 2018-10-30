$.validator.addMethod("uname", function (val, elem) {
    var oReg = /[\s_\d]/;
    return this.optional(elem) || (oReg.test(val));
}, "用户名只能由字母、数字、下划线组成");

$.validator.setDefaults({
    errorElement:"div",
    errorPlacement: function(error, element) {
        error.appendTo(element.parents('.form-group'));
    }
});

//  登录表单验证
$loginForm = $("#loginForm");
$loginForm.validate({
    rules: {
        "username": { required: true, },
        "password": { required: true },
        "code": { required: true }
    },
    messages: {
        "username": { "required": "请填写用户名", "rangelength": "用户名长度为5-20个字符" },
        "password": { "required": "请输入密码" },
        "code": { "required": "请输入验证码" }
    },
    submitHandler: function (form) {
        var oOpt = {
            type:'POST',
            success: function (r) {
                if (r.status) {
                    window.location.href = r.jump;
                } else {
                    alert(r.msg);
                }
            }
        }
        $(form).ajaxSubmit(oOpt)
    }
});


$("#registerForm").validate({
    rules: {
        "username": { required: true,email:true },
        "password": { required: true,rangelength:[6,12] },
        "password2":{
            required:true,
            equalTo:"#password"
        },
        "company": { required: true },
        "phone": { required: true },
        "contact": { required: true },
    },
    messages: {
        "username": { "required": "请填写邮箱", "email": "邮箱格式错误" },
        "password": { "required": "请输入密码",rangelength:'密码长度6-12个字符' },
        "password2": { "required": "请确认密码", "equalTo": "两次密码不一致" },
        "company": { "required": "请填写所属公司名称" },
        "phone": { "required": "请填写联系电话" },
        "contact": { "required": "请填写联系人姓名" }
    },
    submitHandler: function (form) {
        var oOpt = {
            type:'POST',
            success: function (r) {
                alert(r.msg);
                if (r.status) {
                    window.location.href = r.jump;
                }
            }
        }
        $(form).ajaxSubmit(oOpt)
    }  
})

//    刷新验证码
$("#verifyCode").click(function () {
    var oD = new Date(),
        sUrl = this.src.replace(/.html/, '') + "/t/" + oD.getTime();
    this.src = sUrl;
});