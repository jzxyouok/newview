<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/4/25
 * Time: 22:18
 * Email: 1056811341@qq.com
 */
class Login extends CI_Controller
{
    protected $full_url;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model', 'login');
        $this->full_url = $this->input->get('url');
        $this->template();
        $this->load->library('form_validation');
        $this->load->library('category');
    }

    //模板内容
    function template()
    {
        $tpl['tpl_form_url'] = site_url('login/signin?url=' . $this->full_url);
        $this->load->vars($tpl);
    }


    public function index()
    {
        $this->load->view('login.html');
    }

    //验证码
    public function code()
    {
        $config = array(
            'width' => 80,
            'height' => 30,
            'font_size' => 16,
            'code_len' => 1
        );
        $this->load->library('code', $config);
        $this->code->show();
    }

    //登录
    public function signin()
    {
        $code = strtoupper($this->input->post('code'));
        //表单验证
        $config = array(
            array(
                'field' => 'username',
                'label' => '用户名',
                'rules' => 'required'
            ),
            array(
                'field' => 'password',
                'label' => '密码',
                'rules' => 'required'
            ),
            array(
                'field' => 'code',
                'label' => '验证码',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $bool = $this->form_validation->run();
        if (!$bool) {
            $this->load->view('login.html');
        } else {
            //验证验证码
            if ($code != $_SESSION['code']) {
                $error_coed = 9;
            } else {
                $error_coed = $this->login->signin();
            }

            //错误信息
            switch ($error_coed) {
                case 1:
                    $error_msg = '用户名不存在';
                    break;
                case 2:
                    $error_msg = '密码错误';
                    break;
                case 3:
                    $error_msg = '账号被冻结';
                    break;
                case 7:
                    $error_msg = '未分配任何权限';
                    break;
                case 9:
                    $error_msg = '验证码错误';
                    break;
            }
            //登录成功
            if ($error_coed == 0) {
                $this->login->set_login_info();
                if ($this->full_url == '') {
                    //定义登录成功后跳转url
                    $url = array_values($this->category->get_parents_category_url($this->login->get_menu()));
                    redirect($url[0]);
                } else {
                    redirect($this->full_url);
                }
            } else {
                $this->tip->show_error($error_msg, site_url('login'));
            }
        }

    }

    //退出登录
    public function signout()
    {
        $this->session->unset_userdata('session');
        redirect(site_url('login'));
    }

}