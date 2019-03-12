/**
 * Created by joy.wangxiangyin on 2017/6/24.
 */
require.config({
    "paths": {
        'ueditor': rootDir + "/Public/Js/ueditor433/ueditor.all.min",
        'ueditor_conf': rootDir + "/Public/Js/ueditor433/ueditor.config",
        "ZeroClipboard": rootDir + "/Public/Js/ueditor433/third-party/zeroclipboard/ZeroClipboard.min",
        "jqvalidate": "../Unit/jquery.validate.min",
        "plupload": rootDir + "/Public/Js/plupload-2.3.6/js/plupload.full.min",
        "jquery_plupload_queue": rootDir + "/Public/Js/plupload-2.3.6/js/jquery.plupload.queue/jquery.plupload.queue"
    },
    "shim": {

        "plupload": { exports: "plupload" },
        "ueditor": { exports: "UE" },
        "jqvalidate": { deps: ["jq"] },
        "jquery_plupload_queue": { deps: ["jq", "plupload"] }
    }
});

require(['../Common/init'], function () {
    require(["base", "ueditor", "ZeroClipboard", "plupload", "ueditor_conf", "jqvalidate"], function (bs, UE, ZeroClipboard, plupload) {
        // console.log(PM)
        window['plupload'] = plupload;
        require(["jquery_plupload_queue"], function () {


            /***编辑器配置***/
            if (document.getElementById("editorContainer")) {
                window['ZeroClipboard'] = ZeroClipboard;
                var ue = UE.getEditor('editorContainer', {
                    initialFrameHeight: 200,
                    maximumWords: 5000,
                    toolbars: [['source', '|', 'bold', 'italic', 'underline', 'fontborder', 'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', 'simpleupload', 'inserttable', 'insertorderedlist', 'insertunorderedlist', '|', 'cleardoc']]
                });
            }

            $.validator.setDefaults({
                errorElement: "div",
                errorPlacement: function (error, element) {
                    error.appendTo(element.closest('.form-group').find('.js-tips'));
                }
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


            var isLoaded = true;
            var $projectForm = $('form[name="project-form"]')

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
                                bs.tips(res.msg, 'success', function () { window.location = res.jump });
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

            /*888*/
            $projectForm.validate({
                rules: {
                    title: 'required',
                    class_name:"required",
                    year:"required",
                    location:"required"
                }
            });


            $('.js-table-list').find('.js-del-one').click(function () {

                var url = $(this).data('url'), that = this;
                if (window.confirm("确认删除？")) {
                    $.get(url, function () {
                        $(that).parents('tr').remove();
                    })
                }

            })

            /***
             * 
             */
            // 删除已上传文件
            $("#upload-file-list").on("click",".js-del-btn",function(){
                var $parent = $(this).parents(".file-item");
                var $filesInput = $("#js-upload-files-input")
                var oldVal = $filesInput.val().split(",")
                var curFileName = $parent.find(".file-name").text();
                oldVal.splice(oldVal.indexOf(curFileName),1)
                $(this).parents(".file-item").remove();
                $filesInput.val(oldVal.join(","))
            })
            $('#js-uploader-modal').on('show.bs.modal', function () {
                // 上传组件
                $("#uploader").pluploadQueue({
                    // General settings
                    runtimes: 'html5,flash,silverlight,html4',
                    url: $("#uploader").data("upload-url"),
                    chunk_size: '5mb',
                    rename: true,
                    dragdrop: true,

                    filters: {
                        // Maximum file size
                        max_file_size: '20mb',
                        // Specify what files to browse for
                        mime_types: [
                            { title: "Image files", extensions: "jpg,gif,png" }
                            // { title: "Zip files", extensions: "zip" }
                        ]
                    },

                    // Resize images on clientside if we can
                    // resize: { width: 320, height: 240, quality: 90 },

                    flash_swf_url: '../../js/Moxie.swf',
                    silverlight_xap_url: '../../js/Moxie.xap',
                    init: {
                        Refresh: function (up) {
                            // Called when the position or dimensions of the picker change
                            console.log(up);
                        },
                        FileUploaded: function (up, files, result) {
                            var response = JSON.parse(result.response)
                            // 获取已上传文件列表
                            let $filesInput = $("#js-upload-files-input")

                            var $filesArr;
                            if ($filesInput.val()) {
                                $filesArr = $filesInput.val().split(",")
                            } else {
                                $filesArr = []
                            }
                            if (response.code == 200) {
                                $filesArr.push(response.data.files[0])
                                var newInputVal = $filesArr.join(",")

                                // 渲染UI
                                var $filesBox = $("#upload-file-list");
                                var $filesItemHtml = $filesBox.html();
                                $filesItemHtml += '<div class="row file-item">\
                        <div class="col-xs-4"><img class="upload-img" src="'+ rootDir + '/Uploads/plupload/' + response.data.files[0] + '" alt=""></div>\
                        <div class="col-xs-8">\
                            <div class="file-name">'+ response.data.files[0] + '</div>\
                            <div class="js-del-btn btn btn-default">Delete</div>\
                        </div>\
                    </div>'

                                $filesBox.html($filesItemHtml)
                                $filesInput.val(newInputVal)

                                // 
                            }

                        },
                        UploadComplete: function (up, files) {

                        }
                    }
                });
            })
            $("#js-show-uploader").click(function () {
                $("#js-uploader-modal").modal("show");
            })




            var uploader = new plupload.Uploader({
                runtimes : 'html5,flash,silverlight,html4',
                 
                browse_button : 'pickfiles', // you can pass in id...
                container: document.getElementById('js-banner'), // ... or DOM Element itself
                multi_selection:false,
                url : $("#pickfiles").data("upload-url"),
                 
                filters : {
                    max_file_size : '10mb',
                    mime_types: [
                        {title : "Image files", extensions : "jpg,gif,png"}
                    ]
                },
             
                // Flash settings
                flash_swf_url : rootDir+'/plupload/js/Moxie.swf',
             
                // Silverlight settings
                silverlight_xap_url : rootDir+'/plupload/js/Moxie.xap',
                 
             
                init: {
                    PostInit: function() {
                        // document.getElementById('js-banner-filelist').innerHTML = '';
             
                        document.getElementById('uploadfiles').onclick = function() {
                            uploader.start();
                            return false;
                        };
                    },
             
                    FilesAdded: function(up, files) {
                        var file = files[0]
                        console.log(uploader.files.length)
                        if(uploader.files.length >1) {
                            uploader.removeFile(uploader.files[0])
                        }
                        document.getElementById('js-banner-filelist').innerHTML = '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>'
                        console.log(uploader.files)
                        return;
                        plupload.each(files, function(file) {
                            document.getElementById('js-banner-filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
                        });
                        $("#js-banner").hide();
                        $("#js-operation").show();
                    },
             
                    UploadProgress: function(up, file) {
                        console.log(up)
                        document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
                    },
                    FileUploaded:function(up, files, result){
                        var response = JSON.parse(result.response)
                        if(response.code == 200){
                            document.getElementById('js-banner-filelist').innerHTML = '<div class="row file-item">\
                            <div class="col-xs-4"><img class="upload-img" src="'+ rootDir + '/Uploads/banner/' + response.data.file + '" alt=""></div>\
                            <div class="col-xs-8">\
                                <div class="file-name">'+ response.data.file + '</div>\
                                <div class="js-del-btn btn btn-default">Delete</div>\
                            </div>\
                        </div>'
                        $("#js-banner").hide();
                        $("#js-banner-input").val(response.data.file)
                        }else {
                            alert(response.msg)
                        }
                    },
                    Error: function(up, err) {
                        document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
                    }
                }
            });
             
            uploader.init();


            // 删除已上传banner
            $("#js-banner-filelist").on("click",".js-del-btn",function(){
                var $parent = $(this).parents(".file-item");
                var $filesInput = $("#js-banner-input")
                $(this).parents(".file-item").remove();
                $("#js-banner").show();
                $filesInput.val("")
            })

            /***设置首页显示 */
            $(".js-recommend-radio").change(function(){
                if($(this).val()==1){
                    $("#js-banner-wrap").show()
                }else {
                    $("#js-banner-wrap").hide()
                }
            })
//=========//

        })
    })
});