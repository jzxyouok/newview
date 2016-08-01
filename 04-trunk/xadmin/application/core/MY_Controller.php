<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/4/27
 * Time: 22:53
 * Email: 1056811341@qq.com
 */
class MY_Controller extends CI_Controller
{
    protected $pid;//菜单标识
    protected $peferer;//上一个页面url
    protected $is_save;//是否为保存：1=保存，2=保存并继续新增
    private $menu = array();//用户所有菜单

    public function __construct()
    {
        parent::__construct();
        defined("MYBASEURL") OR define('MYBASEURL', base_url());
        $this->load->library('category');
        $this->load->model('my_model');
        $this->my_login_verify();
        $this->pid = $this->input->get('pid');
        $this->peferer = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
        $this->is_save = ($this->input->post('is_save') == '') ? '1' : $this->input->post('is_save');
        $this->menu = $this->my_model->get_menu();
        $this->my_get_nav();
        $this->my_left_sidebar();
    }

    //登录验证
    public function my_login_verify()
    {
        $full_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        if (empty($_SESSION['session'])) {
            $this->tip->show_error('登录超时！', site_url('login?url=' . $full_url));
        }
    }

    //获取主导航
    public function my_get_nav()
    {
        $parent_id = '';
        $data['nav'] = array();
        $get_parents_id = $this->category->get_parents($this->menu, $this->pid, '', 1);
        foreach ($get_parents_id as $val) {
            $parent_id = $val['id'];
            break;
        }
        foreach ($this->menu as $key => $val) {
            if ($val['level'] == '0') {
                $data['nav'][$key] = $val;
            }
        }
        $url = $this->category->get_parents_category_url($this->menu);
        foreach ($data['nav'] as $key => $val) {
            $data['nav'][$key]['highlight'] = ($val['id'] == $parent_id) ? 'active' : '';
            $data['nav'][$key]['url'] = $url[$key];
        }
        $this->load->vars($data);
    }

    //获取左侧菜单
    public function my_left_sidebar()
    {
        $plevel = $parent_id = 0;
        $str_html = '';
        $section_name = '';
        $id = '';
        $breadcrumb = '';
        $get_parents_id = $this->category->get_parents($this->menu, $this->pid, '', 1);
        foreach ($get_parents_id as $val) {
            $parent_id = $val['id'];
            break;
        }
        $left_sidebar_array = $this->category->get_children($this->menu, $parent_id, 1, 0);
        foreach ($left_sidebar_array as $val) {
            if ($this->pid == $val['id']) {
                $highlight = 'current';
                $section_name = $val['name'];
                $id = $val['id'];
            } else {
                $highlight = '';
            }
            $module = ($val['module']) ? $val['module'] . '/' : '';
            $controller = ($val['controller']) ? $val['controller'] . '/' : '';
            $method = ($val['method']) ? $val['method'] . '/' : '';
            $param = (!empty($val['param'])) ? '&' . $val['param'] : '';
            $level = $val['level'];
            if ($level < $plevel) {
                $str_html .= '</li>' . str_repeat('</ul></li>', $plevel - $level);
            } elseif ($level > $plevel) {
                $str_html .= '<ul data-level="' . ($level - 1) . '">';
            } else {
                $str_html .= '</li>';
            }
            $str_html .= '<li>';
            if ($module == '' && $controller == '' && $method == '') {
                $str_html .= '<a href="javascript:;" class="' . $highlight . '" data-name="mtree_link">';
            } else {
                $str_html .= '<a href="' . site_url($module . $controller . $method . '?pid=' . $val['id'] . $param) . '" class="' . $highlight . '" data-name="mtree_link">';
            }
            $str_html .= '<span data-name="mtree_indent"></span>';
            $str_html .= '<span data-name="mtree_btn"></span>';
            $str_html .= '<span data-name="mtree_name">' . $val['name'] . '</span>';
            $str_html .= '</a>';
            $plevel = $level;
        }
        $str_html .= str_repeat('</li></ul>', $plevel + 1);
        $breadcrumb_array = $this->category->get_parents($this->menu, $id, null, 1);
        $breadcrumb .= '<ol class="breadcrumb pull-right">';
        foreach ($breadcrumb_array as $key => $val) {
            $module = ($val['module']) ? $val['module'] . '/' : '';
            $controller = ($val['controller']) ? $val['controller'] . '/' : '';
            $method = ($val['method']) ? $val['method'] . '/' : '';
            $param = (!empty($val['param'])) ? '&' . $val['param'] : '';
            if ($module == '' && $controller == '' && $method == '') {
                $breadcrumb .= '<li>' . $val['name'] . '</li>';
            } else {
                $breadcrumb .= '<li><a href="' . site_url($module . $controller . $method . '?pid=' . $val['id'] . $param) . '">' . $val['name'] . '</a></li>';
            }
        }
        $breadcrumb .= '</ol>';
        $data['left_sidebar'] = $str_html;
        $data['section_name'] = $section_name;
        $data['breadcrumb'] = $breadcrumb;
        $this->load->vars($data);
    }

    //获取权限
    public function my_get_auth()
    {
        $role_id = $_SESSION['session']['role_id'];
        $user_type = $_SESSION['session']['user_type'];
        $role_type = $_SESSION['session']['role_type'];

        if ($user_type == 'developer') {//开发者
            $this->db->select('GROUP_CONCAT(d.ident) AS auth');
            $this->db->from($this->config->item('menu_to_auth', 'tb') . ' AS mta');
            $this->db->join($this->config->item('dict', 'tb') . ' AS d', 'd.id = mta.menu_auth_id', 'LEFT');
            $this->db->where(array('mta.menu_id' => $this->pid, 'd.type' => $this->config->item('menu_auth', 'dict')));
        } else {
            if ($role_type == '1') {//超级管理员
                $this->db->select('GROUP_CONCAT(d.ident) AS auth');
                $this->db->from($this->config->item('menu_to_auth', 'tb') . ' AS mta');
                $this->db->join($this->config->item('dict', 'tb') . ' AS d', 'd.id = mta.menu_auth_id', 'LEFT');
                $this->db->join($this->config->item('menu', 'tb') . ' AS m', 'm.id=mta.menu_id', 'LEFT');
                $this->db->where(array('mta.menu_id' => $this->pid, 'd.type' => $this->config->item('menu_auth', 'dict'), 'user_type' => 'producter'));
            } else {//普通管理员
                $this->db->select('GROUP_CONCAT(d.ident) AS auth');
                $this->db->from($this->config->item('role_to_auth', 'tb') . ' AS rta');
                $this->db->join($this->config->item('dict', 'tb') . ' AS d', 'd.id = rta.menu_auth_id', 'LEFT');
                $this->db->where(array('rta.menu_id' => $this->pid, 'rta.role_id' => $role_id, 'd.type' => $this->config->item('menu_auth', 'dict')));
            }
        }
        $result = $this->db->get()->row_array();
        $result = explode(',', $result['auth']);
        return $result;
    }

}