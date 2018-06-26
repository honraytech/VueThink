<?php

namespace app\admin\validate;
use think\Validate;
/**
* 设置模型
*/
class AdminRule extends Validate{

	protected $rule = array(
		'title' => 'require',
		'name'  => 'require',
		'level' => 'require'
	);
	protected $message = array(
		'title.require'    	=> '标题必须填写',
		'name.require'    	=> '规则定义必须填写',
		'level.require'    	=> '级别类型必须填写',
	);
}