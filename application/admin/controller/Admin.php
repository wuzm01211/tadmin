<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/13
 * Time: 0:16
 */

namespace app\admin\controller;

use app\admin\model\Admin as AdminModel;
use think\Db;

class Admin extends Base
{
    private $model = '';
    const ACTION_TITLE = '管理员';

    public function __construct()
    {
        if(!$this->model) $this->model = new AdminModel();
        parent::__construct();
    }

    public function index()
    {
        $account = urldecode(input('account'));
        $where = [];
        $option = [];
        if($account){
            $where['account'] = $account;
            $option['account'] = $account;
        }
        $this->title = self::ACTION_TITLE.'列表';
        $this->top_buttons = get_button();
        $this->search_items = [
          ['type'=>'text','label'=>'账号','name'=>'account','id'=>'account','placeholder'=>'账号'],
        ];
        $this->data_items = ['account','role','last_time','last_ip','status','right_button'];
        $this->t_head = ['账号','角色','最近登录','最近ip','状态','操作'];
        $this->data_list = $this->model->dataList($where,'','id desc',15,$option);
        $this->setPage();
        $right_button = get_button('right_button',0);
        foreach($this->data_list as &$val){
            $val['role'] = Db::table('sys_role')->where(['id'=>$val['role_id']])->value('role_name');
            unset($val['role_id']);
            foreach($right_button as &$vo){
                $vo['url'] = url($vo['code'],['id'=>$val['id']]);
            }
            $val['right_button'] = $right_button;
            switch($val['status']){
                case '0':
                    unset($val['right_button']['disable']);
                    $val['status'] = "<span style='color: #ff3d0c'>禁用</span>";
                    break;
                case '1':
                    unset($val['right_button']['enable']);
                    $val['status'] = "<span style='color: #396;'>启用</span>";
                    break;
                default:
                    $val['status'] = "未知";
            }
        }
        return parent::index();
    }

    public function formUI()
    {
        $role = get_role_arr('','id as value,role_name as title');
        $this->form_items = [
            ['type'=>'text','label'=>'账号','name'=>'account','id'=>'account','placeholder'=>'请输入账号'],
            ['type'=>'password','label'=>'密码','name'=>'pwd','id'=>'pwd','placeholder'=>'请输入密码,修改时留空则不改变密码'],
            ['type'=>'select','label'=>'角色','name'=>'role_id','id'=>'role_id','data'=>$role],
            ['type'=>'radio','label'=>'状态','name'=>'status','id'=>'status','data'=>[
                ['value'=>0,'title'=>'禁用'],
                ['value'=>1,'title'=>'启用'],
            ]]
        ];
    }

    public function add()
    {
        $this->title = '添加'.self::ACTION_TITLE;
        $this->form_url = url('save');
        $this->formUI();
        return parent::add();
    }

    public function edit()
    {
        $id = intval(input('id'));
        $this->formUI();
        $this->form_data = $this->model->getOne(['id'=>$id],'id,account,role_id,status');
        $this->title = '编辑'.self::ACTION_TITLE;
        $this->form_url = url('save',['id'=>$id]);
        $this->form_method = 'post';
        return parent::edit();
    }

    public function save()
    {
        $data = input();
        if(isset($data['id'])){
            $id = $data['id'];
            unset($data['id']);
            if(!$data['pwd']) unset($data['pwd']);
            else $data['pwd'] = md5($data['pwd']);
            if($this->model->updateOne($data,$id)){
                $this->success('修改'.self::ACTION_TITLE.'成功',url('index'));
            }else{
                $this->error('添加'.self::ACTION_TITLE.'失败');
            }
        }else{
            $data['pwd'] = md5($data['pwd']);
            $data['last_time'] = $data['create_time'] = time();
            $data['last_ip'] = '0.0.0.0';
            if($this->model->addOne($data)){
                $this->success('添加'.self::ACTION_TITLE.'成功',url('index'));
            }else{
                $this->error('添加'.self::ACTION_TITLE.'失败');
            }
        }
    }

    public function delete()
    {
        $id = intval(input('id'));
        $ids = input('ids');
        $where = '';
        if($id&&$ids){
            $this->error('参数错误');
        }else if($id){
            $where = ['id'=>$id];
        }else if($ids){
            $where = ['id'=>['in',explode(',',$ids)]];
        }else{
            $this->error('参数错误');
        }
        $rid = $this->model->getOne($where);
        if(!$rid){
            $this->success('删除'.self::ACTION_TITLE.'成功',request()->server('HTTP_REFERER'));
        }else{
            if($this->model->del($where)){
                $this->success('删除'.self::ACTION_TITLE.'成功',request()->server('HTTP_REFERER'));
            }else{
                $this->error('删除'.self::ACTION_TITLE.'失败');
            }
        }
    }

    public function enable()
    {
        $id = intval(input('id'));
        $ids = input('ids');
        $where = '';
        if($id&&$ids){
            $this->error('参数错误');
        }else if($id){
            $where = ['id'=>$id];
        }else if($ids){
            $where = ['id'=>['in',explode(',',$ids)]];
        }else{
            $this->error('参数错误');
        }

        if($this->model->enable($where)){
            $this->success('启用'.self::ACTION_TITLE.'成功',request()->server('HTTP_REFERER'));
        }else{
            $this->error('启用'.self::ACTION_TITLE.'失败');
        }
    }

    public function disable()
    {
        $id = intval(input('id'));
        $ids = input('ids');
        $where = '';
        if($id&&$ids){
            $this->error('参数错误');
        }else if($id){
            $where = ['id'=>$id];
        }else if($ids){
            $where = ['id'=>['in',explode(',',$ids)]];
        }else{
            $this->error('参数错误');
        }

        if($this->model->disable($where)){
            $this->success('禁用'.self::ACTION_TITLE.'成功',request()->server('HTTP_REFERER'));
        }else{
            $this->error('禁用'.self::ACTION_TITLE.'失败');
        }
    }
}