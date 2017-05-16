<?php
/**
 * Created by PhpStorm.
 * User: wzm
 * Date: 2017/5/13
 * Time: 0:44
 * 后台模块基类
 */

namespace app\admin\controller;

use think\Controller;
use think\Db;

class Base extends Controller
{
    protected $builder = '';                //HBuilder类对象句柄
    protected $title = '';                  //页面标题
    protected $top_buttons = [];            //顶部按钮

    protected $t_head = [];                 //表格头部
    protected $data_list = [];              //表格数据
    protected $data_items = [];             //表格元素

    protected $form_items = [];             //表单元素
    protected $form_method = 'get';         //表单方法
    protected $form_url = '';               //表单url
    protected $form_enctype = '';           //表单enctype 默认 application/x-www-form-urlencoded
    protected $form_data = [];              //表单数据

    protected $search_items = [];           //搜索元素
    protected $search_data = [];            //搜索数据

    protected $pk = 'id';                   //数据表组件 默认为id

    protected $ueditor = 0;                 //是否引入ueditor 默认0 不引入 其他值 引入

    public function __construct()
    {
        $this->isLogin();
        if(config('permission_check')){
            if(!check_permission()){
                $this->error('无权访问');
            }
            $menu_tree = get_permission_menu_tree();
        }else{
            $menu_tree = get_menu_tree();
        }

        parent::__construct();
        $this->assign('ueditor',$this->ueditor);
        $this->assign('menu_tree',$menu_tree);

        if(!$this->builder){
            $this->builder = new HBuilder();
        }
    }

    private function isLogin()
    {
        if(!is_login()){
            $this->redirect(url('admin/login/index'));
        }
    }

    protected function index()
    {


        return $this->builder
            ->setTitle($this->title)
            ->setTopButtons($this->top_buttons)
            ->setFormMethod($this->form_method)
            ->setFormUrl($this->form_url)
            ->setSearchForm($this->search_items,$this->search_data)
            ->setTHead($this->t_head)
            ->setTBody($this->data_list,$this->data_items)
            ->fetch('base/index');
    }

    protected function add()
    {
        return $this->builder
            ->setTitle($this->title)
            ->setFormMethod($this->form_method)
            ->setFormUrl($this->form_url)
            ->setFormType($this->form_enctype)
            ->setFormItems($this->form_items,'')
            ->fetch('base:add');
    }

    protected function edit()
    {
        return $this->builder
            ->setTitle($this->title)
            ->setFormMethod($this->form_method)
            ->setFormUrl($this->form_url)
            ->setFormType($this->form_enctype)
            ->setFormItems($this->form_items,$this->form_data)
            ->fetch('base:edit');
    }

    protected function setPage()
    {
        $page = $this->data_list->render();
        $this->data_list = $this->data_list->items('items');
        $this->assign('page',$page);
    }
}