<?php
// +----------------------------------------------------------------------
// | Description: 组织架构
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

class Structures extends ApiCommon
{
    
    public function index()
    {   
        $structureModel = model('structure');
        $param = $this->param;
        $data = $structureModel->getDataList();
        return resultArray(['data' => $data]);
    }

    public function read()
    {   
        $structureModel = model('structure');
        $param = $this->param;
        $data = $structureModel->getDataById($param['id']);
        if (!$data) {
            return resultArray(['error' => $structureModel->getError()]);
        } 
        return resultArray(['data' => $data]);
    }

    public function save()
    {
        $structureModel = model('structure');
        $param = $this->param;
        $data = $structureModel->createData($param);
        if (!$data) {
            return resultArray(['error' => $structureModel->getError()]);
        } 
        return resultArray(['data' => '添加成功']);
    }

    public function update()
    {
        $structureModel = model('structure');
        $param = $this->param;
        $data = $structureModel->updateDataById($param, $param['id']);
        if (!$data) {
            return resultArray(['error' => $structureModel->getError()]);
        } 
        return resultArray(['data' => '编辑成功']);
    }

    public function delete()
    {
        $structureModel = model('structure');
        $param = $this->param;
        $data = $structureModel->delDataById($param['id'], true);       
        if (!$data) {
            return resultArray(['error' => $structureModel->getError()]);
        } 
        return resultArray(['data' => '删除成功']);    
    }

    public function deletes()
    {
        $structureModel = model('structure');
        $param = $this->param;
        $data = $structureModel->delDatas($param['ids'], true);  
        if (!$data) {
            return resultArray(['error' => $structureModel->getError()]);
        } 
        return resultArray(['data' => '删除成功']); 
    }

    public function enables()
    {
        $structureModel = model('structure');
        $param = $this->param;
        $data = $structureModel->enableDatas($param['ids'], $param['status'], true);  
        if (!$data) {
            return resultArray(['error' => $structureModel->getError()]);
        } 
        return resultArray(['data' => '操作成功']);         
    }
}
 