<?php if (!defined('THINK_PATH')) exit();?><!--
 * @Author: Joy wang
 * @Date: 2021-04-09 05:55:40
 * @LastEditTime: 2021-04-28 20:46:32
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
-->
<!DOCTYPE html>
<html lang="zh-cmn-Hans">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=0;">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>第10届华南卵巢癌高峰论坛报名表</title>
    <style>
        html {
            font: 14px/1.5;

        }

        html,
        body,
        form,
        input,
        button {
            margin: 0;
            padding: 0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0 auto;
            padding-bottom: 48px;
            max-width: 1258px;
            background-color: #9c0001;
            background-image: url(/yidao/Home/Static/images/banner.jpg);
            background-position: top center;
            background-repeat: no-repeat;
            background-size: contain;
        }


        .u-title {
            padding: 12px 0;
            font-size: 18px;
            text-align: center;
            background-color: #1f42a6;
            color: #fff;
        }

        .form-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            overflow: hidden;
        }

        .form-label {
            flex: 0 0 auto;
            width: 96px;
            color: #464646;
            /* text-align: right; */
        }

        .form-control {
            box-sizing: border-box;
            flex: 0 1 100%;
            padding: 0 12px;
            height: 40px;
            background-color: #fff;
            font-size: 14px;
            box-shadow: none;
            border: none;
            border-radius: 4px;
            outline: unset;
            -webkit-appearance: none;
        }

        .error-box {
            position: fixed;
            top: 0;
            z-index: 9;
            display: none;
            width: 100%;
            box-sizing: border-box;
            padding: 16px 12px;
            background-color: #ff6a6a;
            color: #fff;
            line-height: 1;
            font-size: 16px;

        }

        .u-textarea {
            border-radius: 0;
            width: 100%;
            min-height: 100px;
            padding: 6px 12px;
            box-sizing: border-box;
            background-color: #fff;
            font-size: 14px;
            box-shadow: none;
            border-color: #ddd;
            border-width: thin;
            border-style: solid;
            outline: unset;
            -webkit-appearance: none;
            border-radius: 4px;
        }

        button[type='submit'] {
            margin-top: 24px;
            padding: 16px 0;
            width: 100%;
            text-align: center;
            font-size: 18px;
            background: #d40000;
            color: #fff;
            line-height: 1;
            border: 0;
            border-radius: 4px;
        }

        .m-success-page {

            padding: 20% 24px 0;
            /* height: 100%; */
            box-sizing: border-box;
            text-align: center;

        }

        .m-success-page .title {
            font-size: 24px;
            font-weight: 500;
            text-align: center;
            color: #00b609;
        }

        .m-success-page .icon {
            margin-top: 12px;
            margin-bottom: 8px;
            width: 128px;
        }

        .close-btn {
            width: 100%;
            height: 60px;
            line-height: 60px;
            text-align: center;
            background-color: #dcdcdc;
            color: #666;
            font-size: 18px;
        }

        .m-success-page .desc {
            padding: 0;
            text-align: left;
            color: #464646;
        }

        .banner {
            height: 3.2rem;

        }


        .content-wrap {
            padding: 24px;
            background-color: #faf9df;
            width: 100%;
            box-sizing: border-box;
            overflow: hidden;
        }

        .content-wrap .bar {
            display: flex;
            border-bottom: 1px solid #e7e3b9;
            padding-bottom: 12px;
        }

        .content-wrap .bar .icon {
            flex: 0 0 auto;
            margin-right: 6px;
            width: 6px;
            background-color: #9c0001;
        }

        .content-wrap .bar .section {
            font-size: 16px;
            line-height: 1;
        }

        .content-wrap .bar .section .title {
            font-weight: bold;
        }

        .content-wrap .bar .section .en {
            margin-top: 6px;
            color: #969696;
            font-size: 12px;
        }

        .content-wrap .content {
            padding-top: 24px;
        }

        .m-form-box {
            margin-top: 36px;
            padding-bottom: 48px;
        }

        .footer {
            padding-top: 24px;
            text-align: center;
            font-size: 12px;
            color: #fff;
            opacity: .6;

        }

        select {
            -webkit-appearance: none;
            appearance: none;
            border: none;
            font-size: 14px;
            padding: 0px 10px;

            display: block;
            width: 100%;
            height: 40px;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            background-color: #FFFFFF;
            color: #333333;
            border-radius: 4px;
            outline: unset;
        }

        #js-error-box {
            color: #9c0001;
        }

        .wrap {
            position: relative;

        }

        .main-content {
            box-sizing: border-box;
            padding: 0 24px 0;
        }
        .invitation-img {
            width: 100%;
        }
        .invitation-btn {
            display: block;
            margin-top:36px;
        }
    </style>
</head>

<body>
    <div class="wrap">
        <div class="banner"></div>
        <div class="main-content">
            <div class="content-wrap">
                <div class="bar">
                    <div class="icon"></div>
                    <div class="section">
                        <div class="title">会议介绍</div>
                        <div class="en">INTRODUTIONS</div>
                    </div>
                </div>
                <div class="content" style="text-indent: 2em;font-size: 16px;line-height: 1.8;">
                    2021年5月8日（星期六全天）在广州举办第10届华南卵巢癌高峰论坛，本届论坛将邀请国内外知名肿瘤专家，聚焦卵巢癌诊疗热点、疑点、难点问题，结合最新研究成果，从手术、化疗、靶向治疗、姑息治疗和临床研究等多维度进行探讨和交流。欢迎您的参与!
                </div>
            </div>
        </div>
        <a href="/yidao/Home/Static/images/invitation.pdf" class="invitation-btn"><img src="/yidao/Home/Static/images/invitation-img.jpg" class="invitation-img" alt=""></a>
        <div class="main-content">
            <div class="content-wrap m-form-box">
                <div class="bar">
                    <div class="icon"></div>
                    <div class="section">
                        <div class="title">报名信息</div>
                        <div class="en">INFOMATION</div>
                    </div>
                </div>
                <div class="content" id="js-form-box" style="display: block;">
                    <div id="js-error-box"></div>
                    <form action="<?php echo U('save');?>" id="js-feedback-form">
                        <div class="form-item">
                            <div class="form-label">姓名</div>
                            <input class="form-control" type="text" name="name" maxlength="24" placeholder="请填写您的姓名">
                        </div>
                        <div class="form-item">
                            <div class="form-label">工作单位:</div>
                            <input class="form-control" type="text" name="company" maxlength="24" placeholder="请填写工作单位">
                        </div>
                        <div class="form-item">
                            <div class="form-label">职务:</div>
                            <input class="form-control" type="text" name="position" maxlength="24"
                                placeholder="请填写您的职务">
                        </div>
                        <div class="form-item">
                            <div class="form-label">职称:</div>
                            <input class="form-control" type="text" name="title" maxlength="24" placeholder="请填写您的职称">
                        </div>
                        <div class="form-item">
                            <div class="form-label">手机号码：</div>
                            <input class="form-control" type="number" name="phone" maxlength="24"
                                placeholder="请填写您的手机号码">
                        </div>
                        <input type="hidden" name="type" value="1">
                        <div class="form-item">
                            <div class="form-label">中午就餐:</div>
                            <select name="lunch">
                                <option value="">请选择是否需要中午就餐</option>
                                <option value="1">是</option>
                                <option value="0">否</option>
                            </select>
                        </div>

                        <div class="form-item">
                            <div class="form-label" style="width:100%;">建议（非必填项）:</div>
                        </div>
                        <div class="form-item" style="padding:0">
                            <textarea class="u-textarea" name="feedback" id=""></textarea>
                        </div>
                        <div class="submit-btn-box">
                            <button type="submit" id="js-submit-btn">提交</button>
                        </div>
                    </form>
                </div>
                <div class="m-success-page" id="js-sucess-page" style="display: none;">
                    <div class="title">报名成功</div>
                    <img src="/yidao/Home/Static/images/qrcode.jpg" class="icon" alt="">
                    <div class="desc">关注云医岛公众号，了解更多会议资讯</div>
                    <!-- <div class="close-btn" onclick="window.close()">关闭页面</div> -->
                </div>
            </div>
            <div class="footer">云医岛提供技术支持</div>
        </div>
    </div>
</body>

</html>
<script src="/yidao/Home/Static/js/flexible.js"></script>
<script src="/yidao/Home/Static/js/jquery-1.8.3.min.js"></script>
<script src="/yidao/Home/Static/js/jquery.validate.min.js"></script>
<script>
    var isSubmit = false
    function showErrorMsg(msg) {
        $('#js-error-box').html(msg).stop(true, true).slideDown(300).delay(4000).slideUp(400);
    }
    $(function () {
        $.validator.setDefaults({
            onfocusout: false,
            onclick: false,
            onkeyup: false,
            errorElement: "div",
            // errorPlacement: function (error, element) {
            //     // error.appendTo(element.closest('.form-group').find('.js-tips'));
            //     $("#js-error-box").html(error).addClass('show')
            //     setTimeout(function(){
            //         console.log("s")
            //         $("#js-error-box").removeClass('show')
            //     },300)
            // },
            showErrors: function (errorMap, errorList) {
                if (errorList.length) {
                    showErrorMsg(errorList[0].message)
                }
            },
            submitHandler: function (form) {
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
                            $("#js-form-box").css('display', 'none')
                            $("#js-sucess-page").css("display", "block")
                        } else {
                            window.alert(res.msg);

                        }
                    },
                    beforeSend: function () {
                        if (isSubmit) return false
                        isSubmit = true
                        $("#js-submit-btn").text("提交中……")
                    },
                    complete: function () {
                        isSubmit = false
                        $("#js-submit-btn").text("提交")
                    }
                }
                // console.log(ajaxOpt)
                $.ajax(ajaxOpt)
                return false;
            }
        });

        $.validator.addMethod('mobile', function (value, element, params) {
            var mobileReg = /^[1][0-9]{10}$/
            if (params === true) {
                if (mobileReg.test(value)) {
                    return true
                } else {
                    return false
                }
            } else {
                return true
            }
        }, '手机号格式不正确')


        //
        /****表单验证***/

        $("#js-feedback-form").validate({
            rules: {
                name: 'required',
                company: 'required',
                phone: { required: true, mobile: true },
                position: { required: true },
                title: { required: true },
                lunch: { required: true },
                type: { required: true }
            },
            messages: {
                name: '请填写您的姓名',
                company: '请填写您的单位名称',
                phone: { required: '请填写您的手机号码' },
                position: { required: '请填写您的职务' },
                title: { required: '请填写您的职称' },
                lunch: { required: '请选择是否需要午餐' },
                type: { required: '请选择您的参会形式' }
            }
        });


    })
</script>