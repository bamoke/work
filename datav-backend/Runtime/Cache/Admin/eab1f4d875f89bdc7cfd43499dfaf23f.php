<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>上传</title>
</head>
<body>
    <form action="<?php echo U('upload');?>" enctype="multipart/form-data" method="POST">
        <input type="file" name="file" id="">
        <button type="submit">提交</button>
    </form>
</body>
</html>