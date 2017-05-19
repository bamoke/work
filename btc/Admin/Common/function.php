<?php
/**
 * Created by PhpStorm.
 * User: joy.wangxiangyin
 * Date: 2016/1/18
 * Time: 16:25
 */
function test(){
/*    if(function_exists(curl_init)){
        echo "ok";
    }else {
        echo "No";
    }*/
          $url='https://xlab.fenda.com:8203/php/PIO/update/plist.php?type=1&appid=23398&url=http://xlab.fenda.com:8200/version/IOS/23398/Beta/LenovoVB10.ipa&name=VB10&version=V2.3.6';
            $ch = curl_init();

            //设置选项，包括URL9-=
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            //执行并获取HTML文档内容
            $output = curl_exec($ch);

            //释放curl句柄
            curl_close($ch);

            //返回获得的数据
            echo $output."00";
}