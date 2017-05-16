<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/13
 * Time: 8:55
 */

namespace app\admin\controller;


use think\Controller;

class HBuilder extends Controller
{
    /**
     * 设置页面标题
     * @param $admin_title
     * @return $this
     */
    public function setTitle($admin_title='')
    {
        $this->assign('admin_title',$admin_title);
        return $this;
    }

    /**
     * 设置表单url
     * @param $form_url
     * @return $this
     */
    public function setFormUrl($form_url='')
    {
        $this->assign('form_url',$form_url);
        return $this;
    }

    /**
     * 设置表单method
     * @param $form_method
     * @return $this
     */
    public function setFormMethod($form_method='get')
    {
        $this->assign('form_method',$form_method);
        return $this;
    }

    /**
     * 设置表单enctype
     * @param string $enctype
     * @return $this
     */
    public function setFormType($enctype='')
    {
        switch($enctype){
            case 'application':
                $enctype = 'application/x-www-form-urlencoded';
                break;
            case 'multipart':
                $enctype = 'multipart/form-data';
                break;
            case 'text':
                $enctype = 'text/plain';
                break;
            default:
                $enctype = 'application/x-www-form-urlencoded';
        }
        $this->assign('enctype',$enctype);
        return $this;
    }

    /**
     * 设置表单项
     * @param Array $form_items 表单元素
     * @param Array $form_data 表单数据
     * @return $this|bool 返回值 错误返回false 正确返回本对象句柄
     */
    public function setFormItems($form_items,$form_data)
    {
        if(!is_array($form_items)){
            return false;
        }
        $html = '';
        foreach($form_items as $val){
            switch($val['type']){
                case 'text':
                    if(!isset($form_data[$val['name']])) $form_data[$val['name']] = '';
                    $html.='<div class="form-group">';
                    $html.='<label for="'.$val['id'].'">'.$val['label'].'</label>';
                    $html.='<input type="text" class="form-control" name="'.$val['name'].'" id="'.$val['id'].'" placeholder="'.$val['placeholder'].'" value="'.$form_data[$val['name']].'">';
                    $html.='</div>';
                    break;
                case 'password':
                    if(!isset($form_data[$val['name']])) $form_data[$val['name']] = '';
                    $html.='<div class="form-group">';
                    $html.='<label for="'.$val['id'].'">'.$val['label'].'</label>';
                    $html.='<input type="password" class="form-control" name="'.$val['name'].'" id="'.$val['id'].'" placeholder="'.$val['placeholder'].'" value="'.$form_data[$val['name']].'">';
                    $html.='</div>';
                    break;
                case 'hidden':
                    if(!isset($form_data[$val['name']])) $form_data[$val['name']] = '';
                    $html.='<input type="hidden" name="'.$val['name'].'" id="'.$val['id'].'" value="'.$form_data[$val['name']].'">';
                    break;
                case 'datetime':
                    if(!isset($form_data[$val['name']])) $form_data[$val['name']] = '';
                    if($form_data[$val['name']]) $form_data[$val['name']] = date('Y-m-d H:i',$form_data[$val['name']]);
                    $html.='<div class="form-group">';
                    $html.='<label for='.$val['id'].'>'.$val['label'].'</label>';
                    $html.='<input type="text" data-date-format="yyyy-mm-dd hh:ii" class="picker picker-datetime" name="'.$val['name'].'" id="'.$val['id'].'" value="'.$form_data[$val['name']].'">';
                    $html.='</div>';
                    break;
                case 'date':
                    if(!isset($form_data[$val['name']])) $form_data[$val['name']] = '';
                    if($form_data[$val['name']]) $form_data[$val['name']] = date('Y-m-d',$form_data[$val['name']]);
                    $html.='<div class="form-group">';
                    $html.='<label for='.$val['id'].'>'.$val['label'].'</label>';
                    $html.='<input data-date-format="yyyy-mm-dd" class="picker picker-date" type="text" name="'.$val['name'].'" id="'.$val['id'].'" value="'.$form_data[$val['name']].'">';
                    $html.='</div>';
                    break;
                case 'time':
                    if(!isset($form_data[$val['name']])) $form_data[$val['name']] = '';
                    $html.='<div class="form-group">';
                    $html.='<label for='.$val['id'].'>'.$val['label'].'</label>';
                    $html.='<input type="text" data-date-format="hh:ii" class="picker picker-time" name="'.$val['name'].'" id="'.$val['id'].'" placeholder="'.$form_data[$val['name']].'">';
                    $html.='</div>';
                    break;
                case 'radio':
                    if(!isset($form_data[$val['name']])) $form_data[$val['name']] = '';
                    $html.='<div class="form-group">';
                    $html.='<label>'.$val['label'].'</label>';
                    $html.='<div class="radio admin-radio">';
                    foreach($val['data'] as $vo){
                        $html.='<label>';
                        if($form_data[$val['name']]==$vo['value']){
                            $html.='<input type="radio" name="'.$val['name'].'" value="'.$vo['value'].'" checked="checked">'.$vo['title'];
                        }else{
                            $html.='<input type="radio" name="'.$val['name'].'" value="'.$vo['value'].'">'.$vo['title'];
                        }
                        $html.='</label>';
                    }
                    $html.='</div>';
                    $html.='</div>';
                    break;
                case 'file':
                    if(!isset($form_data[$val['name']])) $form_data[$val['name']] = '';
                    $html.='<div class="form-group">';
                    $html.='<label for="'.$val['label'].'">头像</label>';
                    $html.='<input type="file" name="'.$val['name'].'" id="'.$val['id'].'">';
                    $html.='</div>';
                    if($form_data[$val['name']]){
                        $html.='<div class="form-group">';
                        $html.='<input type="hidden" name="'.$val['name'].'" value="'.$form_data[$val['name']].'">';
                        $html.='<img src="'.$form_data[$val['name']].'" style="height:40px;"/>';
                        $html.='</div>';
                    }
                    break;
                case 'select':
                    if(!isset($form_data[$val['name']])) $form_data[$val['name']] = '';
                    $html.='<div class="form-group">';
                    $html.='<label>'.$val['label'].'</label>';
                    $html.='<select name="'.$val['name'].'" class="form-control" id="'.$val['id'].'">';
                    $html.='<option value="">请选择</option>';
                    foreach($val['data'] as $vo){
                        $html.='<label>';
                        if($form_data[$val['name']]==$vo['value']){
                            $html.='<option value="'.$vo['value'].'" selected="selected">'.$vo['title'].'</option>';
                        }else{
                            $html.='<option value="'.$vo['value'].'">'.$vo['title'].'</option>';
                        }
                        $html.='</label>';
                    }
                    $html.='</select>';
                    $html.='</div>';
                    break;
                case 'table_checkbox':
                    $html.='<div class="form-group">';
                    $html.='<label>'.$val['label'].'</label>';
                    $html.='<table class="table table-bordered" style="margin-bottom: 0;">';
                    $html.='<tr>';
                    foreach($val['th'] as $vo){
                        $html.='<th width="'.$vo['width'].'">'.$vo['title'].'</th>';
                    }
                    $html.='</tr>';
                    foreach($val['td'] as $vo){
                        if(!isset($form_data[$vo['name']])) $form_data[$vo['name']] = [];
                        $html.='<tr>';
                        $html.='<td>'.$vo['label'].'</td>';
                        $html.='<td>';
                        foreach($vo['data'] as $v){
                            $html.='<div class="checkbox checkbox-inline">';
                            $html.='<label>';
                            if(in_array($v['value'],$form_data[$vo['name']])){
                                $html.='<input type="checkbox" value="'.$v['value'].'" name="'.$vo['name'].'[]" checked="checked">'.$v['title'];
                            }else{
                                $html.='<input type="checkbox" value="'.$v['value'].'" name="'.$vo['name'].'[]">'.$v['title'];
                            }
                            $html.='</label>';
                            $html.='</div>';
                        }
                        $html.='</td>';
                        $html.='</tr>';
                    }
                    $html.='</table>';
                    $html.='</div>';
                    break;
                case 'checkbox':
                    if(!isset($form_data[$val['name']])) $form_data[$val['name']] = [];
                    $html.='<div class="form-group">';
                    $html.='<label>'.$val['label'].'</label>';
                    $html.='<div >';
                    foreach($val['data'] as $vo){
                        $html.='<label class="checkbox-inline">';
                        if(in_array($vo['value'],$form_data[$val['name']])){
                            $html.='<input type="checkbox" value="'.$vo['value'].'" name="'.$val['name'].'[]" checked="checked">'.$vo['title'];
                        }else{
                            $html.='<input type="checkbox" value="'.$vo['value'].'" name="'.$val['name'].'[]">'.$vo['title'];
                        }
                        $html.='</label>';
                    }
                    $html.='</div>';
                    $html.='</div>';
                    break;
                case 'textarea':
                    if(!isset($form_data[$val['name']])) $form_data[$val['name']] = '';
                    $html.='<div class="form-group">';
                    $html.='<label>'.$val['label'].'</label>';
                    $html.='<textarea id="'.$val['id'].'" name="'.$val['name'].'" style="width: '.$val['width'].';height: '.$val['height'].';">'.$form_data[$val['name']].'</textarea>';
                    $html.='</div>';
                    break;
            }
        }
        $this->assign('form_items',$html);
        return $this;
    }

    /**
     * 设置 顶部动作按钮
     * 按钮类型 type: default,primary,info,success,warning,danger
     * 按钮链接 url
     * 按钮标题 title
     * 动作 action 值redirect 直接跳转 值confirm 弹出对话框
     * @param $top_buttons
     * @return $this
     */
    public function setTopButtons($top_buttons='')
    {
        if(!is_array($top_buttons)){
            $this->assign('top_buttons','');
        }else{
            $html = '';
            foreach($top_buttons as $val){
                $html.='<button class="top-action btn btn-'.$val['type'].'" data-action="'.$val['action'].'" data-url="'.$val['url'].'" data-tips="'.$val['title'].'">'.$val['title'].'</button> ';
            }
            $this->assign('top_buttons',$html);
        }
        return $this;
    }

    /**
     * 设置搜索
     * @param string $form_items
     * @param string $form_data
     * @return $this
     */
    public function setSearchForm($form_items='',$form_data='')
    {
        if(!is_array($form_items)){
            $this->assign('form_items','');
        }else{
            $html = '';
            foreach($form_items as $val){
                if(!isset($form_data[$val['name']])) $form_data[$val['name']] = '';
                switch($val['type']){
                    case 'text':
                        $html.='<div class="form-group">';
                        $html.='<label for="'.$val['id'].'">'.$val['label'].'</label>';
                        $html.='<input type="text" class="form-control" name="'.$val['name'].'" id="'.$val['id'].'" placeholder="'.$val['placeholder'].'" value="'.$form_data[$val['name']].'">';
                        $html.='</div> ';
                        break;
                    case 'datetime':
                        if($form_data[$val['name']]) $form_data[$val['name']] = date('Y-m-d H:i',$form_data[$val['name']]);
                        $html.='<div class="form-group">';
                        $html.='<label for='.$val['id'].'>'.$val['label'].'</label>';
                        $html.='<input type="text" data-date-format="yyyy-mm-dd hh:ii" class="inline-picker picker-datetime" name="'.$val['name'].'" id="'.$val['id'].'" value="'.$form_data[$val['name']].'">';
                        $html.='</div> ';
                        break;
                    case 'date':
                        if($form_data[$val['name']]) $form_data[$val['name']] = date('Y-m-d',$form_data[$val['name']]);
                        $html.='<div class="form-group">';
                        $html.='<label for='.$val['id'].'>'.$val['label'].'</label>';
                        $html.='<input data-date-format="yyyy-mm-dd" class="inline-picker picker-date" type="text" name="'.$val['name'].'" id="'.$val['id'].'" value="'.$form_data[$val['name']].'">';
                        $html.='</div> ';
                        break;
                    case 'select':
                        $html.='<div class="form-group">';
                        $html.='<label>'.$val['label'].'</label>';
                        $html.='<select name="'.$val['name'].'" class="form-control" id="'.$val['id'].'">';
                        $html.='<option value="">请选择</option>';
                        foreach($val['data'] as $vo){
                            $html.='<label>';
                            if($form_data[$val['name']]==$vo['value']){
                                $html.='<option value="'.$vo['value'].'" selected="selected">'.$vo['title'].'</option>';
                            }else{
                                $html.='<option value="'.$vo['value'].'">'.$vo['title'].'</option>';
                            }
                            $html.='</label>';
                        }
                        $html.='</select>';
                        $html.='</div> ';
                        break;
                }
            }
            if($html){
                $html.='<button type="submit" class="btn btn-primary"><i class="fa fa-search">&nbsp;</i>搜索</button>';
            }
            $this->assign('form_items',$html);
        }
        return $this;
    }

    /**
     * 设置表格表头
     * @param array $t_head 一维数组
     * @return $this|bool $t_head不是数组则返回false，否则返回本对象句柄
     */
    public function setTHead($t_head)
    {
        if(!is_array($t_head)) return false;
        $html = '';
        $html.='<tr>';
        $html.='<th><input type="checkbox" id="check-all"></th>';
        foreach($t_head as $val){
            $html.='<th>'.$val.'</th>';
        }
        $this->assign('t_head',$html);
        return $this;
    }

    /**
     * 设置表格数据
     * @param array $data_list
     * @param array $data_items
     * @return $this|bool $data_list不是数组则返回false，否则返回本对象句柄
     */
    public function setTBody($data_list=[],$data_items)
    {
        if(!is_array($data_list)||!is_array($data_items)) return false;
        $html = '';
        if(empty($data_list)){
            $html.='<tr><td style="text-align: center;padding: 30px;color: #888;" colspan="'.(count($data_items)+1).'">暂无数据</td></tr>';
        }else{
            foreach($data_list as $val){
                $html.='<tr>';
                $html.='<td><input class="data-check" type="checkbox" value="'.$val['id'].'" name="check_arr[]"></td>';
                foreach($data_items as $vo){
                    $html.='<td>';
                    if($vo=='right_button'){
                        $html.='<div class="btn-group-xs" role="group" aria-label="content-action">';
                        foreach($val['right_button'] as $btn){
                            $html.=' <button class="action btn btn-'.$btn['type'].'" data-action="'.$btn['action'].'" data-url="'.$btn['url'].'" data-tips="'.$btn['title'].'">'.$btn['title'].'</button>';
                        }
                        $html.='</div>';
                    }else if(strpos($vo,'time')){
                        $html.= date('Y-m-d',$val[$vo]);
                    }else{
                        $html.= $val[$vo];
                    }
                    $html.='</td>';
                }
                $html.='</tr>';
            }
        }
        $this->assign('t_body',$html);
        return $this;
    }

}