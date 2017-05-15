<?php
use think\Db;
function get_menu($map=['pid'=>0],$filed='id,pid,title,url,icon,sort',$order='sort desc')
{
    return Db::table('sys_operate')->where($map)->field($filed)->order($order)->select();
}

function get_menu_tree($map=['pid'=>0])
{
    $pid_arr = get_menu($map);
    $menu_tree = [];
    foreach($pid_arr as &$val){
        $val['child_menu'] = get_menu(['pid'=>$val['id']]);
        $menu_tree[] = $val;
    }
    return $menu_tree;
}

function get_action($map='',$filed='*',$order='id desc')
{
    return Db::table('sys_action')->where($map)->field($filed)->order($order)->select();
}

function get_permission($map='',$field='*',$order='id desc')
{
    return Db::table('sys_permission')
        ->where($map)
        ->field($field)
        ->order($order)
        ->select();
}

function get_button()
{
    $user = cookie('user');
    $role_id = intval($user['role_id']);
    $request = request();
    $controller = strtolower($request->controller());
    $sql = "select a.* from sys_permission p join sys_operate o on o.code='$controller' and p.op_id=o.id and p.role_id=$role_id join sys_action a on a.id=p.ac_id";
    dump(Db::query($sql));
}