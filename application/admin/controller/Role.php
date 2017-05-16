<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/13
 * Time: 0:43
 */

namespace app\admin\controller;
use think\Db;
use app\admin\model\Role as RoleModel;

class Role extends Base
{
    private $model = '';
    const ACTION_TITLE = '角色';

    public function __construct()
    {
        if(!$this->model) $this->model = new RoleModel();
        parent::__construct();
    }
    public function index()
    {
        $role_name = urldecode(input('role_name'));
        $where = [];
        $option = [];
        if($role_name){
            $where['role_name'] = ['like','%'.$role_name.'%'];
            $this->search_data['role_name'] = $role_name;
            $option['query']['role_name'] = $role_name;
        }

        $this->search_items = [
            ['type'=>'text','label'=>'角色名','name'=>'role_name','id'=>'role_name','placeholder'=>'请输入角色名'],
        ];
        $this->t_head = ['ID','角色','添加时间','修改时间','状态','操作'];
        $this->data_list = $this->model->dataList($where,'','',15,$option);
        $this->setPage();
        foreach($this->data_list as &$val){
            $val['right_button'] = [
                ['type'=>'info','title'=>'修改','action'=>'redirect','url'=>url('edit',['id'=>$val['id']])],
                ['type'=>'danger','title'=>'删除','action'=>'confirm','url'=>url('delete',['id'=>$val['id']])]
            ];

            switch($val['status']){
                case '0':
                    $val['right_button'][] = ['type'=>'success','title'=>'启用','action'=>'confirm','url'=>url('enable',['id'=>$val['id']])];
                    $val['status'] = "<span style='color: #ff3d0c'>禁用</span>";
                    break;
                case '1':
                    $val['right_button'][] = ['type'=>'warning','title'=>'禁用','action'=>'confirm','url'=>url('disable',['id'=>$val['id']])];
                    $val['status'] = "<span style='color: #396;'>启用</span>";
                    break;
                default:
                    $val['status'] = "未知";
            }

        }
        $this->top_buttons = [
            ['type'=>'primary','title'=>'添加','action'=>'redirect','url'=>url('add')]
        ];
        $this->data_items = ['id','role_name','create_time','last_time','status','right_button'];
        $this->form_url = url('index');
        return parent::index();
    }

    public function add()
    {
        if(request()->isPost()){
            $this->save();
        }
        $this->formUI();
        $this->title = '添加'.self::ACTION_TITLE;
        $this->form_method = 'post';
        $this->form_url = url('add');
        $this->ueditor = 1;
        return parent::add();
    }

    public function edit()
    {
        if(request()->isPost()){
            $this->save();
        }
        $id = intval(input('id'));
        $this->formUI();
        $this->setFormData($id);
        $this->title = '编辑'.self::ACTION_TITLE;
        $this->form_url = url('edit',['id'=>$id]);
        $this->form_method = 'post';
        return parent::edit();
    }

    private function setFormData($id)
    {
        $this->form_data = $this->model->getOne(['id'=>$id]);
        $permission = Db::table('sys_permission')->where(['role_id'=>$id])->select();
        $row = [];
        $menu = get_menu('','id,code');
        foreach($permission as $val){
            $row[$val['op_id']][] = $val['ac_id'];
        }
        foreach($menu as $val){
            if(isset($row[$val['id']])){
                $this->form_data[$val['code']] = $row[$val['id']];
            }
        }
    }

    private function save()
    {
        $data = input();
        $the_time = time();
        $data['last_time'] = $the_time;
        if(isset($data['id'])){
            $id = $data['id'];
            unset($data['id']);
            if($this->model->updateOne($data,$id)){
                $this->success('修改'.self::ACTION_TITLE.'成功',url('index'));
            }else{
                $this->error('修改'.self::ACTION_TITLE.'失败');
            }
        }else{
            $data['create_time'] = $the_time;
            if($this->model->addOne($data)){
                $this->success('添加'.self::ACTION_TITLE.'成功',url('index'));
            }else{
                $this->error('添加'.self::ACTION_TITLE.'失败');
            }
        }
    }

    private function formUI()
    {
        $menu = get_menu('','title as label,code as name','');
        $permission = [];
        $action = get_action('','id as value,title','id asc');
        foreach($menu as $val){
            $val['data'] = $action;
            $permission[] = $val;
        }

        $this->form_items = [
            ['type'=>'text','label'=>'角色名','name'=>'role_name','id'=>'role_name','placeholder'=>'请输入角色名'],
            ['type'=>'radio','label'=>'状态','name'=>'status','id'=>'status',
                'data'=>[
                    ['value'=>1,'title'=>'启用'],
                    ['value'=>0,'title'=>'禁用'],
                ]
            ],
            ['type'=>'table_checkbox','label'=>'权限',
                'th'=>[
                    ['width'=>'20%','title'=>'菜单'],
                    ['width'=>'80%','title'=>'操作'],
                ],
                'td'=>$permission,
            ],
        ];
    }

    public function delete($id)
    {
        if(!$id) $this->error('参数有误');
        $rid = $this->model->getOne(['id'=>$id]);
        if(!$rid){
            $this->success('删除'.self::ACTION_TITLE.'成功',request()->server('HTTP_REFERER'));
        }else{
            if($this->model->delOne(['id'=>$id])){
                $this->success('删除'.self::ACTION_TITLE.'成功',request()->server('HTTP_REFERER'));
            }else{
                $this->error('删除'.self::ACTION_TITLE.'失败');
            }
        }
    }

    public function enable($id)
    {
        $id = intval($id);
        if(!$id) $this->error('参数有误');

        if($this->model->enable(['id'=>$id])){
            $this->success('启用'.self::ACTION_TITLE.'成功',request()->server('HTTP_REFERER'));
        }else{
            $this->error('启用'.self::ACTION_TITLE.'失败');
        }
    }

    public function disable($id)
    {
        $id = intval($id);
        if(!$id) $this->error('参数有误');

        if($this->model->disable(['id'=>$id])){
            $this->success('禁用'.self::ACTION_TITLE.'成功',request()->server('HTTP_REFERER'));
        }else{
            $this->error('禁用'.self::ACTION_TITLE.'失败');
        }
    }
}