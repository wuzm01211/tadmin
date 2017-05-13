<?php
/**
 * Created by PhpStorm.
 * User: wzm
 * Date: 2017/5/13
 * Time: 0:44
 * 后台模块基类
 */

namespace app\admin\controller;

use think\Controller;
use app\admin\controller\HBuilder;

class Base extends Controller
{
    protected $builder = '';

    public function __construct()
    {
        parent::__construct();
        if(!$this->builder){
            $this->builder = new HBuilder();
        }
    }
}