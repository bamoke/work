<?php 
/*
 * @Author: joy.wangxiangyin 
 * @Date: 2018-10-11 22:16:59 
 * @Last Modified by: joy.wangxiangyin
 * @Last Modified time: 2018-10-11 22:48:12
 */
namespace Admin\Controller;
use Admin\Common\Auth;
class TalentPoolController extends Auth {
  protected $talentType = array(
    "1" =>"产业类",
    "2" =>"农技类",
    "3" =>"党政类",
    "4" =>"社工类",
    "5" =>"教育类",
    "6" =>"卫生类",
  );

  protected $verifyName = array(
    "1" =>array(
      "name"  =>"待平台审核",
      "style" =>"default"
    ),
    "2" =>array(
      "name"  =>"平台审核未通过",
      "style" =>"error"
    ),
    "3" =>array(
      "name"  =>"平台审核通过",
      "style" =>"info"
    ),
    "4" =>array(
      "name"  =>"待政府审核",
      "style" =>"info"
    ),
    "5" =>array(
      "name"  =>"政府审核未通过",
      "style" =>"error"
    ),
    "6" =>array(
      "name"  =>"审核通过",
      "style" =>"success"
    )
  );


 


    /***
   * 人才卡列表
   */
  public function vlist(){
    $page = I("get.page/d",1);
    $pageSize = 15;
    $mainModel = M("TalentPool");
    $where = array();
    if(!empty($_GET['keywords'])){
      $where['realname'] = array("like","%".$_GET["keywords"]."%");
    }
    $list = $mainModel

    ->where($where)
    ->page($page,$pageSize)
    ->order("id desc")
    ->fetchSql(false)
    ->select();
    $total = $mainModel->where($where)->count();

    if(count($list)) {
      foreach($list as $key=>$val){
        $list[$key]["typename"] = $this->talentType[$val["type"]];
      }
    }


    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "list"  =>$list,
          "pageInfo"  =>array(
            "total"   =>intval($total),
            "page"    =>$page,
            "pageSize"  =>$pageSize
          )
      )
    );
    $this->ajaxReturn($backData);
  }


  /**
   * 
   */
  public function getTypeList(){
    $talentType = array(
     array(
       "key"  =>5,
       "name"=>"教育类"
     ),
     array(
       "key"  =>6,
       "name"=>"卫生类"
     )
    );
    $backData = array(
      'code'      => 200,
      "msg"       => "ok",
      'data'      => array(
          "typeCate"  =>$talentType
      )
    );
    $this->ajaxReturn($backData);


  }


  /**
   * 附件上传
   */
  public function fileupload(){
    $upload_conf=array(
      'maxSize' => 3145728,
      'rootPath' => ROOT.'/Uploads/',
      'savePath' => 'thumb/',
      'saveName' => md5(time().I("session.uid")),
      'exts' => array('jpg', 'gif', 'png', 'jpeg'),
      'autoSub' => false,
      'subName' => date("Ym",time())
    );
    //图片上传
    if($_FILES['thumb']['tmp_name']){
        //图片处理
        $upload = new \Think\Upload($upload_conf);
        $uploadResult = $upload->uploadOne($_FILES['thumb']);
        if(!$uploadResult){
            $backData['status'] = 0;
            $backData['msg'] = $upload->getError();
            return $this->ajaxReturn($backData);
        }else {
            $model->thumb = $uploadResult['savename'];
            //删除旧图片
            if(isset($_POST['old_img']) && $_POST['old_img'] == ''){
                $info = $model->field('thumb')->where("id=$id")->find();
                unlink($upload_conf['rootPath'].$upload_conf['savePath'].$info['thumb']);
            }
        }

    }else {
        // 删除旧图片
        if(isset($_POST['old_img']) && $_POST['old_img'] == ''){
            $info = $model->field('thumb')->where("id=$id")->find();
            $model->thumb = '';
            @unlink($upload_conf['rootPath'].$upload_conf['savePath'].$info['thumb']);
        }
    }
  }

  // 数据保存
  public function save(){
    exit();
    //////////////
    if(!IS_POST){
      $backData = array(
        'code'      => 10001,
        "msg"       => "非法请求"    
      );
      $this->ajaxReturn($backData);
    }
    $mainModel = M("TalentPool");

    $postData = $this->requestData;
    $talentType= $postData['type'];
    $fileName = $postData['filename'];
    //文件读取
    $file = ROOT ."\Uploads\\files\\".$fileName;
    // var_dump($file);
    // exit();
    vendor("PHPExcel.PHPExcel");
    // Vendor('PHPExcel.PHPExcel.IOFactory');
    // $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
    $objPHPExcel = $objReader->load($file,$encode='utf-8');


    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow(); // 取得总行数
    $highestColumn = $sheet->getHighestColumn(); // 取得总列数
    $insertAllData = array();
    $existArr = array();
    for($i=3;$i<=$highestRow;$i++)
    {
        $data['realname']   = $objPHPExcel -> getActiveSheet() -> getCell("A".$i)->getValue();
        $data['paper_no'] = $objPHPExcel -> getActiveSheet() -> getCell("B".$i)->getValue();
        $data['type']  = $talentType;
        $data['card_no']    = '2020'.$talentType.'11'.$i;
        $data['end_date'] = '2020-11-02';

        $insertAllData[] = $data;
      }
    $result = $mainModel->fetchSql(false)->addAll($insertAllData);
    var_dump($result);
    exit();
    if($result !== false){
      // $info = $mainModel->where(array("id"=>$id))->find();
      $backData = array(
        'code'      => 200,
        "msg"       => "ok",
        "info"      => "success"
      );
    }else {
      $backData = array(
        'code'      => 13002,
        "msg"       => "服务器错误",        
      );     
    }
    $this->ajaxReturn($backData);
  }









  //==================//
}