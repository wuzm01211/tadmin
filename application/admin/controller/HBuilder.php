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

    public $html_arr = [
        'type'=>'',
        'cols'=>[],
    ];

    public function build($type='')
    {
        switch($type){
            case 'table':
                $this->html_arr['type'] = 'table';
                return $this;
                break;
            case 'form':
                $this->html_arr['type'] = 'form';
                return $this;
                break;
            default:
                return $this;
        }
    }

    /**
     * 设置页面标题
     * @param $admin_title
     * @return $this
     */
    public function setTitle($admin_title)
    {
        $this->assign('admin_title',$admin_title);
        return $this;
    }

    /**
     * 设置表单url
     * @param $form_url
     * @return $this
     */
    public function setFormUrl($form_url)
    {
        $this->assign('form_url',$form_url);
        return $this;
    }

    /**
     * 设置表单method
     * @param $form_method
     * @return $this
     */
    public function setFormMethod($form_method)
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
            default:
                $enctype = 'text/plain';
        }
        $this->assign('enctype',$enctype);
        return $this;
    }


    /**
     * 添加表单项
     * @param $form_items
     * @return $this|bool
     */
    public function addFormItems($form_items)
    {
        if(!is_array($form_items)){
            return false;
        }
        $html = '';
        foreach($form_items as $val){
            switch($val['type']){
                case 'text':
                    $html.='<div class="form-group">';
                    $html.='<label for="'.$val['id'].'">'.$val['label'].'</label>';
                    $html.='<input type="text" class="form-control" name="'.$val['name'].'" id="'.$val['id'].'" placeholder="'.$val['placeholder'].'">';
                    $html.='</div>';
                    break;
                case 'password':
                    $html.='<div class="form-group">';
                    $html.='<label for="'.$val['id'].'">'.$val['label'].'</label>';
                    $html.='<input type="password" class="form-control" name="'.$val['name'].'" id="'.$val['id'].'" placeholder="'.$val['placeholder'].'">';
                    $html.='</div>';
                    break;
                case 'hidden':
                    $html.='<input type="hidden" name="'.$val['name'].'" id="'.$val['id'].'">';
                    break;
                case 'datetime':
                    $html.='<div class="form-group">';
                    $html.='<label for='.$val['id'].'>'.$val['label'].'</label>';
                    $html.='<input type="text" class="picker picker-datetime" data-date-format="yyyy-mm-dd hh:ii" name="'.$val['name'].'" id="'.$val['id'].'" placeholder="'.$val['placeholder'].'">';
                    $html.='</div>';
                    break;
                case 'date':
                    $html.='<div class="form-group">';
                    $html.='<label for='.$val['id'].'>'.$val['label'].'</label>';
                    $html.='<input class="picker picker-date" data-date-format="yyyy-mm-dd" type="text" name="'.$val['name'].'" id="'.$val['id'].'" placeholder="'.$val['placeholder'].'">';
                    $html.='</div>';
                    break;
                case 'time':
                    $html.='<div class="form-group">';
                    $html.='<label for='.$val['id'].'>'.$val['label'].'</label>';
                    $html.='<input type="text" class="picker picker-time" data-date-format="hh:ii" name="'.$val['name'].'" id="'.$val['id'].'" placeholder="'.$val['placeholder'].'">';
                    $html.='</div>';
                    break;
                case 'radio':
                    $html.='<div class="form-group">';
                    $html.='<label>'.$val['label'].'</label>';
                    $html.='<div class="radio admin-radio">';
                    foreach($val['data'] as $vo){
                        $html.='<label>';
                        $html.='<input type="radio" name="'.$val['name'].'[]" value="'.$vo['value'].'">'.$vo['title'];
                        $html.='</label>';
                    }
                    $html.='</div>';
                    $html.='</div>';
                    break;
                case 'file':
                    $html.='<div class="form-group">';
                    $html.='<label for="'.$val['label'].'">头像</label>';
                    $html.='<input type="file" name="'.$val['name'].'" id="'.$val['id'].'">';
                    $html.='</div>';
                    break;
                case 'select':
                    $html.='<div class="form-group">';
                    $html.='<label>'.$val['label'].'</label>';
                    $html.='<select name="'.$val['name'].'" class="form-control" id="'.$val['id'].'">';
                    $html.='<option>请选择</option>';
                    foreach($val['data'] as $vo){
                        $html.='<label>';
                        $html.='<option value="'.$vo['value'].'">'.$vo['title'].'</option>';
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
                        $html.='<tr>';
                        $html.='<td>'.$vo['label'].'</td>';
                        $html.='<td>';
                        foreach($vo['data'] as $v){
                            $html.='<div class="checkbox checkbox-inline">';
                            $html.='<label>';
                            $html.='<input type="checkbox" value="'.$v['value'].'" name="'.$vo['name'].'[]">'.$v['title'];
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
                    $html.='<div class="form-group">';
                    $html.='<label>'.$val['label'].'</label>';
                    $html.='<div >';
                    foreach($val['data'] as $vo){
                        $html.='<label class="checkbox-inline">';
                        $html.='<input type="checkbox" value="'.$vo['value'].'" name="'.$val['name'].'[]">'.$vo['title'];
                        $html.='</label>';
                    }
                    $html.='</div>';
                    $html.='</div>';
                    break;
                case 'textarea':
                    $html.='<div class="form-group">';
                    $html.='<label>'.$val['label'].'</label>';
                    $html.='<textarea id="'.$val['id'].'" name="'.$val['name'].'" style="width: '.$val['width'].';height: '.$val['height'].';"></textarea>';
                    $html.='</div>';
                    break;
            }
        }
        $this->assign('form_items',$html);
        return $this;
    }

    /**
     * 设置表单项
     * @param $form_items 表单元素
     * @param $form_data 表单数据
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
                    $html.='<div class="form-group">';
                    $html.='<label for="'.$val['id'].'">'.$val['label'].'</label>';
                    $html.='<input type="text" class="form-control" name="'.$val['name'].'" id="'.$val['id'].'" placeholder="'.$val['placeholder'].'" value="'.$form_data[$val['name']].'">';
                    $html.='</div>';
                    break;
                case 'password':
                    $html.='<div class="form-group">';
                    $html.='<label for="'.$val['id'].'">'.$val['label'].'</label>';
                    $html.='<input type="password" class="form-control" name="'.$val['name'].'" id="'.$val['id'].'" placeholder="'.$val['placeholder'].'" value="'.$form_data[$val['name']].'">';
                    $html.='</div>';
                    break;
                case 'hidden':
                    $html.='<input type="hidden" name="'.$val['name'].'" id="'.$val['id'].'" value="'.$form_data[$val['name']].'">';
                    break;
                case 'datetime':
                    $html.='<div class="form-group">';
                    $html.='<label for='.$val['id'].'>'.$val['label'].'</label>';
                    $html.='<input type="text" data-date-format="yyyy-mm-dd hh:ii" class="picker picker-datetime" name="'.$val['name'].'" id="'.$val['id'].'" value="'.date('Y-m-d H:i',$form_data[$val['name']]).'">';
                    $html.='</div>';
                    break;
                case 'date':
                    $html.='<div class="form-group">';
                    $html.='<label for='.$val['id'].'>'.$val['label'].'</label>';
                    $html.='<input data-date-format="yyyy-mm-dd" class="picker picker-date" type="text" name="'.$val['name'].'" id="'.$val['id'].'" value="'.date('Y-m-d',$form_data[$val['name']]).'">';
                    $html.='</div>';
                    break;
                case 'time':
                    $html.='<div class="form-group">';
                    $html.='<label for='.$val['id'].'>'.$val['label'].'</label>';
                    $html.='<input type="text" data-date-format="hh:ii" class="picker picker-time" name="'.$val['name'].'" id="'.$val['id'].'" placeholder="'.$form_data[$val['name']].'">';
                    $html.='</div>';
                    break;
                case 'radio':
                    $html.='<div class="form-group">';
                    $html.='<label>'.$val['label'].'</label>';
                    $html.='<div class="radio admin-radio">';
                    foreach($val['data'] as $vo){
                        $html.='<label>';
                        if($form_data[$val['name']]==$vo['value']){
                            $html.='<input type="radio" name="'.$val['name'].'[]" value="'.$vo['value'].'" checked="checked">'.$vo['title'];
                        }else{
                            $html.='<input type="radio" name="'.$val['name'].'[]" value="'.$vo['value'].'">'.$vo['title'];
                        }
                        $html.='</label>';
                    }
                    $html.='</div>';
                    $html.='</div>';
                    break;
                case 'file':
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
                    $html.='<div class="form-group">';
                    $html.='<label>'.$val['label'].'</label>';
                    $html.='<select name="'.$val['name'].'" class="form-control" id="'.$val['id'].'">';
                    $html.='<option>请选择</option>';
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



}