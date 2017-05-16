<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/15
 * Time: 10:23
 */

namespace app\admin\model;


use think\Db;

class Role
{
    private $table = 'sys_role';

    public function dataList($map='',$filed='*',$order='id desc',$per_page=15,$option=[])
    {
        if($per_page){
            $data_list = Db::table($this->table)->where($map)->field($filed)->order($order)->paginate($per_page,false,$option);
        }else{
            $data_list = Db::table($this->table)->where($map)->field($filed)->order($order)->paginate();
        }
        if(empty($data_list)) return [];
        else return $data_list;
    }

    private function buildPms($data,$role_id)
    {
        $menu = get_menu('','id,code');
        $permission = [];
        $i = 0;
        foreach($menu as $val){
            if(isset($data[$val['code']])){
                foreach($data[$val['code']] as $vo){
                    $permission[$i]['role_id'] = $role_id;
                    $permission[$i]['op_id'] = $val['id'];
                    $permission[$i]['ac_id'] = $vo;
                    $i++;
                }
            }
        }
        return $permission;
    }

    public function addOne($data)
    {
        if(!is_array($data)) return false;
        $role_data = ['role_name'=>$data['role_name'],'status'=>$data['status'],'create_time'=>$data['create_time'],'last_time'=>$data['last_time']];
        $flag = Db::table($this->table)->where(['role_name'=>$data['role_name']])->value('id');
        if($flag) return false;
        $id = Db::table($this->table)->field('id,role_name,status,create_time,last_time')->insertGetId($role_data);
        if($id){
            $permission = $this->buildPms($data,$id);
            Db::table('sys_permission')->insertAll($permission);
            return $id;
        }else{
            return false;
        }
    }

    public function updateOne($data,$id)
    {
        if(!is_array($data)) return false;
        $role_data = ['role_name'=>$data['role_name'],'status'=>$data['status'],'last_time'=>$data['last_time']];
        $id = intval($id);
        $fid = Db::table($this->table)->where(['role_name'=>$role_data['role_name']])->order('id desc')->value('id');
        if($fid!=$id) return false;
        $rid = Db::table($this->table)->where(['id'=>$id])->update($role_data);
        $permission = $this->buildPms($data,$id);
        $old_permission = Db::table('sys_permission')->where(['role_id'=>$id])->field('role_id,op_id,ac_id')->select();
        $add_permission = [];
        $del_permission = [];
        foreach($permission as $val){
            if(!in_array($val,$old_permission)){
                $add_permission[] = $val;
            }
        }
        foreach($old_permission as $val){
            if(!in_array($val,$permission)){
                $del_permission[] = $val;
            }
        }
        if($add_permission){
            Db::table('sys_permission')->insertAll($add_permission);
        }
        if($del_permission){
            foreach($del_permission as $val){
                Db::table('sys_permission')
                    ->where(['role_id'=>$id,'op_id'=>$val['op_id'],'ac_id'=>$val['ac_id']])
                    ->delete();
            }
        }
        if($rid){
            return $rid;
        }else{
            return false;
        }

    }

    public function getOne($map,$field='*')
    {
        if(!$map) return false;
        return Db::table($this->table)->where($map)->field($field)->find();
    }

    public function delOne($map){
        if(!$map) return false;
        $info = Db::table($this->table)->where($map)->value('id');
        if($info){
            $rid =  Db::table($this->table)->where($map)->delete();
            if($rid){
                Db::table('sys_permission')->where(['role_id'=>$info])->delete();
                return $rid;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function getCount($map='')
    {
        return Db::table($this->table)->where($map)->count();
    }

    public function enable($map)
    {
        if(!$map) return false;
        return Db::table($this->table)->where($map)->setField('status',1);
    }

    public function disable($map)
    {
        if(!$map) return false;
        return Db::table($this->table)->where($map)->setField('status',0);
    }
}