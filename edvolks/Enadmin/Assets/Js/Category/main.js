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
                error.appendTo(element.parents('.form-group').find('.js-tips'));
            }
        });

        var $Form = $("#cateForm");
        var is_loaded = true;
        $Form.validate({
            rules:{
                title:"required",
                controller_name:{
                    required:function(){
                       return $("#js-column-type").val() == 'custom'
                    }
                },
                action_name:{
                    required:function(){
                       return $("#js-column-type").val() == 'custom'
                    }
                }
            },
            messages:{
                title:"请选择栏目名称",
                controller_name:{required:"请填写控制器名称"},
                action_name:{required:"请填写方法名称"}
            },
            submitHandler:function(form){
                var ajaxOpt = {
                    url:form.action,
                    data:$(form).serialize(),
                    dataType:"json",
                    type:"post",
                    success:function(res){
                        alert(res.msg)
                        if(res.status)window.location.href=res.jump
                    }
                }
                base.main_ajax(ajaxOpt,is_loaded);
                return false;
            }
        })

        // tree handel
        $("#cateTree").find(".parent").click(function(){
            $("#cateTree").find(".list").not($(this).parent()).removeClass("active").find(".child").slideUp('fast');
            $(this).parent().toggleClass("active").find(".child").slideToggle('fast')
        })

        $("#cateTree").find(".operation").find("a").click(function(e){
            e.stopPropagation();
        })
        $(".js-del-item").click(function(){
            var id = $(this).data("id")
            
        })

        // column manage
        $("#js-column-type").change(function(){
            var value = this.value
            if(value === 'custom') {
                $("#js-router-set").removeClass("hidden").find(":text").prop("disabled",false)
            }else {
                $("#js-router-set").addClass("hidden").find(":text").prop("disabled",true)
            }
        })



    })
});