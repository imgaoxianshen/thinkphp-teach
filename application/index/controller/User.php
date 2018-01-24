<?php
namespace app\index\controller;
use app\index\controller\Base;
use think\Request;
use app\index\model\User as UserModel;
use think\Session;
class User extends Base
{
	//登陆
	public function login()
	{
		$this->alreadyLogin();
		return $this->view->fetch();
	}
	//验证登陆
	public function checklogin(Request $request)
	{
		$status=0;
		$result='';
		$data = $request->param();

		$rule = [
			'name|用户名'=>"require",
			'password|密码'=>"require",
		];

		//自定义验证失败的提示信息
		$msg = [
			'name'=>['require'=>"用户名不能为空，请查看"],
			'password'=>['require'=>"密码不能为空，请查看"],
		];

		$result = $this->validate($data,$rule,$msg);
		
		//验证通过
		if($result===true){
			//构造查询条件
			$map = [
				'name'=>$data['name'],
				'password'=>md5($data['password']),
			];

			$user = UserModel::get($map);

			if($user ==null){
				$result="没有找到该用户";
			}else{
				$status=1;
				$result="验证通过，点击确定进入";
				Session::set('user_id',$user->id);
				Session::set("user_info",$user->getData());

			}
		}


		return ['status'=>$status,'message'=>$result,'data'=>$data];
	}
	//退出登陆
	public function logout()
	{
		//注销session
		Session::delete('user_id');
		Session::delete('user_info');
		$this->success("注销登陆，正在返回",'user/login');
	}

	//管理员列表

	public function adminList()
	{

		$this->view->assign([
			'title'=>"管理员列表",
			'keywprd'=>"教学管理系统",
			'desc'=>'哦哦',
		]);
		$this->view->count = UserModel::count();

		$userName = Session::get("user_info.name");

		if($userName=="admin"){
			// $list = UserModel::all();
			$list = UserModel::paginate(5);
		}else{
			$list = UserModel::all(['name'=>$usernName]);
		}
		$this->view->assign("list",$list);

		return $this->view->fetch("admin_list");
	}

	public function setStatus(Request $request)
	{
		$user_id = $request->param('id');
		$result = UserModel::get($user_id);
		if($result->getData('status')==1){
			$res = UserModel::update(['status'=>0,'id'=>$user_id]);
		}else{
			$res = UserModel::update(['status'=>1,'id'=>$user_id]);
		}


		if($res){
			return ['status'=>1,'message'=>"修改成功"];
		}else{
			return ['status'=>-1,'message'=>"修改失败"];
		}
	}


	public function adminEdit(Request $request)
	{
		$user_id = $request->param('id');
		$result = UserModel::get($user_id);
		$this->view->assign([
			'user_info'=>$result->getData(),
		]);

		return $this->fetch('admin_edit');

	}


	public function adminAdd()
	{
		return $this->view->fetch("admin_edit");
	}


	public function unDelete()
	{
		UserModel::update(['delete_time'=>NULL],['is_delete'=>1]);
	}


	public function checkUserName(Request $request)
	{
		$userName= trim($request->param("name"));
		$status=1;
		$message="用户名可用";
		if(UserModel::get(['name'=>$userName])){
			$status=0;
			$message = "用户名重复，请重新输入";
		}

		return ['status'=>$status,"message"=>$message];
	}

	public function checkUserEmail(Request $request)
	{
		$userEmail = trim($request->param("email"));
		$status=1;
		$message="邮箱可用";
		if(UserModel::get(['email'=>$userEmail])){
			$status=0;
			$message="邮箱重复，请重新输入";
		}
		return ['status'=>$status,'message'=>$message];
	}

	public function addUser(Request $request)
	{
	
		$data = $request->param();

		$status=1;
		$message="添加成功";

		$rule=[
			'name'=>"require|min:3|max:10",
			'password'=>"require|min:3|max:10",
			'email'=>"require|email",
		];

		$result = $this->validate($data,$rule);
			
		if($result===true){
			if(empty($data['id'])){
				unset($data['id']);
				$user = UserModel::create($data);

			}else{
				$user = UserModel::update($data);				
			}
			if($user==null){
				$status=0;
				$message="添加失败";
			}

			return ['status'=>$status,'message'=>$message];
		}else{
			$status=0;				
			return ['status'=>$status,'message'=>$result];
		}

	}


	public function deleteUser(Request $request)
	{
		$user_id = $request->param('id');
		UserModel::update(['is_delete'=>1],['id'=>$user_id]);
		UserModel::destroy($user_id);
	}

	

}