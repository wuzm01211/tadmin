<?php
use think\Db;
function get_menu($map=['pid'=>0],$filed='id,pid,title,url,icon,sort,code',$order='sort desc')
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

function get_menu_arr($map='',$order='sort desc'){
    $menu_arr = Db::table('sys_operate')->where($map)->order($order)->column('title','id');
    $menu_arr[0]='顶级菜单';
    return $menu_arr;
}

function get_permission_menu($map='o.pid=0'){
    $user = session('user');
    $map.=' and p.role_id='.$user['role_id'];
    $sql = 'select distinct o.id,o.pid,o.title,o.url,o.icon,o.sort,o.code from sys_operate o
            join sys_permission p on '.$map.' and p.op_id=o.id and p.ac_id=1 order by o.sort desc';
    return Db::query($sql);
}

function get_permission_menu_tree($map='o.pid=0')
{
    $pid_arr = get_permission_menu($map);
    $menu_tree = [];
    foreach($pid_arr as &$val){
        $val['child_menu'] = get_permission_menu('o.pid='.$val['id']);
        $menu_tree[] = $val;
    }
    return $menu_tree;
}

function get_menu_open($pid){
    $request = request();
    $controller = strtolower($request->controller());
    $db_pid = Db::table('sys_operate')->where(['code'=>$controller])->value('pid');
    if($db_pid==$pid) return true;
    else return false;
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

function get_button($pos='top_button',$convert=1)
{
    $user = session('user');
    $role_id = intval($user['role_id']);
    $request = request();
    $controller = strtolower($request->controller());
    $sql = "select a.type,a.action,a.title,a.code from sys_permission p
            join sys_operate o on o.code='$controller' and p.op_id=o.id and p.role_id=$role_id
            join sys_action a on a.id=p.ac_id and a.pos LIKE '%$pos%' order by a.sort desc";
    $buttons = Db::query($sql);
    $row = [];
    if($convert){
        foreach($buttons as $val){
            $val['url'] = url($val['code']);
            $row[$val['code']] = $val;
        }
    }else{
        foreach($buttons as $val){
            $row[$val['code']] = $val;
        }
    }
    return $row;
}

function get_role_arr($map = '',$field='id,role_name')
{
    return Db::table('sys_role')->where($map)->field($field)->select();
}

function is_login()
{
    $user = session('user');
    if($user){
        $auth = $user['auth'];
        unset($user['auth']);
        ksort($user);
        $check_auth = md5(http_build_query($user).'&key='.config('admin_key'));
        if($check_auth==$auth) return true;
        else return false;
    }else {
        return false;
    }
}

function check_permission()
{
    $user = session('user');
    $role_id = $user['role_id'];
    if(!$role_id) return false;
    $request = request();
    $model = $request->module();
    $controller = strtolower($request->controller());
    $action = $request->action();
    $code = strtolower($model.'/'.$controller.'/'.$action);
    $op_id = Db::table('sys_operate')->where(['code'=>$controller])->value("id");
    if(!$op_id) return false;
    $ac_id = Db::table('sys_action')->where(['code'=>$code])->value('id');
    if(!$ac_id) return false;
    $permission = Db::table('sys_permission')->where(['role_id'=>$role_id,'op_id'=>$op_id,'ac_id'=>$ac_id])->value('id');
    if($permission) return true;
    else return false;
}

function get_url()
{
    $request = request();
    $model = $request->module();
    $controller = $request->controller();
    $action = $request->action();
    return strtolower($model.'/'.$controller.'/'.$action);
}
