<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/6/5
 * Time: 10:12
 * Email: 1056811341@qq.com
 */
class Logs
{
    private $CI;
    private $pid;
    private $ip;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->pid = $this->CI->input->get('pid');
        $this->ip = $this->CI->input->ip_address();
    }

    //新增操作日志
    public function add($action = '')
    {
        if (!MYLOGS) return;//是否开启日志

        $verify_last_logs = $this->_verify_last_logs();
        //验证日志是否已添加
        if ($verify_last_logs['user_id'] == $_SESSION['session']['id']
            && $verify_last_logs['menu_id'] == $this->pid
            && $verify_last_logs['menu_auth_ident'] == $action
        ) {
            return;
        } else {
            $menu = $this->_get_menu();
            $menu_auth = $this->_get_menu_auth($action);
            $vals = array(
                'user_id' => $_SESSION['session']['id'],
                'username' => $_SESSION['session']['username'],
                'menu_id' => $menu['id'],
                'menu_name' => $menu['name'],
                'menu_auth_ident' => $menu_auth['ident'],
                'menu_auth_name' => $menu_auth['name'],
                'ip' => $this->ip,
                'time' => time()
            );
            if ($menu_auth['ident'] == MYLOOK) return;//查看操作不记录日志
            $this->CI->db->insert($this->CI->config->item('logs', 'tb'), $vals);
        }
    }

    //获取栏目名称
    public function _get_menu()
    {
        $result = $this->CI->db->get_where($this->CI->config->item('menu', 'tb'), array('id' => $this->pid))->row_array();
        return $result;
    }

    //获取菜单权限
    public function _get_menu_auth($action)
    {
        $result = $this->CI->db->get_where($this->CI->config->item('dict', 'tb'), array('ident' => $action, 'type' => $this->CI->config->item('menu_auth', 'dict')))->row_array();
        return $result;
    }

    //验证最近一次操作
    public function _verify_last_logs()
    {
        $user_id = $_SESSION['session']['id'];
        $this->CI->db->where('user_id', $user_id);
        $this->CI->db->order_by('time DESC');
        $result = $this->CI->db->get($this->CI->config->item('logs', 'tb'))->row_array(0);
        return $result;
    }


}