<?php

namespace app\admin\validate;
use think\Validate;
/**
* 设置模型
*/
class AdminStructure extends Validate{

	protected $rule = array(
		'name'      => 'require',
	);
	protected $message = array(
		'name.require'    		=> '标题必须填写',
	);
}