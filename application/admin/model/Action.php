<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/14
 * Time: 18:20
 */

namespace app\admin\model;

use think\Db;

class Action
{
    private $table = 'sys_action';

    public function dataList($map='',$filed='',$order='id desc',$per_page=15,$option=[])
    {
        if($per_page){
            $data_list = Db::table($this->table)->where($map)->field($filed)->order($order)->paginate($per_page,false,$option);
        }else{
            $data_list = Db::table($this->table)->where($map)->field($filed)->order($order)->paginate();
        }

        if(empty($data_list)) return [];
        else return $data_list;
    }

    public function addOne($data)
    {
        if(!is_array($data)) return false;
        $id = Db::table($this->table)->insert($data);
        if($id) return $id;
        else return false;
    }

    public function updateOne($data,$id)
    {
        if(!is_array($data)) return false;
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
}