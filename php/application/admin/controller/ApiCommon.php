<?php
// +----------------------------------------------------------------------
// | Description: Api基础类，验证权限
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\Request;
use think\Db;
use app\common\adapter\AuthAdapter;
use app\common\controller\Common;

class ApiCommon extends Common
{
    public function _initialize()
    {
        parent::_initialize();
        /*获取头部信息*/ 
        $header = Request::instance()->header();
        $authKey = $header['authkey'];
        $uid = model('User')->getUid($authKey);
        // 校验authKey
        if (empty($authKey) || !$uid) {
            header('Content-Type:application/json; charset=utf-8');
            exit(json_encode(['code'=>101, 'error'=>'登录已失效']));
        }

        // 检查账号有效性
        $userInfo = model('User')->getUserById($uid);
        $map['id'] = $userInfo['id'];
        $map['status'] = 1;
        if (!Db::name('admin_user')->where($map)->value('id')) {
            header('Content-Type:application/json; charset=utf-8');
            exit(json_encode(['code'=>103, 'error'=>'账号已被删除或禁用']));   
        }
        $authAdapter = new AuthAdapter($authKey);
        $request = Request::instance();
        $ruleName = $request->module().'-'.$request->controller() .'-'.$request->action(); 
        if (!$authAdapter->checkLogin($ruleName, $userInfo['id'])) {
            header('Content-Type:application/json; charset=utf-8');
            exit(json_encode(['code'=>102,'error'=>'没有权限']));
        }
        $GLOBALS['userInfo'] = $userInfo;
    }
}
