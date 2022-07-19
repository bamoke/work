<?php
/**
 * Created by PhpStorm.
 * User: wetz1
 * Date: 2017/6/9
 * Time: 0:10
 */

namespace Web\Controller;
use Web\Common\Controller\BaseController;
class SchoolController extends BaseController
{
    public function index(){
        layout(false);

        $this->display('Main/school');
    }
}