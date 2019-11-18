<?php
/**
 * Created by PhpStorm.
 * User: wetz1
 * Date: 2017/6/9
 * Time: 0:10
 */

namespace Web\Controller;
use Web\Common\Controller\BaseController;
class SingleController extends BaseController
{
    public function index($id){

        $data = M("Single")->where('cid='.$id)->find();
        $outData['banner'] = $banner['img'];
        $outData['info'] = $data;
        $this->assign('outData',$outData);
        $this->display('Main/page');
    }
}