<?php

function get_menu($map=['pid'=>0],$filed='id,pid,title,url,icon,sort',$order='sort desc')
{
    return \think\Db::table('sys_operate')->where($map)->field($filed)->order($order)->select();
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
    return \think\Db::table('sys_action')->where($map)->field($filed)->order($order)->select();
}