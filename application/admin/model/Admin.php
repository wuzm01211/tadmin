<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/15
 * Time: 17:36
 */

namespace app\admin\model;


use think\Db;

class Admin
{
    private $table = 'sys_admin';

    public function dataList($map='',$filed='*',$order='id desc',$per_page=15,$option=[])
    {
        if($per_page){
            $data_list = Db::table($this->table)->where($map)->field($filed)->order($order)->paginate($per_page,false,$option);
        }else{
            $data_list = Db::table($this->table)->where($map)->field($filed)->order($order)->paginate();
        }
        return $data_list;
    }

    public function addOne($data)
    {
        if(!is_array($data)) return false;
        $flag = Db::table($this->table)->where(['account'=>$data['account']])->value('id');
        if($flag) return false;
        $id = Db::table($this->table)->insert($data);
        if($id) return $id;
        else return false;
    }

    public function updateOne($data,$id)
    {
        if(!is_array($data)) return false;
        $id = intval($id);
        $fid = Db::table($this->table)->where(['account'=>$data['account']])->value('id');
        if($fid!=$id) return false;
        $rid = Db::table($this->table)->where(['id'=>$id])->update($data);
        if($rid) return $rid;
        else return false;
    }

    public function getOne($map,$field='*')
    {
        if(!$map) return false;
        return Db::table($this->table)->where($map)->field($field)->find();
    }

    public function del($map){
        if(!$map) return false;
        return Db::table($this->table)->where($map)->delete();
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