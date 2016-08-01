<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/5/31
 * Time: 16:03
 * Email: 1056811341@qq.com
 */
class Welcome extends MY_Controller
{
    public function index()
    {
        $this->common->set_auth(MYLOOK, $this->my_get_auth());
        $this->logs->add(MYLOOK);
        $data['username'] = $_SESSION['session']['username'];
        $data['realname'] = ($_SESSION['session']['realname']) ?: '-';
        $data['last_login_time'] = ($_SESSION['session']['login_time']) ? date('Y-m-d H:i:s', $_SESSION['session']['login_time']) : '首次登录';
        $data['last_login_ip'] = $_SESSION['session']['login_ip'];
        $data['server_software'] = $_SERVER['SERVER_SOFTWARE'];
        $data['os'] = PHP_OS;
        $this->load->view('welcome/index.html', $data);
    }
}