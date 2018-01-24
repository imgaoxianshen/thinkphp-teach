<?php
namespace app\index\model;

use think\Model;
use traits\model\SoftDelete;

class Grade extends Model
{
	use SoftDelete;

	protected $dataFormat = 'Y-m-d';

	protected $deleteTime = "delete_time";

	protected $autoWriteTimestamp = true;

	protected $createTime = 'create_time';
	protected $updateTime = 'update_time';

	protected $insert = ['status'=>1];

	public function getStatusAttr($value){
		$status=[
			1=>'已启用',
			0=>'禁用',
		];
		return $status[$value];
	}

	public function getIsDeleteAttr($value){
		$is_delete = [
			1=>'是',
			0=>'否',
		];

		return $is_delete[$value];
	}

	public function teacher()
	{
		return $this->hasOne('Teacher');
	}

	public function student()
	{
		return $this->hasMany('student');
	}
}
