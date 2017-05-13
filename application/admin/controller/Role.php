<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/13
 * Time: 0:43
 */

namespace app\admin\controller;


class Role extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    public function add()
    {
        return $this->builder->build('form')
            ->setTitle('添加角色')
            ->setFormMethod('post')
            ->setFormUrl(url('addData'))
            ->setFormType('multipart')
            ->addFormItems([
                ['type'=>'text','label'=>'角色名','name'=>'role_name','id'=>'role_name','placeholder'=>'请输入角色名'],
                ['type'=>'password','label'=>'密码','name'=>'pwd','id'=>'pwd','placeholder'=>'请输入密码'],
                ['type'=>'time','label'=>'时间','name'=>'time','id'=>'time','placeholder'=>''],
                ['type'=>'date','label'=>'创建日期','name'=>'create_date','id'=>'create_date','placeholder'=>''],
                ['type'=>'datetime','label'=>'创建时间','name'=>'create_time','id'=>'create_time','placeholder'=>''],
                ['type'=>'radio','label'=>'状态','name'=>'status','id'=>'status',
                    'data'=>[
                        ['value'=>1,'title'=>'启用'],
                        ['value'=>0,'title'=>'禁用'],
                        ['value'=>-1,'title'=>'待审核']
                    ]
                ],
                ['type'=>'file','label'=>'头像','name'=>'role_icon','id'=>'role_icon'],
                ['type'=>'select','label'=>'类型','name'=>'type','id'=>'type',
                    'data'=>[
                        ['value'=>1,'title'=>'超级管理员'],
                        ['value'=>2,'title'=>'中级管理员'],
                        ['value'=>3,'title'=>'普通管理员'],
                    ]
                ],
                ['type'=>'table_checkbox','label'=>'权限',
                    'th'=>[
                        ['width'=>'20%','title'=>'操作'],
                        ['width'=>'80%','title'=>'动作'],
                    ],
                    'td'=>[
                        ['label'=>'角色管理','name'=>'role','data'=>[
                            ['value'=>1,'title'=>'查看'],
                            ['value'=>2,'title'=>'添加'],
                            ['value'=>3,'title'=>'修改'],
                        ]]
                    ]
                ],
                ['type'=>'checkbox','label'=>'多选','name'=>'checkbox','data'=>[
                    ['value'=>0,'title'=>'推荐'],
                    ['value'=>1,'title'=>'热门'],
                    ['value'=>2,'title'=>'精品'],
                    ['value'=>3,'title'=>'新品'],
                ]],
                ['type'=>'textarea','label'=>'摘要','id'=>'abstract','name'=>'abstract','width'=>'100%','height'=>'100px'],
                ['type'=>'textarea','label'=>'内容','id'=>'content','name'=>'content','width'=>'100%','height'=>'200px'],

            ])
            ->fetch('hbuilder:add');
    }

    public function edit()
    {
        return $this->builder->build('form')
            ->setTitle('添加角色')
            ->setFormMethod('post')
            ->setFormUrl(url('addData'))
            ->setFormType('multipart')
            ->setFormItems([
                ['type'=>'text','label'=>'角色名','name'=>'role_name','id'=>'role_name','placeholder'=>'请输入角色名'],
                ['type'=>'password','label'=>'密码','name'=>'pwd','id'=>'pwd','placeholder'=>'请输入密码'],
                ['type'=>'time','label'=>'时间','name'=>'time','id'=>'time','placeholder'=>''],
                ['type'=>'date','label'=>'创建日期','name'=>'create_date','id'=>'create_date','placeholder'=>''],
                ['type'=>'datetime','label'=>'创建时间','name'=>'create_time','id'=>'create_time','placeholder'=>''],
                ['type'=>'radio','label'=>'状态','name'=>'status','id'=>'status',
                    'data'=>[
                        ['value'=>1,'title'=>'启用'],
                        ['value'=>0,'title'=>'禁用'],
                        ['value'=>-1,'title'=>'待审核']
                    ]
                ],
                ['type'=>'file','label'=>'头像','name'=>'role_icon','id'=>'role_icon'],
                ['type'=>'select','label'=>'类型','name'=>'type','id'=>'type',
                    'data'=>[
                        ['value'=>1,'title'=>'超级管理员'],
                        ['value'=>2,'title'=>'中级管理员'],
                        ['value'=>3,'title'=>'普通管理员'],
                    ]
                ],
                ['type'=>'table_checkbox','label'=>'权限',
                    'th'=>[
                        ['width'=>'20%','title'=>'操作'],
                        ['width'=>'80%','title'=>'动作'],
                    ],
                    'td'=>[
                        ['label'=>'角色管理','name'=>'role','data'=>[
                            ['value'=>1,'title'=>'查看'],
                            ['value'=>2,'title'=>'添加'],
                            ['value'=>3,'title'=>'修改'],
                        ]]
                    ]
                ],
                ['type'=>'checkbox','label'=>'多选','name'=>'checkbox','data'=>[
                    ['value'=>0,'title'=>'推荐'],
                    ['value'=>1,'title'=>'热门'],
                    ['value'=>2,'title'=>'精品'],
                    ['value'=>3,'title'=>'新品'],
                ]],
                ['type'=>'textarea','label'=>'摘要','id'=>'abstract','name'=>'abstract','width'=>'100%','height'=>'100px'],
                ['type'=>'textarea','label'=>'内容','id'=>'content','name'=>'content','width'=>'100%','height'=>'200px'],

            ],[
                'role_name'=>'张三',
                'pwd'=>'ddsdfffs',
                'time'=>'20:35',
                'create_date'=>'1465121000',
                'create_time'=>'1465121650',
                'status'=>'1',
                'role_icon'=>'/static/images/b1.png',
                'type'=>'1',
                'role'=>[1,3],
                'checkbox'=>[0,2],
                'abstract'=>'摘要测试',
                'content'=>'内容测试',
            ])
            ->fetch('hbuilder:edit');
    }

    public function addData()
    {
        return dump($_POST);
    }
}