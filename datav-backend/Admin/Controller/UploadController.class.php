<?php
namespace Admin\Controller;

use Think\Controller;

class UploadController extends Controller
{
    protected $contrastArr = array(
        "total" => "主要经济指标总表",
        "industry_zcz" => "规模以上工业总产值及销售产值",
        "industry_zjz" => "规模以上工业增加值",
        "industry_hangye_zcz" => "规模以上工业分行业工业总产值",
        "industry_hangye_zjz" => "规模以上工业分行业工业增加值",
        "industry_benefit" => "规模以上工业经济效益",
        "industry_pillar_zcz" => "重点支柱产业工业总产值",
        "industry_pillar_zjz" => "重点支柱产业工业增加值",
        "industry_xdmy_zcz" => "现代产业和规上民营工业企业总产值",
        "industry_xdmy_zjz" => "现代产业和规上民营工业企业增加值",
        "economy_county" => "各区主要经济指标",
        "economy_town" => "各镇主要经济指标",
        "economy_domestic" => "金湾区与国内部分区域主要指标对比表",
        "whole_country"=>"国家、省、市主要经济指标",
        "electric" => "全社会用电量情况",
        "timeline_year" => "主要经济指标时间系列（年）",
        "timeline_month" => "主要经济指标时间系列（月）",
        "timeline_transport" => "机场港口时间系列（月）",
        "nengyuan_use_swl" => "能源品种实物量消费情况",
        "nengyuan_use_bzl" => "能源品种标准量消费情况",
        "gdp_hangye" => "金湾区地区生产总值分行业情况",
        "gdp_nongye" => "金湾区农业总产值完成情况表",
        "gdp_real_estate" => "房地产开发与经营",
        "gdp_pflszscy" => "限额以上批发零售业、住宿餐饮业",
        "gdp_service_hangye" => "规模以上服务业分行业营业收入",
        "gdp_chanye_history" => "金湾区历年三次产业比重",
        "com_sishang" => "金湾区（开发区）四上企业情况表",
        "com_pillar" => "重点支柱产业企业情况表",
        "com_key" => "金湾区（珠海经济技术开发区）重点企业经营情况",
        "gdp_nenghao"   =>"GDP能耗及规上工业能源消费情况",
        "com_investment"=>"金湾区（开发区）固定资产项目情况",
        "investment_fixed"=>"固定资产投资完成情况",
        "finance"=>"一般公共预算收入和支出情况",
        "harbour_goods"=>"高栏港港口吞吐量分类统计情况",
        

    );

    public function show()
    {
        session("uid",2);//临时UID
        $this->display();
    }

    /**
     * 
     */
    public function upload()
    {
        if (IS_POST) {
            $uploadConf = array(
                'maxSize' => 3145728,
                'rootPath' => ROOT_DIR . '/Uploads/',
                'savePath' => 'temp/',
                'exts' => array('xlsx'),
                'autoSub' => false,
                'subName' => date("Ym", time()),
            );
            $upload = new \Think\Upload($uploadConf);
            $uploadResult = $upload->uploadOne($_FILES["file"]);
            $fileFullPath = $uploadConf['rootPath'].  $uploadConf['savePath']. $uploadResult["savename"];
            $sheetTitle = explode(".",$uploadResult["name"])[0];
            $tableName = array();

            /**
             * 筛选出对应的数据表
             */
            foreach($this->contrastArr as $key=>$val){
                if($val == $sheetTitle) {
                    $tableName = explode("_",$key);
                    break;
                }
            }


            /**
             * 数据表名称转换
             */

            $tableRealName = '';
            foreach($tableName as $v) {
                $tableRealName .= ucfirst($v);
            }

            /**
             * 调用对应Model处理
             */
            $curModel = D($tableRealName);

             $insertResult = $curModel->import_data($fileFullPath,$sheetTitle);
            $this->ajaxReturn($insertResult);


        }

    }

    public function my_test(){
 
    }

}
