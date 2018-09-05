<?php
// +----------------------------------------------------------------------
// | Description: 图片上传
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\facade\Request;

class Upload extends ApiCommon
{   
    public function index()
    {	
        $file = request()->file('file');
        if (!$file) {
        	return resultArray(['error' => '请上传文件']);
        }
        
        $info = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . DS . 'uploads');
        if ($info) {
            return resultArray(['data' =>  'uploads'. DS .$info->getSaveName()]);
        }
        
        return resultArray(['error' =>  $file->getError()]);
    }
}
 