<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/16
 * Time: 14:37
 */

namespace app\admin\controller;


use think\Controller;
use think\Db;

class Login extends Controller
{
    public function index()
    {
        if(is_login()){
            $this->redirect(url('admin/index/index'));
            return false;
        }else{
            return $this->fetch();
        }
    }

    public function login()
    {
        $account = input('post.account');
        $pwd = input('post.pwd');

        if(!$account||!$pwd){
            $this->error('用户名或密码为空');
        }

        $user = Db::table('sys_admin')
            ->where(['account'=>$account,'pwd'=>md5($pwd),'status'=>1])
            ->field('id,role_id,account')->find();

        $role = Db::table('sys_role')
            ->where(['id'=>$user['role_id'],'status'=>1])
            ->value('id');
        if(!$role){
            $this->error('登录失败，角色已被禁用');
        }

        if($user){
            $login_data = [];
            $login_data['last_time'] = time();
            $login_data['last_ip'] = input('server.REMOTE_ADDR');
            Db::table('sys_admin')->where(['id'=>$user['id']])->update($login_data);
            ksort($user);
            $user['auth'] = md5(http_build_query($user).'&key='.config('admin_key'));
            session('user',$user);
            $this->success('登录成功',url('admin/index/index'));
        }else{
            $this->error('登录失败，密码错误或账号已被禁用');
        }
    }

    public function logout()
    {
        if(is_login()){
            session('user',null);
        }
        $this->redirect(url('index'));
    }
}