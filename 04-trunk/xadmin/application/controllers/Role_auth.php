<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/5/7
 * Time: 9:59
 * Email: 1056811341@qq.com
 */
class Role_auth extends MY_Controller
{
    protected $rid;

    public function __construct()
    {
        parent::__construct();
        $this->rid = $this->input->get('rid');
        $this->template();
        $this->load->model('role_auth_model', 'role_auth');
        $this->load->library('category', array('is_show_val' => 1), 'my_category');
    }

    //模板内容
    public function template()
    {
        $tpl['tpl_get_list_url'] = site_url('role_auth/get_list?rid=' . $this->rid . 'pid=' . $this->pid);
        $tpl['tpl_save_url'] = site_url('role_auth/save?rid=' . $this->rid . '&pid=' . $this->pid);
        $this->load->vars($tpl);
    }

    public function index()
    {
        $data['role_id'] = $this->rid;
        $this->load->view('role_auth/index.html', $data);
    }

    //获得列表
    public function get_list()
    {
        $list = $this->my_category->get_children();
        foreach ($list as $val) {
            if ($val['user_type'] == 'producter')
                $data['list'][] = $val;
        }
        foreach ($data['list'] as $key => $val) {
            $data['list'][$key]['auth'] = $this->get_menu_auth($val['id']);
            $data['list'][$key]['prefix'] = str_repeat('&nbsp;&nbsp;', $val['level'] * 2) . ((!empty($val['level']) ? '└─&nbsp;' : ''));
        }
        echo json_encode($data);
    }

    /**
     * 获取菜单权限
     * @param $menu_id   权限标识
     * @return string
     */
    public function get_menu_auth($menu_id)
    {
        $html = '';
        $auth = array();
        $result = $this->role_auth->menu_auth($menu_id);
        //当前角色所有权限
        $role_to_auth_result = $this->role_auth->role_to_auth($this->rid);
        foreach ($result as $val) {
            //遍历获得当前角色及当前分类的权限【数组形式体现】
            foreach ($role_to_auth_result as $res) {
                if ($res['menu_id'] == $menu_id) {
                    $auth[] = $res['menu_auth_id'];
                }
            }
            $checked = $this->common->checked($val['id'], $auth);
            $html .= '<label><input type="checkbox" ' . $checked . ' name="menu_auth[' . $menu_id . '][]" value="' . $val['id'] . '"><ins></ins>' . $val['name'] . '[' . $val['ident'] . ']' . '</label>';
        }
        return $html;
    }

    //保存
    public function save()
    {
        $rows = $this->role_auth->save();
        if ($rows) {
            $this->tip->show_success('操作成功！', site_url('role_auth?pid=' . $this->pid . '&rid=' . $this->rid));
        } else {
            $this->tip->show_error('操作失败！', site_url('role_auth?pid=' . $this->pid . '&rid=' . $this->rid));
        }
    }


}