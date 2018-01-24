<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
class Base extends Controller
{
	protected function _initialize()
	{
		parent::_initialize();//继承父类的初始化操作
		define('USER_ID',Session::get("user_id"));
	}

	protected function isLogin()
	{
		if(empty(USER_ID)){
			$this->error("用户未登陆,无权访问",url('user/login'));
		}
	}
	protected function alreadyLogin()
	{
		if(!empty(USER_ID)){
			$this->error("用户已经登陆,请勿重复登陆",url('index/index'));
		}
	}
}