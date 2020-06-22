<?php
    function gmt_iso8601($time) {
        $dtStr = date("c", $time);
        $mydatetime = new DateTime($dtStr);
        $expiration = $mydatetime->format(DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration."Z";
    }

    /***
     * 未完
     */
    function iteration ($array,$pid=0, $level=1, $max=3){
        $newArr = array();
        if($level >= $max) {return array();}
        if(!is_array($array) || count($array) === 0 ) return array();
        foreach($array as $key=>$val){
          if($val["pid"] == $pid) {
            $children = iteration($array,$val['id'],$level+1);
            $parent = array(
              "id"      =>$val["id"],
              "pid"      =>$val["pid"],
              "title"   =>$val["name"],
              "price"   =>$val["price"],
              "sort"   =>$val["sort"],
              "expand"  =>true,
              "status"   =>$val["status"],
              "level"   =>$level,
              "children"   =>$children
            );
            array_push($newArr,$parent);
          }
        }
        return $newArr;
    }
 ?>