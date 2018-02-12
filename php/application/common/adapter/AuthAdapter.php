<?php
namespace app\common\adapter;
use com\HonrayAuth;
class AuthAdapter
{
	private static $_instance;

	/**
	 * 用户id
	 * @var string
	 */
	private $uid;

	public function __construct($uid) 
	{
		$this->uid = $uid; 
	}

	//实例化权限类
	public static function getInstance($uid)
	{
		if (!(self::$_instance instanceof HonrayAuth)) {
			self::$_instance = new HonrayAuth($uid);
		}
		return self::$_instance; 
	}
	//登录认证
	public function checkLogin($names, $uid, $relation='or') 
	{
		self::getInstance($this->uid)->_config['AUTH_TYPE'] = 2;
		if ($uid == 1){ 
			return true;
		}
		if (!self::getInstance($this->uid)->check($names, $uid, $relation)) {
			return false;
		} else {
			return true;
		}
	}
}