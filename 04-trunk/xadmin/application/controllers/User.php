<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/5/7
 * Time: 9:59
 * Email: 1056811341@qq.com
 */
class User extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->template();
        $this->load->model('user_model', 'user');
    }

    //模板内容
    public function template()
    {
        $tpl['tpl_insert_btn'] = $this->common->set_auth(MYINSERT, $this->my_get_auth(), '<a href="' . site_url('user/insert?pid=' . $this->pid) . '" class="btn btn-default">新增管理员</a>');
        $tpl['tpl_search_btn'] = '<button type="button" data-name="searchbtn" class="btn btn-default">搜索</button>';
        $tpl['tpl_update_url'] = site_url('user/update?pid=' . $this->pid);
        $tpl['tpl_get_list_url'] = site_url('user/get_list?pid=' . $this->pid);
        $tpl['tpl_save_url'] = site_url('user/save?pid=' . $this->pid);
        $tpl['tpl_check_username_exists_url'] = site_url('user/check_username_exists');
        $this->load->vars($tpl);
    }

    public function index()
    {
        $this->common->set_auth(MYLOOK, $this->my_get_auth());
        $this->logs->add(MYLOOK);
        $this->load->view('user/index.html');
    }

    //获得列表
    public function get_list()
    {
        $data['list'] = $this->user->get_list();
        foreach ($data['list']['list'] as $key => $val) {
            $data['list']['list'][$key]['is_forzen'] = $this->common->set_state($val['forzen'], array(array('冻结', 'red'), array('正常', 'green')));
            $data['list']['list'][$key]['update_btn'] = $this->common->set_auth(MYUPDATE, $this->my_get_auth(), '<a href="' . site_url('user/update?pid=' . $this->pid . '&id=' . $val['id']) . '">编辑</a>');
            if ($val['root']) {
                $data['list']['list'][$key]['del_btn'] = $this->common->set_auth(MYDELETE, $this->my_get_auth(), '<a href="javascript:;" class="disabled">删除</a>');
            } else {
                $data['list']['list'][$key]['del_btn'] = $this->common->set_auth(MYDELETE, $this->my_get_auth(), '<a href="javascript:;" data-name="del" data-tb="' . $this->config->item('user', 'tb') . '" data-id="' . $val['id'] . '" data-url="' . site_url('ajax/del?pid=' . $this->pid) . '">删除</a>');
            }
        }
        echo json_encode($data);
    }

    //新增
    public function insert()
    {
        $this->common->set_auth(MYINSERT, $this->my_get_auth());
        $this->logs->add(MYINSERT);
        $data['role_option'] = $this->get_role_option();
        $this->load->view('user/insert.html', $data);
    }

    //更新
    public function update()
    {
        $this->common->set_auth(MYUPDATE, $this->my_get_auth());
        $this->logs->add(MYUPDATE);
        $data['item'] = $this->user->update();
        $data['role_option'] = $this->get_role_option($data['item']['role_id']);
        $data['forzen_checked'] = $this->common->checked(0, $data['item']['forzen']);
        $data['disabled'] = ($data['item']['root']) ? 'disabled' : '';
        $this->load->view('user/update.html', $data);
    }

    //保存
    public function save()
    {
        $bool = $this->user->save();
        if ($bool) {
            switch ($this->is_save) {
                case '1':
                    $this->tip->show_success('操作成功！', site_url('user?pid=' . $this->pid));
                    break;
                case '2':
                    $this->tip->show_success('操作成功！', $this->peferer);
                    break;
            }
        } else {
            $this->tip->show_error('操作失败！', site_url('user?pid=' . $this->pid));
        }
    }

    /**
     * 获得角色下拉菜单列表
     * @param string $role_id 选中标识
     * @return string
     */
    public function get_role_option($role_id = '')
    {
        $result = $this->user->role();
        $html = '';
        $selected = '';
        foreach ($result as $val) {
            if ($role_id != '') {
                $selected = $this->common->selected($val['id'], $role_id);
            }
            $html .= '<option value="' . $val['id'] . '" ' . $selected . '>' . $val['name'] . '</option>';
        }
        return $html;
    }

    //验证用户名是否存在
    public function check_username_exists()
    {
        $rows = $this->user->check_username_exists();
        echo $rows;
    }

}