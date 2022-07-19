<?php

/**
 * 重点支柱产业企业情况
 */
namespace Admin\Controller;

use Admin\Common\AuthController;

class IndustryPillarController extends AuthController
{

    public function upload()
    {

    }

    public function get_data()
    {

        $cate = I("get.cate");

        ///////
        $modelName = "IndustryPillar" . \ucfirst($cate);
        $model = D($modelName);

        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
        );
        $result = $model->getList($where);

        $backData = array(
            "code" => 200,
            "data" => array_merge(array("title" => ""), $result),
        );

        $this->ajaxReturn($backData);

    }

    /////////////////////
    public function get_comlist()
    {
        $cate = I("get.cate");
        $modelName = "ComPillar";
        $model = D($modelName);

        ////////////
        get_accessauth_for_zhizhu($this->uid);
        // ///////

        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
        );
        $title = "重点支柱产业企业情况";

        /***search */
        $filterType = I("get.filter_type");
        $comname = I("get.keyword", '');
        $grossVal = I("get.gross_val", '');
        $grossType = I("get.gross_type", '');
        $riseVal = I("get.rise_val", '');
        $riseType = I("get.rise_type", '');

        if ($cate && $cate != '全部行业') {
            switch ($cate) {
                case '临空产业':
                    $where['industry'] = '临空装备';
                    break;
                case '临海产业':
                    $where['industry'] = '临海装备';
                    break;
                case '传统优势':
                    $where['industry'] = array('in', ['电子信息', '清洁能源', '钢铁制造', '电力生产', '智能家电', '其他']);
                    break;
                default:
                    $where['industry'] = $cate;
                    break;
            }
            $title .= "——" . $cate;
        }

        if ($comname) {
            $where['comname'] = array("like", '%' . $comname . '%');
        }

        if ($grossVal !== '' && $grossType) {
            $where[$filterType . '_gross'] = array($grossType, $grossVal);
        }

        if ($riseVal !== '' && $riseType) {
            $where[$filterType . '_rise'] = array($riseType, $riseVal);
        }

        $result = $model->getList($where);

        $backData = array(
            "code" => 200,
            "data" => array_merge(array("title" => $title . "(企业总计:" . $result['pageInfo']['total'] . ")"), $result),
        );

        $this->ajaxReturn($backData);
    }

    /**
     *
     */
    public function get_cate()
    {
        $type = I("get.type");
        $modelName = "IndustryPillar" . ucfirst($type);
        $model = D($modelName);

        $where = array(
            "year" => $this->curYear,
            "month" => $this->curMonth,
            "title" => array('neq', '合计'),
        );
        $cate = $model->getDataForCate($where);

        $backData = array(
            "code" => 200,
            "data" => array(
                "cate" => $cate,
            ),
        );

        $this->ajaxReturn($backData);
    }

}
