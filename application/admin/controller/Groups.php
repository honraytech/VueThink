<?php
// +----------------------------------------------------------------------
// | Description: 用户组
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

class Groups extends ApiCommon
{
    
    public function index()
    {   
        $groupModel = model('group');
        $param = $this->param;
        $data = $groupModel->getDataList();
        return resultArray(['data' => $data]);
    }

    public function read()
    {   
        $groupModel = model('group');
        $param = $this->param;
        $data = $groupModel->getDataById($param['id']);
        if (!$data) {
            return resultArray(['error' => $groupModel->getError()]);
        } 
        return resultArray(['data' => $data]);
    }

    public function save()
    {
        $groupModel = model('group');
        $param = $this->param;
        $data = $groupModel->createData($param);
        if (!$data) {
            return resultArray(['error' => $groupModel->getError()]);
        } 
        return resultArray(['data' => '添加成功']);
    }

    public function update()
    {
        $groupModel = model('group');
        $param = $this->param;
        $data = $groupModel->updateDataById($param, $param['id']);
        if (!$data) {
            return resultArray(['error' => $groupModel->getError()]);
        } 
        return resultArray(['data' => '编辑成功']);
    }

    public function delete()
    {
        $groupModel = model('group');
        $param = $this->param;
        $data = $groupModel->delDataById($param['id'], true);       
        if (!$data) {
            return resultArray(['error' => $groupModel->getError()]);
        } 
        return resultArray(['data' => '删除成功']);    
    }

    public function deletes()
    {
        $groupModel = model('group');
        $param = $this->param;
        $data = $groupModel->delDatas($param['ids'], true);  
        if (!$data) {
            return resultArray(['error' => $groupModel->getError()]);
        } 
        return resultArray(['data' => '删除成功']); 
    }

    public function enables()
    {
        $groupModel = model('group');
        $param = $this->param;
        $data = $groupModel->enableDatas($param['ids'], $param['status'], true);  
        if (!$data) {
            return resultArray(['error' => $groupModel->getError()]);
        } 
        return resultArray(['data' => '操作成功']);         
    }
}
 