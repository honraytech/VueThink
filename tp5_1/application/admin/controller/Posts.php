<?php
// +----------------------------------------------------------------------
// | Description: 部门控制器
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

class Posts extends ApiCommon
{

    public function index()
    {
        $postModel = model('Post');
        $param = $this->param;
        $keywords = empty($param->keywords) ? $param->keywords : '';
        $data = $postModel->getDataList($keywords);
        return resultArray(['data' => $data]);
    }

    public function read($id)
    {
        $postModel = model('Post');
        $data = $postModel->getDataById($id);
        if (!$data) {
            return resultArray(['error' => $postModel->getError()]);
        }
        return resultArray(['data' => $data]);
    }

    public function save()
    {
        $postModel = model('Post');
        $param = $this->param->post();
        $data = $postModel->createData($param);
        if (!$data) {
            return resultArray(['error' => $postModel->getError()]);
        }
        return resultArray(['data' => '添加成功']);
    }

    public function update($id)
    {
        $postModel = model('Post');
        $param = $this->param->post();
        $data = $postModel->updateDataById($param, $id);
        if (!$data) {
            return resultArray(['error' => $postModel->getError()]);
        }
        return resultArray(['data' => '编辑成功']);
    }

    public function delete($id)
    {
        $postModel = model('Post');
        $data = $postModel->delDataById($id);
        if (!$data) {
            return resultArray(['error' => $postModel->getError()]);
        }
        return resultArray(['data' => '删除成功']);
    }

    public function deletes()
    {
        $postModel = model('Post');
        $param = $this->param->post();
        $data = $postModel->delDatas($param->ids);
        if (!$data) {
            return resultArray(['error' => $postModel->getError()]);
        }
        return resultArray(['data' => '删除成功']);
    }

    public function enables()
    {
        $postModel = model('Post');
        $param = $this->param->post();
        $data = $postModel->enableDatas($param->ids, $param->status);
        if (!$data) {
            return resultArray(['error' => $postModel->getError()]);
        }
        return resultArray(['data' => '操作成功']);
    }

}
 