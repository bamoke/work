<?php
namespace Admin\Controller;

use Admin\Common\AuthController;

class TimelineController extends AuthController
{

    public function upload()
    {

    }

    public function get_yeardata()
    {
        $startYear = date("Y", strtotime('-5 year', strtotime($this->curYear)));

        $cate = I("get.cate");
        $where = array(
            "year" => array(array('egt', $startYear), array('lt', $this->curYear)),
            "title" => $cate,
        );

        $modelName = "TimelineYear";
        $model = D($modelName);

        $list = $model->field("year,zs_gross,zs_rise,kfq_gross,kfq_rise")->where($where)->select();

        $columns = array(
            array(
                "title" => "年度",
                "key" => "year",
            ),
            array(
                "title" => "金湾直属",
                "key" => "zs_gross",
            ),
            array(
                "title" => "金湾直属同比",
                "key" => "zs_rise",
            ),
            array(
                "title" => "开发区",
                "key" => "kfq_gross",
            ),
            array(
                "title" => "开发区同比",
                "key" => "kfq_rise",
            ),
        );

        $backData = array(
            "code" => 200,
            "data" => array(
                "title" => "",
                "measure" => "",
                "columns" => $columns,
                "list" => $list,
            ),
        );

        $this->ajaxReturn($backData);
    }

    public function get_monthdata()
    {

        $cate = I("get.cate");
        if ($cate == "珠海机场" || $cate == 'transport') {
            return $this->get_transport_by_month();
        }

        $startMonth = date("Y-m", strtotime('-12 months', strtotime($this->curYear . '-' . $this->curMonth)));
        $where = array(
            "data_date" => array('egt', $startMonth),
            "title" => $cate,
        );

        $modelName = "TimelineMonth";
        $model = D($modelName);

        if ($cate == '地区生产总值') {
            // 季度数据再算
            $limit = 4;
        } else {
            $limit = 12;
        }
        $list = $model
            ->where($where)
            ->field("CONCAT(year,'-',month) as date,jw_gross as gross,jw_rise as rise")
            ->limit($limit)
            ->order("data_date asc")
            ->select();

        $columns = array(
            array(
                "title" => "年月",
                "key" => "date",
            ),
            array(
                "title" => "总量",
                "key" => "gross",
            ),
            array(
                "title" => "同比(%)",
                "key" => "rise",
            ),
        );

        $backData = array(
            "code" => 200,
            "data" => array(
                "title" => "",
                "measure" => "",
                "columns" => $columns,
                "list" => $list,
            ),
        );

        $this->ajaxReturn($backData);
    }

    /***
     * 机场港口月数据
     */
    public function get_transport_by_month()
    {
        $cate = I("get.cate");
        $startMonth = date("Y-m", strtotime('-12 months', strtotime($this->curYear . '-' . $this->curMonth)));
        $endMonth = date("Y-m", strtotime($this->curYear . '-' . $this->curMonth));
        $model = D("TimelineTransport");
        $where = array(
            "data_date" => array(array('egt', $startMonth), array('lt', $endMonth), "and"),
        );
        if ($cate == 'transport') {
            $where["title"] = array(array('eq', '珠海机场旅客吞吐量'), array('eq', '高栏港港口吞吐量'), 'or');
            $result = $model->getList($where);
        } else {
            $where["title"] = array("like", $cate . "%");
            $result = $model->getList($where);
        }
        $backData = array(
            "code" => 200,
            "data" => $result,
        );

        $this->ajaxReturn($backData);
    }

    /***
     * 机场港口年数据
     */
    public function get_transport_by_year()
    {
        $startYear = date("Y", strtotime('-5 year', strtotime($this->curYear)));

        $cate = I("get.cate");

        $where = array(
            "year" => array(array('egt', $startYear), array('lt', $this->curYear)),
        );

        $modelName = "TimelineYear";
        $model = D($modelName);

        if ($cate == '珠海机场') {
            $fields = "year,zs_gross as gross,zs_rise as rise";
            $jclkList = $model->field($fields)->where($where)->where(array("title" => "珠海机场旅客吞吐量"))->select();
            $jchyList = $model->field($fields)->where($where)->where(array("title" => "珠海机场货邮吞吐量"))->select();
            $backData = array(
                "code" => 200,
                "data" => array(
                    "jclk" => array(
                        "title" => "",
                        "measure" => "万人次",
                        "columns" => array(
                            array(
                                "title" => "年度",
                                "key" => "year",
                            ),
                            array(
                                "title" => "总量(万人次)",
                                "key" => "gross",
                            ),
                            array(
                                "title" => "同比(%)",
                                "key" => "rise",
                            ),
                        ),
                        "list" => $jclkList,
                    ),
                    "jchy" => array(
                        "title" => "",
                        "measure" => "万吨",
                        "columns" => array(
                            array(
                                "title" => "年度",
                                "key" => "year",
                            ),
                            array(
                                "title" => "总量(万吨)",
                                "key" => "gross",
                            ),
                            array(
                                "title" => "同比(%)",
                                "key" => "rise",
                            ),
                        ),
                        "list" => $jchyList,
                    ),
                ),
            );

            $this->ajaxReturn($backData);
        } elseif ($cate == '高栏港') {
            $fields = "year,kfq_gross as gross,kfq_rise as rise";
            $gkList = $model->field($fields)->where($where)->where(array("title" => "高栏港口吞吐量"))->fetchSql(false)->select();
            $jzxList = $model->field($fields)->where($where)->where(array("title" => "集装箱吞吐量"))->select();
            $backData = array(
                "code" => 200,
                "data" => array(
                    "gk" => array(
                        "title" => "",
                        "measure" => "万吨",
                        "columns" => array(
                            array(
                                "title" => "年度",
                                "key" => "year",
                            ),
                            array(
                                "title" => "总量(万吨)",
                                "key" => "gross",
                            ),
                            array(
                                "title" => "同比(%)",
                                "key" => "rise",
                            ),
                        ),
                        "list" => $gkList,
                    ),
                    "jzx" => array(
                        "title" => "",
                        "measure" => "万TEU",
                        "columns" => array(
                            array(
                                "title" => "年度",
                                "key" => "year",
                            ),
                            array(
                                "title" => "总量(万TEU)",
                                "key" => "gross",
                            ),
                            array(
                                "title" => "同比(%)",
                                "key" => "rise",
                            ),
                        ),
                        "list" => $jzxList,
                    ),
                ),
            );

            $this->ajaxReturn($backData);
        } elseif ($cate == 'transport') {
            $gkFields = "year,kfq_gross as gross,kfq_rise as rise";
            $gkList = $model->field($gkFields)->where($where)->where(array("title" => "高栏港口吞吐量"))->fetchSql(false)->select();
            $jzxList = $model->field($gkFields)->where($where)->where(array("title" => "集装箱吞吐量"))->select();
            $jcFields = "year,zs_gross as gross,zs_rise as rise";
            $jclkList = $model->field($jcFields)->where($where)->where(array("title" => "珠海机场旅客吞吐量"))->select();
            $jchyList = $model->field($jcFields)->where($where)->where(array("title" => "珠海机场货邮吞吐量"))->select();
            $backData = array(
                "code" => 200,
                "data" => array(
                    "gk" => array(
                        "title" => "",
                        "measure" => "万吨",
                        "columns" => array(
                            array(
                                "title" => "年度",
                                "key" => "year",
                            ),
                            array(
                                "title" => "总量(万吨)",
                                "key" => "gross",
                            ),
                            array(
                                "title" => "同比(%)",
                                "key" => "rise",
                            ),
                        ),
                        "list" => $gkList,
                    ),
                    "jzx" => array(
                        "title" => "",
                        "measure" => "万TEU",
                        "columns" => array(
                            array(
                                "title" => "年度",
                                "key" => "year",
                            ),
                            array(
                                "title" => "总量(万TEU)",
                                "key" => "gross",
                            ),
                            array(
                                "title" => "同比(%)",
                                "key" => "rise",
                            ),
                        ),
                        "list" => $jzxList,
                    ),
                    "jclk" => array(
                        "title" => "",
                        "measure" => "万人次",
                        "columns" => array(
                            array(
                                "title" => "年度",
                                "key" => "year",
                            ),
                            array(
                                "title" => "总量(万人次)",
                                "key" => "gross",
                            ),
                            array(
                                "title" => "同比(%)",
                                "key" => "rise",
                            ),
                        ),
                        "list" => $jclkList,
                    ),
                    "jchy" => array(
                        "title" => "",
                        "measure" => "万吨",
                        "columns" => array(
                            array(
                                "title" => "年度",
                                "key" => "year",
                            ),
                            array(
                                "title" => "总量(万吨)",
                                "key" => "gross",
                            ),
                            array(
                                "title" => "同比(%)",
                                "key" => "rise",
                            ),
                        ),
                        "list" => $jchyList,
                    ),
                ),
            );

            $this->ajaxReturn($backData);
        }

    }
}
