<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>经济简况</title>
    <script src="/datav-backend/Admin/Assets/Js/jquery-1.10.1.min.js"></script>
</head>
<body>
    <div>
        <table>
            <tr>
                <td>年份</td>
                <td>
                    <input type="text" name="year" id="">
                </td>
            </tr>
            <tr>
                <td>月份</td>
                <td>
                    <input type="text" name="month" id="">
                </td>
            </tr>
            <tr>
                <td>概述：</td>
                <td>
                    <textarea name="preface" id="" cols="30" rows="10"></textarea>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>