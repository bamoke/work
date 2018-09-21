/**
 * Created by joy.wangxiangyin on 2017/6/24.
 */
require.config({
    "paths":{
        'ueditor':rootDir+"/Public/Js/ueditor433/ueditor.all.min",
        'ueditor_conf':rootDir+"/Public/Js/ueditor433/ueditor.config",
        "ZeroClipboard":rootDir+"/Public/Js/ueditor433/third-party/zeroclipboard/ZeroClipboard.min",
        "jqvalidate":"../Unit/jquery.validate.min"
    },
    "shim":{
        "ueditor":{exports:"UE"},
        "jqvalidate":{deps:["jq"]}
    }
});

require(['../Common/init'],function(){
    require(["base","ueditor","ZeroClipboard","ueditor_conf","jqvalidate"],function(bs,UE,ZeroClipboard){

        /***编辑器配置***/
        if(document.getElementById("editorContainer")){
            window['ZeroClipboard'] = ZeroClipboard;
            var ue = UE.getEditor('editorContainer',{
                initialFrameHeight:200,
                maximumWords:5000,
                toolbars:[['source', '|','bold', 'italic', 'underline', 'fontborder','justifyleft', 'justifycenter', 'justifyright', 'justifyjustify','simpleupload','inserttable','insertorderedlist', 'insertunorderedlist','|','cleardoc']]
            });
        }

        $.validator.setDefaults({
            errorElement:"div",
            errorPlacement: function(error, element) {
                error.appendTo(element.closest('.form-group').find('.js-tips'));
            }
        });
        
        /***上传缩略图**/
        var $curUpload = $("#js-thumb-upload-panel"),
            $thumb = $curUpload.find('.thumb');
        $curUpload.find(".add-btn").click(function(){
            $curUpload.find(".js-file-input").click();
        });

        $curUpload.find(".js-file-input").change(function(){
            var file = this.files[0];
            var reader = new FileReader(file);
            reader.readAsDataURL(file);
            reader.onload=function(){
                $thumb.prop('src',this.result).parent().removeClass('hidden');
                $curUpload.find(".add-btn").addClass('hidden')
            }
        })
        $curUpload.find('.del-btn').click(function(){
            $(this).siblings('.thumb').prop('src','').parent().addClass('hidden');
            $curUpload.find(".add-btn").removeClass('hidden');
            $curUpload.find(".js-file-input").val('');
            $curUpload.find(".js-old-thumb").val('');
        })
        var isLoaded = true;
        var $fairsForm = $('form[name="fairs-form"]')

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

        $fairsForm.validate({
            rules:{
                title:'required',
                // description:'required'

            },
            messages:{
                title:'展会名称不能为空',
                // description:'"新闻描述不能为空'
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