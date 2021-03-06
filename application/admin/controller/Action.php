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

    const ACTION_TITLE = '操作';

    public function __construct()
    {
        if(!$this->model) $this->model = new ActionModel();
        parent::__construct();
    }

    public function index()
    {
        $this->title = self::ACTION_TITLE.'列表';
        $this->t_head = ['id','所属菜单','操作名称','操作码','动作','样式','位置','操作'];
        $this->data_items = ['id','op_id','title','code','action','type','pos','right_button'];
        $this->data_list = $this->model->dataList();
        $this->setPage();
        $menu_arr = get_menu_arr();
        $right_button = get_button('right_button',0);
        foreach($this->data_list as &$val){
            foreach($right_button as &$vo){
                $vo['url'] = url($vo['code'],['id'=>$val['id']]);
            }
            $val['op_id'] = $menu_arr[$val['op_id']];
            $val['right_button'] = $right_button;
        }
        return parent::index();
    }

    public function add()
    {
        if(request()->isPost()){
            $this->save();
        }
        $this->title = '添加'.self::ACTION_TITLE;
        $this->form_method = 'post';
        $this->form_url = url('add');
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
            if(request()->isPost()){
                $this->save();
            }
            $data = $this->model->getOne(['id'=>$id]);
            if(!$data){
                $this->error('数据不存在');
                return false;
            }else{
                $data['pos'] = explode(',',$data['pos']);
                $this->title = '修改'.self::ACTION_TITLE;
                $this->form_method = 'post';
                $this->form_url = url('edit',['id'=>$id]);
                $this->form_data = $data;
                $this->formUI();
                return parent::edit();
            }
        }
    }

    private function formUI(){
        $op_arr = get_menu('','id as value,title');
        $this->form_items = [
            ['type'=>'text','label'=>'操作名称','name'=>'title','id'=>'title','placeholder'=>'请输入操作名称，必填'],
            ['type'=>'text','label'=>'操作码','name'=>'code','id'=>'title','placeholder'=>'请输入操作码，必填'],
            ['type'=>'text','label'=>'排序','name'=>'sort','id'=>'sort','placeholder'=>'排序'],
            ['type'=>'select','label'=>'所属菜单','name'=>'op_id','id'=>'op_id','data'=>$op_arr],
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
            ]],
            ['type'=>'checkbox','label'=>'位置','name'=>'pos','id'=>'pos','data'=>[
                ['value'=>'hidden','title'=>'隐藏'],
                ['value'=>'top_button','title'=>'顶部按钮'],
                ['value'=>'right_button','title'=>'右侧按钮'],
            ]]
        ];
    }

    private function save()
    {
        $data = input();
        $data['pos'] = implode(',',$data['pos']);
        if(isset($data['id'])){
            $id = $data['id'];
            unset($data['id']);
            if($this->model->updateOne($data,$id)){
                $this->success('修改'.self::ACTION_TITLE.'成功',url('index'));
            }else{
                $this->error('添加'.self::ACTION_TITLE.'失败');
            }
        }else{
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
        if(!$id){
            $this->error('参数错误');
        }else{
            if($this->model->delOne(['id'=>$id])){
                $this->success('删除'.self::ACTION_TITLE.'成功',url('index'));
            }else{
                $this->error('删除'.self::ACTION_TITLE.'失败');
            }
        }
    }
}