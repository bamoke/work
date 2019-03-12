/**
 * Created by joy.wangxiangyin on 2017/6/24.
 */
require.config({
    "paths":{
        "jqvalidate":"../Unit/jquery.validate.min"
    },
    "shim":{
        "jqvalidate":{deps:["jq"]}
    }
});

require(['../Common/init'],function(){
    require(["base","jqvalidate"],function(bs){


        $.validator.setDefaults({
            errorElement:"div",
            errorPlacement: function(error, element) {
                error.appendTo(element.closest('.form-group').find('.js-tips'));
            }
        });
        
 
        var isLoaded = true;
        var $downloadForm = $('form[name="download-form"]')

        /****表单提交***/
        $.validator.setDefaults({
            submitHandler: function(form) {
                //debugger;
                var formData = new FormData(form);
                var ajaxOpt = {
                    url:form.action,
                    type:'post',
                    data:formData,
                    contentType: false,
                    processData: false,
                    dataType:"json",
                    success:function(res){
                        if(res.status){
                            bs.tips(res.msg,'success',function(){window.location = res.jump});
                        }else {
                            bs.tips(res.msg,'warning');

                        }
                    }
                }
                bs.main_ajax(ajaxOpt,isLoaded);
                return false;
            }
        });


        /****表单验证***/

        $downloadForm.validate({
            rules:{
                title:'required',
                file:{
                    required:function(){
                       return $("#iseditform").val() == 0
                    }
                }
                // description:'required'

            },
            messages:{
                title:'名称不能为空',
                file:'附件不能为空'
            }
        });


        $('.js-table-list').find('.js-del-one').click(function(){

            var url = $(this).data('url'),that =this;
            if(window.confirm("确认删除？")){
                $.get(url,function(){
                    $(that).parents('tr').remove();
                })
            }

        })


   })
});