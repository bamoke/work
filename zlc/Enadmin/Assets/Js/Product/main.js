/**
 * Created by joy.wangxiangyin on 2017/6/24.
 */
var rootDir = '/btc';
require.config({
    "paths":{
        "datetimepicker":rootDir+"/Public/lib/bootstrap/js/bootstrap-datetimepicker.min",
        'ueditor':[rootDir+"/Public/lib/ueditor433/ueditor.all.min"],
        'ueditor_conf':[rootDir+"/Public/lib/ueditor433/ueditor.config"],
        "ZeroClipboard":[rootDir+"/Public/lib/ueditor433/third-party/zeroclipboard/ZeroClipboard.min"],
        "jqvalidate":rootDir+"/Public/Js/jquery.validate.min"
    },
    "shim":{
        "ueditor":{exports:"UE"},
        "jqvalidate":{deps:["jq"]},
        "datetimepicker":{deps:["jq"]}
    }
});

require(['../Common/init'],function(){
    require(["base","ueditor","ZeroClipboard","ueditor_conf","jqvalidate","datetimepicker"],function(bs,UE,ZeroClipboard){

        /***编辑器配置***/
        if(document.getElementById("editorContainer")){
            window['ZeroClipboard'] = ZeroClipboard;
            var ue = UE.getEditor('editorContainer',{
                initialFrameHeight:200,
                maximumWords:2000,
                toolbars:[['bold', 'italic', 'underline', 'fontborder','justifyleft', 'justifycenter', 'justifyright', 'justifyjustify','simpleupload']]
            });
        }


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

        /****表单验证***/
        var isLoaded = true;
        var $editForm = $('form[name="edit-form"]'),
            $addForm = $('form[name="add-form"]');
        $.validator.setDefaults({
            errorElement:"div",
            errorPlacement: function(error, element) {
                error.appendTo(element.closest('.form-group').find('.tips'));
            }
        });
        $editForm.validate({
            rules:{
                parent_id:'required',
                name:'required',
                ratio:{
                    required:true,
                    number:true
                },
                ratio_manage:{
                    required:true,
                    number:true
                },
                start_amount:{
                    required:true,
                    digits:true
                },
                unlimited_buy:"required",
                close_limit:{
                    required:true,
                    digits:true
                },
                sh_way:'required',
                description:'required'
            },
            messages:{
                parent_id:"请选择产品类别",
                name:'产品名称不能为空',
                ratio:{
                    required:"年化收益率不能为空",
                    number:"必须为整数或小数"
                },
                ratio_manage:{
                    required:"管理费率不能为空",
                    number:"必须为整数或小数"
                },
                start_amount:{
                    required:"起投金额不能为空",
                    digits:"金额必须为整数"
                },
                unlimited_buy:"请选择是否限制购买时间",
                close_limit:{
                    required:"封闭期不能为空",
                    digits:"必须为整数"
                },
                sh_way:'赎回方式不能为空',
                description:'"产品描述不能为空'
            },
            submitHandler:function(form){
                //debugger;
                var formData = new FormData(form);
                $.ajax({
                    url:form.action,
                    type:'post',
                    data:formData,
                    contentType: false,
                    processData: false,
                    dataType:"json",
                    success:function(res){
                        alert(res.msg);
                        if(res.status){
                            window.location.href= res.jump;
                        }
                    },
                    complete:function(){isLoaded = true;},
                    beforeSend:function(){
                        if(isLoaded){
                            isLoaded = false;

                        }else {
                            return false;
                        }
                    }
                });
                return false;
            }
        });

        /*888*/
        $addForm.validate({
            rules:{
                parent_id:'required',
                name:'required',
                ratio:{
                    required:true,
                    number:true
                },
                ratio_manage:{
                    required:true,
                    number:true
                },
                start_amount:{
                    required:true,
                    digits:true
                },
                unlimited_buy:"required",
                close_limit:{
                    required:true,
                    digits:true
                },
                sh_way:'required',
                description:'required'
            },
            messages:{
                parent_id:"请选择产品类别",
                name:'产品名称不能为空',
                ratio:{
                    required:"年化收益率不能为空",
                    number:"必须为整数或小数"
                },
                ratio_manage:{
                    required:"管理费率不能为空",
                    number:"必须为整数或小数"
                },
                start_amount:{
                    required:"起投金额不能为空",
                    digits:"金额必须为整数"
                },
                unlimited_buy:"请选择是否限制购买时间",
                close_limit:{
                    required:"封闭期不能为空",
                    digits:"必须为整数"
                },
                sh_way:'赎回方式不能为空',
                description:'"产品描述不能为空'
            },
            submitHandler:function(form){
                //debugger;
                var formData = new FormData(form);
                $.ajax({
                    url:form.action,
                    type:'post',
                    data:formData,
                    contentType: false,
                    processData: false,
                    dataType:"json",
                    success:function(res){
                        bs.tips(res.msg);
                        if(res.status){
                            window.location.href= res.jump;
                        }
                    },
                    complete:function(){isLoaded = true;},
                    beforeSend:function(){
                        if(isLoaded){
                            isLoaded = false;

                        }else {
                            return false;
                        }
                    }
                });
                return false;
            }
        })



        /*时间插件*/
        $("#sell_start_date").datetimepicker({
            format: 'yyyy-mm-dd',
            minView:'month',
            language: 'zh-CN',
            autoclose:true,
            todayHighlight: 0,
            startDate:new Date()
        }).on("click",function(){
            $("#sell_start_date").datetimepicker("setEndDate",$("#sell_end_date").val())
        });

        $("#sell_end_date").datetimepicker({
            format: 'yyyy-mm-dd',
            minView:'month',
            language: 'zh-CN',
            todayHighlight: 0,
            autoclose:true,
            startDate:new Date()
        }).on("click",function(){
            $("#sell_end_date").datetimepicker("setStartDate",$("#sell_start_date").val())
        });


        /***选择产品类别***/
        $(".js-set-sell-date").change(function(){
            if(this.value == 1){
                //$("#setDate").show().find("input").prop("disabled",false)
                $("#setDate").show()
            }else {
                $("#setDate").hide().find("input").val("")
            }
        })

   })
});