<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/4/25
 * Time: 22:20
 * Email: 1056811341@qq.com
 */
class Login_model extends MY_Model
{

    //登录
    public function signin()
    {
        $error_code = 0;//错误码：0=登录成功，1=用户名不存在，2=密码错误，3=冻结，7=未分配权限，9=验证码错误
        $username = trim(preg_replace('/(\'|")*/', '', $this->input->post('username')));
        $password = trim(preg_replace('/(\'|")*/', '', $this->input->post('password')));
        $frist_menu = array();
        //验证用户名是否存在
        $username_exists = $this->db->where('username', $username)->get($this->config->item('user', 'tb'))->num_rows();
        //验证登录信息是否正确
        if (!$username_exists) {
            $error_code = 1;
        } else {
            $this->db->select('u.*,r.role_type');
            $this->db->from($this->config->item('user', 'tb') . ' AS u');
            $this->db->join($this->config->item('role', 'tb') . ' AS r', 'r.id = u.role_id', 'LEFT');
            $this->db->where(array('u.username' => $username, 'u.password' => md5($password)));
            $session['session'] = $result = $this->db->get()->row_array();
            $this->session->set_userdata($session);
            if (empty($result)) {
                $error_code = 2;
            } else {
                //验证用户是否被冻结
                if ($result['forzen'] == 0) {
                    $error_code = 3;
                } else {
                    foreach ($this->get_menu() as $val) {
                        if ($val['level'] == '0') {
                            $frist_menu[] = $val;
                        }
                    }
                    if (empty($frist_menu)) {
                        $error_code = 7;
                        $this->session->unset_userdata('session');
                    }
                }
            }
        }
        return $error_code;
    }

    //设置登录信息
    public function set_login_info()
    {
        $vals = array(
            'login_time' => time(),
            'login_ip' => $this->input->ip_address(),
            'last_login_time' => $_SESSION['session']['login_time'],
            'last_login_ip' => $_SESSION['session']['login_ip'],
        );
        $this->db->where('id', $_SESSION['session']['id'])->update($this->config->item('user', 'tb'), $vals);
    }


}