<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/5/29
 * Time: 14:25
 * Email: 1056811341@qq.com
 */
class Update_psw_model extends MY_Model
{
    protected $user_id;
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->id = $_SESSION['session']['id'];
        $this->user_id = $_SESSION['session']['id'];
    }

    //获得用户数据
    public function index()
    {
        $result = $this->db->get_where($this->config->item('user', 'tb'), array('id' => $this->user_id))->row_array();
        return $result;
    }

    //保存
    public function save()
    {
        $vals = array(
            'password' => md5($this->input->post('password')),
            'realname' => $this->input->post('realname')
        );
        $password = md5($this->input->post('password'));
        $this->db->where('id', $_SESSION['session']['id']);
        $bool = $this->db->update($this->config->item('user', 'tb'), $vals);
        return $bool;
    }

    //验证旧密码是否正确
    public function check_old_password()
    {
        $old_password = md5($this->input->post('old_password'));
        $this->db->get_where($this->config->item('user', 'tb'), array('id' => $this->id, 'password' => $old_password));
        $rows = $this->db->affected_rows();
        return $rows;
    }
}