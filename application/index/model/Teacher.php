<?php
namespace app\index\model;

use think\Model;

use traits\model\SoftDelete;

class Teacher extends Model
{
	use SoftDelete;

	protected $dateFormat = 'Y/m/d';

	protected $deleteTime = 'delete_time';

	protected $updateTime = 'update_time';

	protected $createTime = 'create_time';

	protected $type = [
		'hiredate'=>'timestamp',
	];

	protected $insert = ['status'=>1];


	//设置与grade反关联
	public function grade()
	{
		return $this->belongsTo('Grade');
	}

	public function getDegreeAttr($value)
	{
		$degree = [
			1=>'专科',
			2=>'本科',
			3=>'研究生',
		];	
		return $degree[$value];
	}
}