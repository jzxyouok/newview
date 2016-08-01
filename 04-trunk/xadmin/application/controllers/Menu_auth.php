<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/5/7
 * Time: 9:59
 * Email: 1056811341@qq.com
 */
class Menu_auth extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->template();
        $this->load->model('menu_auth_model', 'menu_auth');
    }

    //模板内容
    public function template()
    {
        $tpl['tpl_insert_btn'] = $this->common->set_auth(MYINSERT, $this->my_get_auth(), '<a href="' . site_url('menu_auth/insert?pid=' . $this->pid) . '" class="btn btn-default">新增权限</a>');
        $tpl['tpl_search_btn'] = $this->common->set_auth(MYLOOK, $this->my_get_auth(), '<button type="button" data-name="searchbtn" class="btn btn-default">搜索</button>');
        $tpl['tpl_update_url'] = site_url('menu_auth/update?pid=' . $this->pid);
        $tpl['tpl_get_list_url'] = site_url('menu_auth/get_list?pid=' . $this->pid);
        $tpl['tpl_save_url'] = site_url('menu_auth/save?pid=' . $this->pid);
        $this->load->vars($tpl);
    }

    public function index()
    {
        $this->common->set_auth(MYLOOK, $this->my_get_auth());
        $this->logs->add(MYLOOK);
        $this->load->view('menu_auth/index.html');
    }

    //获得列表
    public function get_list()
    {
        $data['list'] = $this->menu_auth->get_list();
        foreach ($data['list']['list'] as $key => $val) {
            $data['list']['list'][$key]['update_btn'] = '<a href="' . site_url('menu_auth/update?pid=' . $this->pid . '&id=' . $val['id']) . '">编辑</a>';
            $data['list']['list'][$key]['del_btn'] = '<a href="javascript:;" data-name="del" data-tb="' . $this->config->item('menu_auth', 'tb') . '" data-id="' . $val['id'] . '" data-url="' . site_url('ajax/del') . '">删除</a>';
        }
        echo json_encode($data);
    }

    //新增
    public function insert()
    {
        $this->common->set_auth(MYINSERT, $this->my_get_auth());
        $this->logs->add(MYINSERT);
        $this->load->view('menu_auth/insert.html');
    }

    //更新
    public function update()
    {
        $this->common->set_auth(MYUPDATE, $this->my_get_auth());
        $this->logs->add(MYUPDATE);
        $data['item'] = $this->menu_auth->update();
        $this->load->view('menu_auth/update.html', $data);
    }

    //保存
    public function save()
    {
        $bool = $this->menu_auth->save();
        if ($bool) {
            switch ($this->is_save) {
                case '1':
                    $this->tip->show_success('操作成功！', site_url('menu_auth?pid=' . $this->pid));
                    break;
                case '2':
                    $this->tip->show_success('操作成功！', $this->peferer);
                    break;
            }
        } else {
            $this->tip->show_error('操作失败！', site_url('menu_auth?pid=' . $this->pid));
        }
    }

}