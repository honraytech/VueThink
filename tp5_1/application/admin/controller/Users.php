<?php
// +----------------------------------------------------------------------
// | Description: 系统用户
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

class Users extends ApiCommon
{

    public function index()
    {   
        $userModel = model('User');
        $param = $this->param;
        $keywords = !empty($param->keywords) ? $param->keywords: '';
        $page = !empty($param->page) ? $param->page: '';
        $limit = !empty($param->limit) ? $param->limit: '';    
        $data = $userModel->getDataList($keywords, $page, $limit);
        return resultArray(['data' => $data]);
    }

    public function read($id)
    {   
        $userModel = model('User');
        $data = $userModel->getDataById($id);
        if (!$data) {
            return resultArray(['error' => $userModel->getError()]);
        } 
        return resultArray(['data' => $data]);
    }

    public function save()
    {
        $userModel = model('User');
        $param = $this->param->post();
        $data = $userModel->createData($param);
        if (!$data) {
            return resultArray(['error' => $userModel->getError()]);
        } 
        return resultArray(['data' => '添加成功']);
    }

    public function update($id)
    {
        $userModel = model('User');
        $param = $this->param->post();
        $data = $userModel->updateDataById($param, $id);
        if (!$data) {
            return resultArray(['error' => $userModel->getError()]);
        } 
        return resultArray(['data' => '编辑成功']);
    }

    public function delete($id)
    {
        $userModel = model('User');
        $data = $userModel->delDataById($id);       
        if (!$data) {
            return resultArray(['error' => $userModel->getError()]);
        } 
        return resultArray(['data' => '删除成功']);    
    }

    public function deletes()
    {
        $userModel = model('User');
        $param = $this->param->post();
        $data = $userModel->delDatas($param->ids);  
        if (!$data) {
            return resultArray(['error' => $userModel->getError()]);
        } 
        return resultArray(['data' => '删除成功']); 
    }

    public function enables()
    {
        $userModel = model('User');
        $param = $this->param->post();
        $data = $userModel->enableDatas($param->ids, $param->status);  
        if (!$data) {
            return resultArray(['error' => $userModel->getError()]);
        } 
        return resultArray(['data' => '操作成功']);         
    }
    
}
 