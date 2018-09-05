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
        $ruleModel = model('Rule');
        $param = $this->param;
        $type = !empty($param->type) ? $param->type : '';
        $data = $ruleModel->getDataList($type);
        return resultArray(['data' => $data]);
    }

    public function read($id)
    {
        $ruleModel = model('Rule');
        $data = $ruleModel->getDataById($id);
        if (!$data) {
            return resultArray(['error' => $ruleModel->getError()]);
        }
        return resultArray(['data' => $data]);
    }

    public function save()
    {
        $ruleModel = model('Rule');
        $param = $this->param->post();
        $data = $ruleModel->createData($param);
        if (!$data) {
            return resultArray(['error' => $ruleModel->getError()]);
        }
        return resultArray(['data' => '添加成功']);
    }

    public function update($id)
    {
        $ruleModel = model('Rule');
        $param = $this->param->post();
        $data = $ruleModel->updateDataById($param, $id);
        if (!$data) {
            return resultArray(['error' => $ruleModel->getError()]);
        }
        return resultArray(['data' => '编辑成功']);
    }

    public function delete($id)
    {
        $ruleModel = model('Rule');
        $data = $ruleModel->delDataById($id, true);
        if (!$data) {
            return resultArray(['error' => $ruleModel->getError()]);
        }
        return resultArray(['data' => '删除成功']);
    }

    public function deletes()
    {
        $ruleModel = model('Rule');
        $param = $this->param->post();
        $data = $ruleModel->delDatas($param->ids, true);
        if (!$data) {
            return resultArray(['error' => $ruleModel->getError()]);
        }
        return resultArray(['data' => '删除成功']);
    }

    public function enables()
    {
        $ruleModel = model('Rule');
        $param = $this->param->post();
        $data = $ruleModel->enableDatas($param->ids, $param->status, true);
        if (!$data) {
            return resultArray(['error' => $ruleModel->getError()]);
        }
        return resultArray(['data' => '操作成功']);
    }
}
 