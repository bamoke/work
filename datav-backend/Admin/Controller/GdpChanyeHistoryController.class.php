<?php
namespace Admin\Controller;

use Admin\Common\AuthController;

class GdpChanyeHistoryController extends AuthController
{
    protected $modelName = "GdpChanyeHistory";


    public function upload()
    {

    }

    public function get_data()
    {

        $startYear = idate("Y",strtotime('-10 year',date_timestamp_get($this->curDateObj)));
        $where = array(
            "year"=>array('egt',$startYear)
        );
        $model = M("GdpChanyeHistory");
        $result = $model
        ->field("year,one_proportion,two_proportion,three_proportion")
        ->where($where)
        ->limit(10)
        ->order("year asc")
        ->select();

        $list =array(
            ["product",'第一产业比重','第二产业比重','第三产业比重']
        );

        foreach($result as $key=>$val){
            $list[] = [$val['year'],$val['one_proportion'],$val['two_proportion'],$val['three_proportion']];
        }

        $backData = array(
            "code" => 200,
            "data" => array(
                "list"  =>$list
            ),
        );

        $this->ajaxReturn($backData);
    }

    /**
     * 行业子类数据
     */
    public function get_child()
    {
        $modelMap = array(
            "农林牧渔业" => 'GdpNongye',
            "批发和零售业" => 'GdpPflszscy',
            "住宿和餐饮业" => 'GdpPflszscy',
            "交通运输、仓储和邮政业" => "GdpServiceHangye",
            "房地产业" => "GdpRealEstate",
            "营利性服务业" => "GdpServiceHangye",
            "非营利性服务业" => "GdpServiceHangye",
        );
        $cate = I("get.cate");
        if (!$cate) {
            $backData = array(
                "code" => 130001,
                "errmsg" => "参数错误",
            );
            $this->ajaxReturn($backData);
        }

        if(!\in_array($cate,array_keys($modelMap))){
            $backData = array(
                "code" => 130001,
                "errmsg" => "数据更新中",
            );
            $this->ajaxReturn($backData);
        }

        // 分发到不同模型
        $timestamp = $this->format_date();
        switch ($cate) {
            case "农林牧渔业":
                $where = array(
                    "year" => date("Y", $timestamp),
                    "month" => date("m", $timestamp),
                );
                $model = D("GdpNongye");
                break;
            case "批发和零售业":
                $where = array(
                    "year" => $this->curYear,
                    "month" => $this->curMonth,
                    "parent_name" => "批发零售业",
                );
                $model = D("GdpPflszscy");
                break;
            case "住宿和餐饮业":
                $where = array(
                    "year" => $this->curYear,
                    "month" => $this->curMonth,
                    "parent_name" => "住宿餐饮业",
                );
                $model = D("GdpPflszscy");
                break;
            case "交通运输、仓储和邮政业":
            case "营利性服务业":
            case "非营利性服务业":
                $where = array(
                    "year" => $this->curYear,
                    "month" => $this->curMonth,
                    "parent_name" => $cate,
                );
                $model = D("GdpServiceHangye");
                break;
            case "房地产业":
                $where = array(
                    "year" => $this->curYear,
                    "month" => $this->curMonth,
                    "parent_name" => "一级",
                );
                $model = D("GdpRealEstate");
                break;

        }
        $childData = $model->getList($where);

        $backData = array(
            "code"  =>200,
            "msg"   =>"success",
            "data"  =>array(
                "title" =>$cate,
                "list"      =>$childData["list"],
                "measure"      =>$childData["measure"],
            )
        );
        $this->ajaxReturn($backData);

    }

}
