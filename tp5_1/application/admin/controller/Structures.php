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
        $structureModel = model('Structure');
        $data = $structureModel->getDataList();
        return resultArray(['data' => $data]);
    }

    public function read($id)
    {   
        $structureModel = model('Structure');
        $data = $structureModel->getDataById($id);
        if (!$data) {
            return resultArray(['error' => $structureModel->getError()]);
        } 
        return resultArray(['data' => $data]);
    }

    public function save()
    {
        $structureModel = model('Structure');
        $param = $this->param->post();
        $data = $structureModel->createData($param);
        if (!$data) {
            return resultArray(['error' => $structureModel->getError()]);
        } 
        return resultArray(['data' => '添加成功']);
    }

    public function update($id)
    {
        $structureModel = model('Structure');
        $param = $this->param->post();
        $data = $structureModel->updateDataById($param, $id);
        if (!$data) {
            return resultArray(['error' => $structureModel->getError()]);
        } 
        return resultArray(['data' => '编辑成功']);
    }

    public function delete($id)
    {
        $structureModel = model('Structure');
        $data = $structureModel->delDataById($id, true);       
        if (!$data) {
            return resultArray(['error' => $structureModel->getError()]);
        } 
        return resultArray(['data' => '删除成功']);    
    }

    public function deletes()
    {
        $structureModel = model('Structure');
        $param = $this->param->post();
        $data = $structureModel->delDatas($param->ids, true);  
        if (!$data) {
            return resultArray(['error' => $structureModel->getError()]);
        } 
        return resultArray(['data' => '删除成功']); 
    }

    public function enables()
    {
        $structureModel = model('Structure');
        $param = $this->param->post();
        $data = $structureModel->enableDatas($param->ids, $param->status, true);  
        if (!$data) {
            return resultArray(['error' => $structureModel->getError()]);
        } 
        return resultArray(['data' => '操作成功']);         
    }
}
 