<?php
function getcomset($type){
    $newData =array();
    include $_SERVER["DOCUMENT_ROOT"]."/data/plus/com.cache.php";
    $curCate = $comdata[$type];
    foreach($curCate as $key=>$val) {
        $newData[$val] = $comclass_name[$val];

    }
    return $newData;

}

function getIndustry(){
    include $_SERVER["DOCUMENT_ROOT"]."/data/plus/industry.cache.php";
    return $industry_name;
}

function getJobCate($parentArr=array(),$level=1,$max=3){
    include_once $_SERVER["DOCUMENT_ROOT"]."/data/plus/job.cache.php";
    $cateTree = array();
    if(count($parentArr) == 0) {
        $parentArr = $job_index;
    }
    foreach ($job_type as $pk=>$pv) {
        $tempArr = array();
        if(in_array($pk,$parentArr)) {
            $childKeys = array_values($pv);
            //
            foreach ($job_type as $k=>$v) {
                if(in_array($k,$childKeys)) {
                    $tempArr[$k] = array(
                        "name"  =>$job_name[$k]
                    ) ;
                }
            }

            $cateTree[$pk] = array(
                "name"  =>$job_name[$pk],
                "child" =>$tempArr
            );
        }

    }
    return $cateTree;
    
}

/**
 * 按分类级别获取类别
 */
function getJobCateByLevel($level=1) {
    include_once $_SERVER["DOCUMENT_ROOT"]."/data/plus/job.cache.php";
    if($level ==1) {
        $curIdArr = $job_index;
    }elseif($level == 2) {
        $curIdArr = array();
        foreach($job_type as $k=>$v) {
            if(in_array($k,$job_index)) {
                $curIdArr = array_merge($curIdArr,$v);
            }
        }
    }else if($level == 3){
        
        $twoLevelId = array();
        foreach($job_type as $k=>$v) {
            if(in_array($k,$job_index)) {
                $curIdArr = array();
                $twoLevelId = array_merge($twoLevelId,$v);
                foreach($job_type as $key=>$val) {
                    if(in_array($key,$twoLevelId)) {
                        $curIdArr = array_merge($curIdArr,$val);
                    }
                }
            }
        }
    }
    $newCateArr = array();
    foreach($curIdArr as $key=>$val) {
        $newCateArr[] = array(
            "id"    =>$val,
            "name"   =>$job_name[$val]
        );
    }
    return $newCateArr;
}
/**
 * 获取职位类别名称
 */
 function getJobCateName() {
    include_once $_SERVER["DOCUMENT_ROOT"]."/data/plus/job.cache.php";
    return $job_name;
}

/**
 * 获取城市缓存
 * 
 */
function getCityNameCache(){
    include_once $_SERVER["DOCUMENT_ROOT"]."/data/plus/city.cache.php";
    return $city_name;
}

/**
 * 获取个人||简历标签缓存
 */
function getUserCache(){
    include_once $_SERVER["DOCUMENT_ROOT"]."/data/plus/user.cache.php";
    return $userclass_name;
}