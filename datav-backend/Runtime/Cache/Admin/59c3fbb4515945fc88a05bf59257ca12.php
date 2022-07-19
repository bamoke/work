<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="/datav-backend/Admin/Assets/Js/jquery-1.10.1.min.js"></script>
</head>

<body>
    <h1><?php echo ($total); ?></h1>
    <table>
        <tr>
            <th>公司</th>
            <th>lng</th>
            <th>lat</th>
        </tr>
        <?php if(is_array($list)): foreach($list as $key=>$item): ?><tr class="row">
                <td><?php echo ($item["comname"]); ?></td>
                <?php if(empty($item["lng"])): ?><td><input class="js-zuobiao" type="text" value="" tyle="width:120px;"></td>
                    <?php else: ?>
                    <td><?php echo ($item["lng"]); ?></td><?php endif; ?>
                <?php if(empty($item["lat"])): ?><td>&nbsp;</td>
                    <?php else: ?>
                    <td><?php echo ($item["lat"]); ?></td><?php endif; ?>
                <?php if(empty($item["lat"])): ?><td><a href="javascript:" class="js-update-btn" data-comname="<?php echo ($item["comname"]); ?>" data-id="<?php echo ($item["id"]); ?>">更新</a></td><?php endif; ?>
            </tr><?php endforeach; endif; ?>

    </table>
</body>

</html>
<script>
    $(".js-update-btn").click(function(){
        var zuobiao = $(this).parents(".row").find(".js-zuobiao").val()
        var comname = $(this).data("comname")
        var id= $(this).data("id")
        $.ajax({
            url:'<?php echo U("do_update");?>',
            type:"POST",
            data:{comname,zuobiao,id},
            success:function(res){
                if(res.status){
                    window.location.reload();
                }else {
                    alert(res.msg)
                }
            }
        })
    })
</script>