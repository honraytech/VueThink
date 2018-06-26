<?php

namespace app\admin\validate;
use think\Validate;
/**
* 设置模型
*/
class AdminUser extends Validate{

	protected $rule = array(
		'username'  		=> 'require|length:6,12|unique:user',
		'password'      	=> 'require',
		'realname'      	=> 'require',
	);
	protected $message = array(
		'username.require'    	=> '用户名必须填写',
		'username.length'    	=> '用户名长度在6到12位',
		'username.unique'    	=> '用户名已存在',
		'password.require'    	=> '密码必须填写',
		'realname.require'    	=> '真实姓名必须填写',
	);
}