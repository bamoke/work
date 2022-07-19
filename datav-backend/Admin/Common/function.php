<?php
function format_gdp_timestamp($year,$month){
    $modNum = $month % 3;

    $timestamp = strtotime("-" . $modNum . " months", strtotime($year . "-" . $month));
    return $timestamp;
}

function ajaxReturn($data){
    echo json_encode($data);
    exit();
}

/**
 * 四上企业
 * 通过权限返回查询条件
 */
function get_accessauth_for_sishang($uid,$cate,$town) {
    $roleid = M("Users")->where(array('id'=>$uid))->getField("role_id");
    

    if($roleid == 1) {
        return '';
    }

    if($roleid == 6) {
        $backData = array(
            "code" => 11001,
            "msg"   =>"对不起,没有查看权限"
        );

        ajaxReturn($backData);
    }

    if($roleid == 10 && $town != '平沙') {
        $backData = array(
            "code" => 11001,
            "msg"   =>"对不起,没有查看权限"
        );

        ajaxReturn($backData);
    }

    if($roleid == 9 && $town != '南水') {
        $backData = array(
            "code" => 11001,
            "msg"   =>"对不起,没有查看权限"
        );

        
        ajaxReturn($backData);
    }

    if($roleid == 8 && $town != '红旗') {
        $backData = array(
            "code" => 11001,
            "msg"   =>"对不起,没有查看权限"
        );

        ajaxReturn($backData);
    }

    if($roleid == 7 && $town != '三灶') {
        $backData = array(
            "code" => 11001,
            "msg"   =>"对不起,没有查看权限"
        );

        ajaxReturn($backData);
    }

    if($roleid == 5 && $cate !='建筑业' && $cate != '房地产') {

        $backData = array(
            "code" => 11001,
            "msg"   =>"对不起,没有查看权限"
        );

        ajaxReturn($backData);
    }


    if($roleid == 4 && $cate !='批发业' && $cate != '零售业' && $cate != '住宿业' && $cate != '餐饮业' && $cate != '服务业') {
        $backData = array(
            "code" => 11001,
            "msg"   =>"对不起,没有查看权限"
        );

        ajaxReturn($backData);
    }

    if($roleid == 3) {
        $backData = array(
            "code" => 11001,
            "msg"   =>"对不起,没有查看权限"
        );

        ajaxReturn($backData);
    }

    if($roleid == 2 && $cate != '工业') {
        $backData = array(
            "code" => 11001,
            "msg"   =>"对不起,没有查看权限"
        );

        ajaxReturn($backData);
    }

}

/**
 * 
 */
function get_accessauth_for_touzi($uid,$cate,$town) {
    $roleid = M("Users")->where(array('id'=>$uid))->getField("role_id");


    if($roleid == 1) {
        return '';
    }

    if($roleid == 6) {
        $backData = array(
            "code" => 11001,
            "msg"   =>"对不起,没有查看权限"
        );

        ajaxReturn($backData);
    }

    if($roleid == 10 && $town != '平沙') {
        $backData = array(
            "code" => 11001,
            "msg"   =>"对不起,没有查看权限"
        );

        ajaxReturn($backData);
    }

    if($roleid == 9 && $town != '南水') {
        $backData = array(
            "code" => 11001,
            "msg"   =>"对不起,没有查看权限"
        );

        ajaxReturn($backData);
    }

    if($roleid == 8 && $town != '红旗') {
        $backData = array(
            "code" => 11001,
            "msg"   =>"对不起,没有查看权限"
        );

        ajaxReturn($backData);
    }

    if($roleid == 7 && $town != '三灶') {
        $backData = array(
            "code" => 11001,
            "msg"   =>"对不起,没有查看权限"
        );

        ajaxReturn($backData);
    }

    if($roleid == 5 && $cate !='基础设施') {
        $backData = array(
            "code" => 11001,
            "msg"   =>"对不起,没有查看权限"
        );

        ajaxReturn($backData);
    }

    if($roleid == 4) {
        $backData = array(
            "code" => 11001,
            "msg"   =>"对不起,没有查看权限"
        );

        ajaxReturn($backData);
    }


    if($roleid == 3) {
        //  全部投资企业
    }

    if($roleid == 2 && $cate != '工业') {
        $backData = array(
            "code" => 11001,
            "msg"   =>"对不起,没有查看权限"
        );

        ajaxReturn($backData);
    }

}

/**
 * 
 */
function get_default_cate_for_touzi($uid){
    $roleid = M("Users")->where(array('id'=>$uid))->getField("role_id");

    $cate = "全部类别";

    if($roleid == 5) {
        $cate = "基础设施";
    }

    if($roleid == 2) {
        $cate = "工业";
    }

    return $cate;
}

function get_default_town_for_touzi($uid){
    $roleid = M("Users")->where(array('id'=>$uid))->getField("role_id");

    $town = "所有街镇";

    if($roleid == 10) {
        $town = "平沙";
    }

    if($roleid == 9) {
        $town = "南水";
    }

    if($roleid == 8) {
        $town = "红旗";
    }

    if($roleid == 7) {
        $town = "三灶";
    }


    return $town;
}


/**
 * 支柱产业企业
 * 通过权限返回查询条件
 */
function get_accessauth_for_zhizhu($uid) {
    $roleid = M("Users")->where(array('id'=>$uid))->getField("role_id");
    

    if($roleid == 1 || $roleid == 2) {
        return '';
    }else {
        $backData = array(
            "code" => 11001,
            "msg"   =>"对不起,没有查看权限"
        );

        ajaxReturn($backData);
    }

}

/**
 * 重点企业经营
 * 通过权限返回查询条件
 */
function get_accessauth_for_zhongdian($uid,$cate) {
    $roleid = M("Users")->where(array('id'=>$uid))->getField("role_id");
    

    if($roleid == 1) {
        return '';
    }

    if($roleid == 6 || $roleid == 7 || $roleid == 8 || $roleid == 9 || $roleid == 10) {
        $backData = array(
            "code" => 11001,
            "msg"   =>"对不起,没有查看权限"
        );

        ajaxReturn($backData);
    }




    if($roleid == 5 && $cate !='建筑业' && $cate != '房地产') {

        $backData = array(
            "code" => 11001,
            "msg"   =>"对不起,只看查看建筑业、房地产行业的数据",
            "data"  =>array(
                "roleid"=>$roleid,
                "cate"=>$cate
            )
        );

        ajaxReturn($backData);
    }


    if($roleid == 4 && $cate !='批发' && $cate != '零售' && $cate != '住宿' && $cate != '餐饮' && $cate != '服务') {
        $backData = array(
            "code" => 11001,
            "msg"   =>"对不起,只可查看批发、零售、住宿、餐饮、服务行业的数据"
        );

        ajaxReturn($backData);
    }

    if($roleid == 3) {
        $backData = array(
            "code" => 11001,
            "msg"   =>"对不起,没有查看权限3"
        );

        ajaxReturn($backData);
    }

    if($roleid == 2 && $cate != '工业') {
        $backData = array(
            "code" => 11001,
            "msg"   =>"对不起,只可查看工业企业数据"
        );

        ajaxReturn($backData);
    }

}

function get_default_cate_for_zhongdian($uid){
    $roleid = M("Users")->where(array('id'=>$uid))->getField("role_id");

    $cate = "工业";

    if($roleid == 4) {
        $cate = "批发业";
    }

    if($roleid == 5) {
        $cate = "建筑业";
    }

    return $cate;
}
