/**
 * Created by joy.wangxiangyin on 2017/6/24.
 */
require.config({
    "paths": {
        'ueditor': rootDir + "/Assets/Plugins/ueditor433/ueditor.all.min",
        'ueditor_conf': rootDir + "/Assets/Plugins/ueditor433/ueditor.config",
        "ZeroClipboard": rootDir + "/Assets/Plugins/ueditor433/third-party/zeroclipboard/ZeroClipboard.min",
        'datepicker': rootDir + "/Assets/Plugins/bootstrap/js/bootstrap-datetimepicker.min",
        'datepicker-languge': rootDir + "/Assets/Plugins/bootstrap/js/bootstrap-datepicker.zh-CN.min",
        "jqvalidate": "../Unit/jquery.validate.min"
    },
    "shim": {
        "ueditor": { exports: "UE" },
        "jqvalidate": { deps: ["jq"] },
        "datepicker": { deps: ["jq"] },
        "datepicker-languge": { deps: ["datepicker"] }
    }
});

require(['../Common/init'], function () {
    require(["base", "ueditor", "ZeroClipboard", "ueditor_conf", "jqvalidate", "datepicker", "datepicker-languge"], function (bs, UE, ZeroClipboard) {

        /****
         * datepicker
         */
        $('#datetimepicker').datetimepicker({
            language: 'zh-CN',
            format: 'yyyy-mm-dd',
            startDate: new Date(),
            // endDate: new Date(),
            initialDate: new Date(),
            minView: 2,
            autoclose: true
        });

        /***编辑器配置***/
        if (document.getElementById("editorContainer")) {
            window['ZeroClipboard'] = ZeroClipboard;
            var ue = UE.getEditor('editorContainer', {
                initialFrameHeight: 200,
                maximumWords: 2000,
                toolbars: [['bold', 'italic', 'underline', 'fontborder', 'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', 'simpleupload']]
            });
        }

        $.validator.setDefaults({
            errorElement: "div",
            errorPlacement: function (error, element) {
                error.appendTo(element.closest('.form-group').find('.tips'));
            }
        });


        $("#js-person-unlimited").change(function(){
            var status = $(this).prop("checked")
            var $input = $("#person-limit-input")
            $input.prop("disabled",status)
        })


        var isLoaded = true;
        var $jobsForm = $('form[name="jobs-form"]')

        /****表单提交***/
        $.validator.setDefaults({
            submitHandler: function (form) {
                //debugger;
                var formData = new FormData(form);
                var ajaxOpt = {
                    url: form.action,
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (res) {
                        if (res.status) {
                            bs.tips(res.msg, 'success', function () {
                                if (res.jump) {
                                    window.location = res.jump
                                }
                            });
                        } else {
                            bs.tips(res.msg, 'warning');

                        }
                    }
                }
                bs.main_ajax(ajaxOpt, isLoaded);
                return false;
            }
        });


        /****表单验证***/
        $jobsForm.validate({
            rules: {
                title: 'required',
                company:'required',
                link: 'required'

            },
            messages: {
                title: '岗位名称不能为空',
                company:'公司名称不能为空',
                link:'详情链接地址不能为空'
            }
        });


    })
});