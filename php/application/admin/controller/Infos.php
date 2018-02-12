<?php
namespace app\admin\controller;
use app\common\controller\Common;
use think\Request;

class Infos extends Common
{
    public function index(){
        $header = Request::instance()->header();
        $authKey = $header['authkey'];
        $userModel = model('User');
        $uid = $userModel->getUid($authKey);
        if($uid){
            $data = $userModel->getInfo($uid);
            return resultArray(['data' => $data]);
        }else{
            header('Content-Type:application/json; charset=utf-8');
            exit(json_encode(['code'=>101, 'error'=>'登录已失效']));
        }
    }
    public function refresh(){
        $header = Request::instance()->header();
        $authKey = $header['authkey'];
        $userModel = model('User');
        $uid = $userModel->getUid($authKey);
        if($uid){
            $authData = $userModel->createJwt($uid);
            return resultArray(['data' => $authData]);
        }else{
            header('Content-Type:application/json; charset=utf-8');
            exit(json_encode(['code'=>101, 'error'=>'登录已失效']));
        }
    }
}