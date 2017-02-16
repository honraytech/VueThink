<?php

namespace app\common\validate;
use think\Validate;
/**
* 设置模型
*/
class Menu extends Validate{

	protected $rule = array(
		'title'      		=> 'require',
		'menu_type'      	=> 'require',
		// 'rule_name'      	=> 'require',
	);
	protected $message = array(
		'title.require'    		=> '标题必须填写',
		'menu_type.require'    	=> '菜单类型必须填写',
		// 'rule_name.require'    	=> '绑定权限标识必须填写',
	);
}