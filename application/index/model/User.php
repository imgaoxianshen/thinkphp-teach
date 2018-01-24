<?php
namespace app\index\model;

use think\Model;
use traits\model\SoftDelete;
class User extends Model
{
	use SoftDelete;

	protected $deleteTime = "delete_time";
	//自动完成功能	auto = instrt+update
	protected $auto = [
		'delete_time'=>NULL,
		'is_delete'=>1,
	];
	//自动添加
	protected $insert = [
		'login_time'=>NULL,
		'login_count'=>0,
	];
	//自动更新
	protected $update = [];

	//自动写入时间戳---如果设置为字符串，表示时间字段的类型
	protected $autoWriteTimestamp = true;

	protected $createTime = 'create_time';

	protected $updateTime = 'update_time';

	protected $dateFormat = 'Y-m-d';

	public function setPasswordAttr($value)
	{
		return md5($value);
	}

	public function getRoleAttr($value)
	{
		$role=[
			0=>'管理员',
			1=>'超级管理员',
		];
		return $role[$value];
	}

	public function getStatusAttr($value)
	{
		$status=[
			0=>"已停用",
			1=>"已启用"
		];
		return $status[$value];
	}

	public function getLoginTimeAttr($value)
	{
		return date('Y-m-d H:i:s',$value);
	}
}