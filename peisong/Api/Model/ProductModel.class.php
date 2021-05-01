<?php
namespace Api\Model;

class ProductModel extends \Think\Model
{
    /**
     * 关闭数据库连接
     */
    protected $autoCheckFields = false;

    /**
     * fetch products list
     * @cateid
     * @page
     * @pagesize
     */
    public function getList($cateName = '', $page = 1, $pageSize = 20)
    {

        $YB = new \Common\Common\YbApi();
        $filter = array(
            array(
                "expressionList" => array(
                    array(
                        "operator" => '$e',
                        "isAnd" => true,
                        "value" => "false",
                    ),
                ),
                "filterField" => "停用配件",
            ),
            array(
                "expressionList" => array(
                    array(
                        "operator" => '$ne',
                        "isAnd" => true,
                        "value" => true,
                    ),
                ),
                "filterField" => "App不显示",
            ),
        );
        if ($cateName != '') {
            $temp = array(
                "expressionList" => array(
                    array(
                        "operator" => '$e',
                        "isAnd" => true,
                        "value" => $cateName,
                    ),
                ),
                "filterField" => "配件类别",
            );
            array_push($filter, $temp);
        }

        $productCondition = array(
            "pageInfo" => array(
                "isUseRowIndex" => false,
                "pageCount" => 1,
                "pageIndex" => $page - 1,
                "pageSize" => $pageSize,
                "rowIndex" => 0,
            ),
            "filter" => $filter,
        );
        $ybResult = $YB->getMainData("配件管理", "post", $productCondition);
        if (!isset($ybResult->results)) {
            return false;
        }
        $list = array();
        // 字段转换
        if (count($ybResult->results)) {
            foreach ($ybResult->results as $key => $val) {
                $list[] = array(
                    "objectid" => $val->objectId,
                    "id" => $val->配件编号,
                    "title" => $val->配件名称,
                    "xgkh" => $val->限供客户,
                    "code" => $val->配件编号,
                    "cate" => $val->配件类别,
                    "price" => $val->建议零售价,
                    "unitname" => $val->申购单位,
                    "desc" => "申购单位：" . $val->申购单位,
                    "thumb" => $val->图片地址,
                    "buynum" => 0,
                    "original" => $val,
                );
            }
        }
        return array(
            "list" => $list,
            "pageInfo" => array(
                "page" => $page,
                "pageSize" => $pageSize,
                "total" => $ybResult->pageInfo->total,
            ),
        );
    }

    /**
     * 获取产品类别
     */
    public function getCate($YB = '')
    {
        if ($YB == '') {
            $YB = new \Common\Common\YbApi();
        }
        $cateCondition = array(
            "pageInfo" => array(
                "isUseRowIndex" => false,
                "pageCount" => 1,
                "pageIndex" => 0,
                "pageSize" => 50,
                "rowIndex" => 0,
            ),
            "filter" => array(
                array(
                    "expressionList" => array(
                        array(
                            "operator" => '$e',
                            "isAnd" => true,
                            "value" => "配件类别",
                        ),
                    ),
                    "filterField" => "自定义类型",
                ),
                array(
                    "expressionList" => array(
                        array(
                            "operator" => '$e',
                            "isAnd" => true,
                            "value" => "二级",
                        ),
                    ),
                    "filterField" => "类型层级",
                ),

 

            ),
        );
        $ybResult = $YB->getMainData("自定义类设置", "post", $cateCondition);
        $ybCate = $ybResult->results;
        $cateList = array(
            array(
                "id" => 0,
                "name" => "全部",
                "fullname" => '',
            ),
        );
        foreach ($ybCate as $key => $val) {
            if(!$val->App不显示) {
                $thumb = $val->图片地址 ? $val->图片地址 : "https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=2275939893,2764348501&fm=26&gp=0.jpg";
                $nameArr = explode(".", $val->类型名称);
                $cateList[] = array(
                    "id" => $val->objectId,
                    "name" => $nameArr[1],
                    "fullname" => $val->类型名称,
                    "thumb" => $thumb,
                    "origin" => $val,
                );
            }
        }
        return $cateList;
    }

    /**
     *
     */
    public function search($keywords)
    {
        $YB = new \Common\Common\YbApi();
        $page = I("get.page/d", 1);
        $pageSize = 20;
        $queryData = array(
            array(
                "param" => "查询内容",
                "value" => $keywords,
            ),
        );
        $ybResult = $YB->getByDataRule("配件管理", "000配件列表选择(查询内容)", $queryData, $page, $pageSize);
        if (!isset($ybResult->results)) {
            return false;
        }
        $list = array();
        // 字段转换
        if (count($ybResult->results)) {
            foreach ($ybResult->results as $key => $val) {
                $list[] = array(
                    "objectid" => $val->objectId,
                    "id" => $val->配件编号,
                    "title" => $val->配件名称,
                    "xgkh" => $val->限供客户,
                    "code" => $val->配件编号,
                    "cate" => $val->配件类别,
                    "price" => $val->建议零售价,
                    "unitname" => $val->申购单位,
                    "desc" => "申购单位：" . $val->申购单位,
                    "thumb" => $val->图片地址,
                    "buynum" => 0,
                    "original" => $val,
                );
            }
        }
        return array(
            "list" => $list,
            "pageInfo" => array(
                "page" => $page,
                "pageSize" => $pageSize,
                "total" => $ybResult->pageInfo->total,
            ),
        );
    }

}
