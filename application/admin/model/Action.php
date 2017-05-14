<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/14
 * Time: 18:20
 */

namespace app\admin\model;


use think\console\command\make\Model;
use think\Db;

class Action extends Model
{
    private $table = 'sys_action';

    public function dataList($map='',$filed='')
    {
        $data_list = Db::table($this->table)->where($map)->field($filed)->select();
        if(empty($data_list)) return [];
        else return $data_list;
    }

    public function addOne($data)
    {
        if(!is_array($data)) return false;
        foreach($data as $val){
            if(!$val) return false;
        }
        $flag = Db::table($this->table)->whereOr(['title'=>$data['title'],'code'=>$data['code']])->value('id');
        if($flag) return false;
        $id = Db::table($this->table)->insert($data);
        if($id) return $id;
        else return false;
    }

    public function updateOne($data,$id)
    {
        if(!is_array($data)) return false;
        foreach($data as $val){
            if(!$val) return false;
        }
        $id = intval($id);
        $fid = Db::table($this->table)->whereOr(['title'=>$data['title'],'code'=>$data['code']])->value('id');
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

    public function delOne($map){
        if(!$map) return false;
        return Db::table($this->table)->where($map)->delete();
    }
}