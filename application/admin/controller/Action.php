<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/14
 * Time: 17:57
 */

namespace app\admin\controller;

use app\admin\model\Action as ActionModel;

class Action extends Base
{
    private $model = '';

    public function __construct()
    {
        if(!$this->model) $this->model = new ActionModel();
        parent::__construct();
    }

    public function index()
    {
        $this->top_buttons = [
            ['type'=>'primary','url'=>url('add'),'title'=>'添加','action'=>'redirect']
        ];
        $this->title = '操作列表';
        $this->t_head = ['id','操作名称','操作码','动作','样式','操作'];
        $this->data_items = ['id','title','code','action','type','right_button'];
        $this->data_list = $this->model->dataList();
        $this->setPage();
        foreach($this->data_list as &$val){
            $val['right_button'] = [
                ['type'=>'info','title'=>'修改','action'=>'redirect','url'=>url('edit',['id'=>$val['id']])],
                ['type'=>'danger','title'=>'删除','action'=>'confirm','url'=>url('delete',['id'=>$val['id']])],
            ];
        }
        return parent::index();
    }

    public function add()
    {
        $this->title = '添加操作';
        $this->form_method = 'post';
        $this->form_url = url('save');
        $this->formUI();
        return parent::add();
    }

    public function edit()
    {
        $id = intval(input('id'));
        if(!$id){
            $this->error('参数错误');
            return false;
        }else{
            $data = $this->model->getOne(['id'=>$id]);
            if(!$data){
                $this->error('数据不存在');
                return false;
            }else{
                $this->title = '修改操作';
                $this->form_method = 'post';
                $this->form_url = url('save',['id'=>$id]);
                $this->form_data = $data;
                $this->formUI();
                return parent::edit();
            }
        }
    }

    private function formUI(){
        $this->form_items = [
            ['type'=>'text','label'=>'操作名称','name'=>'title','id'=>'title','placeholder'=>'请输入操作名称，必填'],
            ['type'=>'text','label'=>'操作码','name'=>'code','id'=>'title','placeholder'=>'请输入操作码，必填'],
            ['type'=>'radio','label'=>'动作','name'=>'action','id'=>'action','data'=>[
                ['value'=>'redirect','title'=>'直接跳转'],
                ['value'=>'confirm','title'=>'等待确认'],
            ]],
            ['type'=>'select','label'=>'样式','name'=>'type','id'=>'type','data'=>[
                ['value'=>'default','title'=>'default'],
                ['value'=>'primary','title'=>'primary'],
                ['value'=>'success','title'=>'success'],
                ['value'=>'info','title'=>'info'],
                ['value'=>'warning','title'=>'warning'],
                ['value'=>'danger','title'=>'danger'],
            ]]
        ];
    }

    public function save()
    {
        $data = input();
        if(isset($data['id'])){
            $id = $data['id'];
            unset($data['id']);
            if($this->model->updateOne($data,$id)){
                $this->success('修改操作成功',url('index'));
            }else{
                $this->error('添加操作失败');
            }
        }else{
            if($this->model->addOne($data)){
                $this->success('添加操作成功',url('index'));
            }else{
                $this->error('添加操作失败');
            }
        }
    }

    public function delete()
    {
        $id = intval(input('id'));
        if(!$id){
            $this->error('参数错误');
        }else{
            if($this->model->delOne(['id'=>$id])){
                $this->success('删除操作成功',url('index'));
            }else{
                $this->error('删除操作失败');
            }
        }
    }
}