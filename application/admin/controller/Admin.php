<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/13
 * Time: 0:16
 */

namespace app\admin\controller;

class Admin extends Base
{
    public function index()
    {
        return $this->fetch();
    }
}