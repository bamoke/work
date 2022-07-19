<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cmn-Hans">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=0;">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>麻力管家设备统计-用户登录</title>
    <link rel="stylesheet" href="https://unpkg.com/vant@2.12/lib/index.css" />
    <!-- <link href="/mazuizhushoudevice/Home/Assets/style/default.css?v=<?php echo ($debugTime); ?>" rel="stylesheet"> -->
    <script src="https://unpkg.com/vue@2.6/dist/vue.min.js"></script>
    <script src="https://unpkg.com/vant@2.12/lib/vant.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <style>
        .login-header {
            font-size: 18px;
            font-weight: 300;
            text-align: center;
            padding: 30px 0;
            font-weight: bold;
        }

        .form-con {
            padding: 10px 0 0;
        }

        .login-tip {
            font-size: 10px;
            text-align: center;
            color: #c3c3c3;
        }
    </style>
</head>

<body>

    <body>
        <div id="app">
            <div class="login-header">麻力管家设备登记-用户登录</div>
            <van-form @submit="handleSubmit">
                <van-field v-model="form.username" name="username" label="用户名" placeholder="用户名"
                    :rules="[{ required: true, message: '请填写用户名' }]"></van-field>
                <van-field v-model="form.password" type="password" name="password" label="密码" placeholder="密码"
                    :rules="[{ required: true, message: '请填写密码' }]"></van-field>
                <div style="margin: 16px;">
                    <van-button round block type="info" native-type="submit">提交</van-button>
                </div>
            </van-form>
        </div>
    </body>
</body>

</html>
<script>
    const myAxios = axios.create({
        baseURL: '',
        timeout: 1000,
        headers: { 'Authorization': 'Bearer ' + sessionStorage.setItem('token') }
    });

    const app = new Vue({
        el: "#app",
        data: {
            form: {
                username: '',
                password: '',
            },
        },
        methods: {

        },
        mounted() {
            axios.get('/backend/device/statistic/config')
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
    })





</script>