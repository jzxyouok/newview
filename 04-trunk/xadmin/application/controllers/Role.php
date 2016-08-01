<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/5/7
 * Time: 9:59
 * Email: 1056811341@qq.com
 */
class Role extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->template();
        $this->load->model('role_model', 'role');
    }

    //模板内容
    public function template()
    {
        $tpl['tpl_insert_btn'] = $this->common->set_auth(MYINSERT, $this->my_get_auth(), '<a href="' . site_url('role/insert?pid=' . $this->pid) . '" class="btn btn-default">新增角色</a>');
        $tpl['tpl_search_btn'] = '<button type="button" data-name="searchbtn" class="btn btn-default">搜索</button>';
        $tpl['tpl_update_url'] = site_url('role/update?pid=' . $this->pid);
        $tpl['tpl_get_list_url'] = site_url('role/get_list?pid=' . $this->pid);
        $tpl['tpl_save_url'] = site_url('role/save?pid=' . $this->pid);
        $this->load->vars($tpl);
    }

    public function index()
    {
        $this->common->set_auth(MYLOOK, $this->my_get_auth());
        $this->logs->add(MYLOOK);
        $this->load->view('role/index.html');
    }

    //获得列表
    public function get_list()
    {
        $data['list'] = $this->role->get_list();
        foreach ($data['list']['list'] as $key => $val) {
            if ($val['role_type']) {
                $data['list']['list'][$key]['auth_btn'] = '<a href="javascript:;" class="disabled">设置权限</a>';
                $data['list']['list'][$key]['update_btn'] = $this->common->set_auth(MYUPDATE, $this->my_get_auth(), '<a href="javascript:;" class="disabled">编辑</a>');
                $data['list']['list'][$key]['del_btn'] = $this->common->set_auth(MYDELETE, $this->my_get_auth(), '<a href="javascript:;" class="disabled">删除</a>');
            } else {
                $data['list']['list'][$key]['auth_btn'] = '<a href="' . site_url('role_auth?pid=' . $this->pid . '&rid=' . $val['id']) . '">设置权限</a>';
                $data['list']['list'][$key]['update_btn'] = $this->common->set_auth(MYUPDATE, $this->my_get_auth(), '<a href="' . site_url('role/update?pid=' . $this->pid . '&id=' . $val['id']) . '">编辑</a>');
                $data['list']['list'][$key]['del_btn'] = $this->common->set_auth(MYDELETE, $this->my_get_auth(), '<a href="javascript:;" data-name="del" data-tb="' . $this->config->item('role', 'tb') . '" data-id="' . $val['id'] . '" data-url="' . site_url('ajax/del?pid=' . $this->pid) . '">删除</a>');
            }
        }
        echo json_encode($data);
    }

    //新增
    public function insert()
    {
        $this->common->set_auth(MYINSERT, $this->my_get_auth());
        $this->logs->add(MYINSERT);
        $this->load->view('role/insert.html');
    }

    //更新
    public function update()
    {
        $this->common->set_auth(MYUPDATE, $this->my_get_auth());
        $this->logs->add(MYUPDATE);
        $data['item'] = $this->role->update();
        $this->load->view('role/update.html', $data);
    }

    //保存
    public function save()
    {
        $bool = $this->role->save();
        if ($bool) {
            switch ($this->is_save) {
                case '1':
                    $this->tip->show_success('操作成功！', site_url('role?pid=' . $this->pid));
                    break;
                case '2':
                    $this->tip->show_success('操作成功！', $this->peferer);
                    break;
            }
        } else {
            $this->tip->show_error('操作失败！', site_url('role?pid=' . $this->pid));
        }
    }

}