<?php
// +----------------------------------------------------------------------
// | Description: 规则
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

class Rules extends ApiCommon
{

    public function index()
    {   
        $ruleModel = model('rule');
        $param = $this->param;
        $data = $ruleModel->getDataList($param['type']);
        return resultArray(['data' => $data]);
    }

    public function read()
    {   
        $ruleModel = model('rule');
        $param = $this->param;
        $data = $ruleModel->getDataById($param['id']);
        if (!$data) {
            return resultArray(['error' => $ruleModel->getError()]);
        } 
        return resultArray(['data' => $data]);
    }

    public function save()
    {
        $ruleModel = model('rule');
        $param = $this->param;
        $data = $ruleModel->createData($param);
        if (!$data) {
            return resultArray(['error' => $ruleModel->getError()]);
        } 
        return resultArray(['data' => '添加成功']);
    }

    public function update()
    {
        $ruleModel = model('rule');
        $param = $this->param;
        $data = $ruleModel->updateDataById($param, $param['id']);
        if (!$data) {
            return resultArray(['error' => $ruleModel->getError()]);
        } 
        return resultArray(['data' => '编辑成功']);
    }

    public function delete()
    {
        $ruleModel = model('rule');
        $param = $this->param;
        $data = $ruleModel->delDataById($param['id'], true);       
        if (!$data) {
            return resultArray(['error' => $ruleModel->getError()]);
        } 
        return resultArray(['data' => '删除成功']);    
    }

    public function deletes()
    {
        $ruleModel = model('rule');
        $param = $this->param;
        $data = $ruleModel->delDatas($param['ids'], true);  
        if (!$data) {
            return resultArray(['error' => $ruleModel->getError()]);
        } 
        return resultArray(['data' => '删除成功']); 
    }

    public function enables()
    {
        $ruleModel = model('rule');
        $param = $this->param;
        $data = $ruleModel->enableDatas($param['ids'], $param['status'], true);  
        if (!$data) {
            return resultArray(['error' => $ruleModel->getError()]);
        } 
        return resultArray(['data' => '操作成功']);         
    }
}
 