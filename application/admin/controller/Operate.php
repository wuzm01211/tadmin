<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/14
 * Time: 21:44
 */

namespace app\admin\controller;
use app\admin\model\Operate as OperateModel;


class Operate extends Base
{
    private $model = '';
    const ACTION_TITLE = '菜单';

    public function __construct()
    {
        if(!$this->model) $this->model = new OperateModel();
        parent::__construct();
    }

    public function index()
    {
        $title = urldecode(input('title'));
        $pid = intval(input('pid'));
        $where = [];
        $option = [];
        if($title){
            $where['title'] = ['like','%'.$title.'%'];
            $this->search_data['title'] = $title;
            $option['query']['title'] = $title;
        }

        if($pid){
            $where['pid'] = $pid;
            $this->search_data['pid'] = $pid;
            $option['query']['pid'] = $pid;
        }

        $pid_arr = $this->model->dataList(['pid'=>0],'id as value,title','',0);

        $this->title = self::ACTION_TITLE.'列表';
        $this->search_items = [
            ['type'=>'text','label'=>'菜单名称','name'=>'title','id'=>'title','placeholder'=>'请输入菜单名称，必填'],
            ['type'=>'select','label'=>'上级菜单','name'=>'pid','id'=>'pid','data'=>$pid_arr],
        ];
        $this->t_head = ['id','上级菜单','菜单名称','code','url','修改时间','图标','操作'];
        $this->data_items = ['id','pid','title','code','url','last_time','icon','right_button'];

        $this->data_list = $this->model->dataList($where,'','',15,$option);
        $this->setPage();
        $menu_arr = get_menu_arr();
        $right_button = get_button('right_button',0);
        foreach($this->data_list as &$val){
            foreach($right_button as &$vo){
                $vo['url'] = url($vo['code'],['id'=>$val['id']]);
            }
            $val['pid'] = $menu_arr[$val['pid']];
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
        if(request()->isPost()){
            $this->save();
        }
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
                $this->title =  '修改'.self::ACTION_TITLE;
                $this->form_method = 'post';
                $this->form_url = url('edit',['id'=>$id]);
                $this->form_data = $data;
                $this->formUI();
                return parent::edit();
            }
        }
    }

    private function formUI(){
        $pid_arr = $this->model->dataList(['pid'=>0],'id as value,title','',0);
        $this->form_items = [
            ['type'=>'text','label'=>'菜单名称','name'=>'title','id'=>'title','placeholder'=>'请输入菜单名称，必填'],
            ['type'=>'text','label'=>'code','name'=>'code','id'=>'code','placeholder'=>'请输入code，必填'],
            ['type'=>'text','label'=>'url','name'=>'url','id'=>'url','placeholder'=>'请输入url，必填'],
            ['type'=>'select','label'=>'上级菜单','name'=>'pid','id'=>'pid','data'=>$pid_arr],
            ['type'=>'text','label'=>'图标','name'=>'icon','id'=>'icon','placeholder'=>'菜单图标 fa-icon'],
            ['type'=>'text','label'=>'排序','name'=>'sort','id'=>'sort','placeholder'=>'排序'],
        ];
    }

    private function save()
    {
        $data = input();
        $data['last_time'] = time();
        if(isset($data['id'])){
            $id = $data['id'];
            unset($data['id']);
            if($this->model->updateOne($data,$id)){
                $this->success('修改菜单成功',url('index'));
            }else{
                $this->error('修改菜单失败');
            }
        }else{
            if($this->model->addOne($data)){
                $this->success('添加菜单成功',url('index'));
            }else{
                $this->error('添加菜单失败');
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
                $this->success('删除菜单成功',url('index'));
            }else{
                $this->error('删除菜单失败');
            }
        }
    }
}