<?php
namespace app\index\controller;

use app\index\controller\Base;
use app\index\model\Grade as GradeModel;
use app\index\model\Teacher;
use think\Request;
class Grade extends Base
{
	public function grade_list()
	{
		$this->view->assign([
			'title'=>"课程列表",
			'keywprd'=>"教学管理系统",
			'desc'=>'哦哦',
		]);
		$this->view->count = GradeModel::count();
		$grade_list = GradeModel::all();
		foreach($grade_list as $l){
			$data =  $l;
			// $data['teacher'] = isset($l->teacher->name)?$l->teacher->name:'<span>暂无</span>';
			$list[] = $data;
		}
		$this->view->list = $list;
		return $this->view->fetch('grade_list');
	}

	public function setStatus(Request $request)
	{
		$status= 1;

		$grade_id = $request->param('id');
		$result = GradeModel::get($grade_id);
		if($result->getData('status')==1){
			$res = GradeModel::update(['status'=>0],['id'=>$grade_id]);
		}else{
			$res = GradeModel::update(['status'=>1],['id'=>$grade_id]);
		}
		if(!$res){
			$status=0;
		}
		return ['status'=>$status,'id'=>$grade_id];
	}


	public function gradeEdit(Request $request){
		$grade_id = $request->param('id');
		$result = GradeModel::get($grade_id);

		$this->view->assign('grade_info',$result);
		return $this->view->fetch('grade_edit');
	}


}