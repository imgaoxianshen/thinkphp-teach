<?php
namespace app\index\controller;
use app\index\controller\Base;
class Index extends Base
{
    public function index()
    {
    	$this->isLogin();
    	$this->view->assign(array('title'=>'首页'));
        return $this->view->fetch();
    }
}
