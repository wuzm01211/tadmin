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
    private $table_name = 'sys_operate';

    public function dataList($map='',$filed='',$order='',$per_page=15,$option=[])
    {
        if(!$order) $order = 'sort desc';
        if($per_page){
            $data_list = Db::table($this->table_name)->where($map)->field($filed)->order($order)->paginate($per_page,false,$option);
        }else{
            $data_list = Db::table($this->table_name)->where($map)->field($filed)->order($order)->select();
        }
        if(empty($data_list)) return [];
        else return $data_list;
    }

    public function addOne($data)
    {
        if(!is_array($data)) return false;
        if(!$data['pid']) $data['pid'] = 0;
        $flag = Db::table($this->table_name)->whereOr(['title'=>$data['title'],'code'=>$data['code']])->value('id');
        if($flag) return false;
        $id = Db::table($this->table_name)->insert($data);
        if($id) return $id;
        else return false;
    }

    public function updateOne($data,$id)
    {
        if(!is_array($data)) return false;
        if(!$data['pid']) $data['pid'] = 0;
        $id = intval($id);
        $fid = Db::table($this->table_name)->whereOr(['title'=>$data['title'],'code'=>$data['code']])->value('id');
        if($fid!=$id) return false;
        $rid = Db::table($this->table_name)->where(['id'=>$id])->update($data);
        if($rid) return $rid;
        else return false;
    }

    public function getOne($map,$field='*')
    {
        if(!$map) return false;
        return Db::table($this->table_name)->where($map)->field($field)->find();
    }

    public function delOne($map){
        if(!$map) return false;
        return Db::table($this->table_name)->where($map)->limit(1)->delete();
    }

    public function getCount($map='')
    {
        return Db::table($this->table_name)->where($map)->count();
    }
}