<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/13
 * Time: 0:16
 */

namespace app\admin\controller;

use app\admin\model\Admin as AdminModel;
class Admin extends Base
{
    private $model = '';

    public function __construct()
    {
        if(!$this->model) $this->model = new AdminModel();
        parent::__construct();
    }

    public function index()
    {
        $this->title = '管理员列表';
        $data_list = $this->model->dataList();

    }
}