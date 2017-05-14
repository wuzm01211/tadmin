<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/14
 * Time: 21:45
 */

namespace app\admin\model;


use think\console\command\make\Model;
use think\Db;

class Operate extends Model
{
    private $table = 'sys_operate';

    public function dataList($map='',$filed='',$order='',$per_page=15,$option=[])
    {
        if(!$order) $order = 'sort desc';
        if($per_page){
            $data_list = Db::table($this->table)->where($map)->field($filed)->order($order)->paginate($per_page,false,$option);
        }else{
            $data_list = Db::table($this->table)->where($map)->field($filed)->order($order)->select();
        }
        if(empty($data_list)) return [];
        else return $data_list;
    }

    public function addOne($data)
    {
        if(!is_array($data)) return false;
        $flag = Db::table($this->table)->where(['title'=>$data['title']])->value('id');
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
        $fid = Db::table($this->table)->whereOr(['title'=>$data['title']])->value('id');
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

    public function getCount($map='')
    {
        return Db::table($this->table)->where($map)->count();
    }
}