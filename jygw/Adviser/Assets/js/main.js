// 

/**
 * 
 * @param {*} msg 
 * 
 */
$(function () {



    var $Form = $(document.forms["loginform"])
    var oOpt = {
        success: function (r) {
            if (r.status) {
                window.location.reload();
            } else {
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
        var sUrl = $(this).data("src").replace(".html", '')
        sUrl += "/t/" + oD.getTime();
        this.src = sUrl;
    });

    /***上传缩略图**/
    var $curUpload = $("#js-thumb-upload-panel"),
        $thumb = $curUpload.find('.thumb');
    $curUpload.find(".add-btn").click(function () {
        $curUpload.find(".js-file-input").click();
    });

    $curUpload.find(".js-file-input").change(function () {
        var file = this.files[0];
        var reader = new FileReader(file);
        reader.readAsDataURL(file);
        reader.onload = function () {
            $thumb.prop('src', this.result).parent().removeClass('hidden');
            $curUpload.find(".add-btn").addClass('hidden')
        }
    })
    $curUpload.find('.del-btn').click(function () {
        $(this).siblings('.thumb').prop('src', '').parent().addClass('hidden');
        $curUpload.find(".add-btn").removeClass('hidden');
        $curUpload.find(".js-file-input").val('');
        $curUpload.find(".js-old-thumb").val('');
    })


    /***
     * 个人资料修改 
     */
    var profileForm = $("#profile-form");
    //  登录表单验证
    profileForm.validate({
        rules: {
            "realname": { required: true }
        },
        messages: {
            "realname": { "required": "请填写个人姓名或称呼" }
        },
        errorElement: "div",
        errorPlacement: function (err, elem) {
            err.appendTo(elem.parents(".form-group"));
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                success: function (r) {
                    if (r.status) {
                        alert(r.msg)
                        window.location.reload();
                    } else {
                        window.alert(r.msg);
                    }
                }
            })
            return false
        }
    });


    
    /***
     * 修改密码 
     */
    var resetForm = $("#reset-form");
    //  登录表单验证
    resetForm.validate({
        rules: {
            "oldpassword": { required: true },
            "newpassword": { required: true,maxlength:12 },
            "newpassword2": { required: true,equalTo:"#newpassword" }
        },
        messages: {
            "oldpassword": { "required": "请输入原来的密码" },
            "newpassword": { "required": "请输入新密码",maxlength:"最大长度12字符" },
            "newpassword2": { "required": "请确认新密码","equalTo":"两次密码不一致" }
        },

        submitHandler: function (form) {
            $(form).ajaxSubmit({
                success: function (r) {
                    if (r.status) {
                        alert(r.msg)
                        window.location.reload();
                    } else {
                        window.alert(r.msg);
                    }
                }
            })
            return false
        }
    });


    /***
     * 提交回答
     */
    $("#replyForm").validate({
        rules: {
            "content": { required: true }
        },
        messages: {
            "content": { "required": "内容不能为空" }
        },

        submitHandler: function (form) {
            console.log($(form))
            $(form).ajaxSubmit({
                success: function (r) {
                    if (r.status) {
                        alert(r.msg)
                        window.location.href = r.jump
                    } else {
                        window.alert(r.msg);
                    }
                }
            })
            return false
        }
    })


    /**
     * 修改问题切换btn
     */
    $("#js-reply-edit-btn").click(function(){
        $("#js-reply-form-box").slideToggle()
        $("#js-my-answer-box").slideToggle()
    })

    $("#js-cancel-reply-btn").click(function(){
        $("#js-reply-form-box").slideToggle()
        $("#js-my-answer-box").slideToggle()
    })



})