$.validator.setDefaults({
  errorElement: "div",
  errorPlacement: function (error, element) {
    error.appendTo(element.parents('.form-group'));
  }
});
$("#js-business-form").validate({
  rules: {
    "title": { required: true, },
    "phone": { required: true },
    "email": { required: true, email: true },
    "person": { required: true },
    "content": { required: true }
  },
  messages: {
    "title": { required: "请填写标题", },
    "phone": { required: "请填写联系电话" },
    "email": { required: "请填写联系邮箱", email: "邮箱格式不正确" },
    "person": { required: "请填写联系人" },
    "content": { required: "请填写商机描述" }
  },
  submitHandler: function (form) {
    var oOpt = {
      type: 'POST',
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

$("#js-reset-form").validate({
  rules: {
    "oldpassword": { required: true, rangelength: [6, 12] },
    "newpassword": { required: true, rangelength: [6, 12] },
    "newpassword2": { required: true, rangelength: [6, 12], equalTo: "#newpassword" }
  },
  messages: {
    "oldpassword": { required: "请输入原密码", rangelength: "密码长度必须为6-12个字符内" },
    "newpassword": { required:"请输入新密码", rangelength: "密码长度必须为6-12个字符内" },
    "newpassword2": { required: '请确认新密码', rangelength: "密码长度必须为6-12个字符内", equalTo: "两次密码不一致" }
  },
  submitHandler: function (form) {
    var oOpt = {
      type: 'POST',
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

// delete record
if ($(".js-del-one").size()) {
  $(".js-del-one").click(function () {
    if (!confirm("确定删除吗？")) return false;
    var url = $(this).data("url")
    var _that = this
    $.get(url, function (res) {
      $(_that).parents("tr").remove()
    })
  })


}