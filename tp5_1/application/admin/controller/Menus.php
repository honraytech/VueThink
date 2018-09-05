<?php
// +----------------------------------------------------------------------
// | Description: 菜单
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

class Menus extends ApiCommon
{
    
    public function index()
    {   
        $menuModel = model('Menu');
        $param = $this->param;
        $data = $menuModel->getDataList();
        return resultArray(['data' => $data]);
    }

    public function read($id)
    {   
        $menuModel = model('Menu');
        $data = $menuModel->getDataById($id);
        if (!$data) {
            return resultArray(['error' => $menuModel->getError()]);
        } 
        return resultArray(['data' => $data]);
    }

    public function save()
    {
        $menuModel = model('Menu');
        $param = $this->param->post();
        $data = $menuModel->createData($param);
        if (!$data) {
            return resultArray(['error' => $menuModel->getError()]);
        } 
        return resultArray(['data' => '添加成功']);
    }

    public function update($id)
    {
        $menuModel = model('Menu');
        $param = $this->param->post();
        $data = $menuModel->updateDataById($param, $id);
        if (!$data) {
            return resultArray(['error' => $menuModel->getError()]);
        } 
        return resultArray(['data' => '编辑成功']);
    }

    public function delete($id)
    {
        $menuModel = model('Menu');
        $data = $menuModel->delDataById($id, true);       
        if (!$data) {
            return resultArray(['error' => $menuModel->getError()]);
        } 
        return resultArray(['data' => '删除成功']);    
    }

    public function deletes()
    {
        $menuModel = model('Menu');
        $param = $this->param->post();
        $data = $menuModel->delDatas($param->ids, true);  
        if (!$data) {
            return resultArray(['error' => $menuModel->getError()]);
        } 
        return resultArray(['data' => '删除成功']); 
    }

    public function enables()
    {
        $menuModel = model('Menu');
        $param = $this->param->post();
        $data = $menuModel->enableDatas($param->ids, $param->status, true);  
        if (!$data) {
            return resultArray(['error' => $menuModel->getError()]);
        } 
        return resultArray(['data' => '操作成功']);         
    }
}
 