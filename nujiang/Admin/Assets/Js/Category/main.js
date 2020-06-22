require.config({
    paths:{
        "jqvalidate":"../Unit/jquery.validate.min"
    },
    shim:{
        "jqvalidate":{
            "deps":["jq"]
        }
    }
});

require(["../Common/init"],function(){
    require(['base',"jqvalidate"],function(base){

        $.validator.setDefaults({
            errorElement:"div",
            errorPlacement: function(error, element) {
                error.appendTo(element.closest('.form-group').find('.js-tips'));
            }
        });

        var $Form = $("#cateForm");
        var is_loaded = true;
        $Form.validate({
            rules:{
                title:"required"
            },
            messages:{
                title:"请选择栏目名称"
            },
            submitHandler:function(form){
                var ajaxOpt = {
                    url:form.action,
                    data:$(form).serialize(),
                    dataType:"json",
                    type:"post",
                    success:function(res){
                        alert(res.msg)
                        res.status && window.history.back();
                    }
                }
                base.main_ajax(ajaxOpt,is_loaded);
                return false;
            }
        })


    })
});