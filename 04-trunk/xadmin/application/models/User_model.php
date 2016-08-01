<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/5/7
 * Time: 9:58
 * Email: 1056811341@qq.com
 */
class User_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
    }

    //获得列表
    public function get_list()
    {
        $key = $this->input->post('key');
        $page = ($this->input->post('page')) ?: 1;
        $this->db->select('u.id,u.username,u.remark,u.forzen,u.root,u.user_type,r.name,r.role_type');
        $this->db->from($this->config->item('user', 'tb') . ' AS u');
        $this->db->join($this->config->item('role', 'tb') . ' AS r', 'r.id=u.role_id', 'LEFT');
        $this->db->where(array('user_type' => 'producter'));
        if ($key) {
            $this->db->like('u.username', $key);
        }
        $config['total_rows'] = $this->db->count_all_results('', false);
        $config['per_page'] = MYPERPAGE;
        $config['cur_page'] = $page;
        $this->pagination->initialize($config);
        $this->db->order_by('u.id ASC');
        $this->db->limit($config['per_page'], ($page - 1) * $config['per_page']);
        $data['list'] = $this->db->get()->result_array();
        $data['pagination'] = $this->pagination->create_ajax_links();
        $data['total'] = $config['total_rows'];
        return $data;
    }

    //更新
    public function update()
    {
        $id = $this->input->get('id');
        $this->db->select('u.*,r.role_type');
        $this->db->from($this->config->item('user', 'tb') . ' AS u');
        $this->db->join($this->config->item('role', 'tb') . ' AS r', 'r.id=u.role_id', 'LEFT');
        $this->db->where(array('u.id' => $id));
        $result = $this->db->get()->row_array();
        return $result;
    }

    //保存
    public function save()
    {
        $id = $this->input->post('id');
        $password = ($this->input->post('password') == '') ? '' : md5($this->input->post('password'));
        $vals = array(
            'username' => $this->input->post('username'),
            'password' => $password,
            'forzen' => (($this->input->post('forzen') == '0') ? $this->input->post('forzen') : '1'),
            'role_id' => $this->input->post('role_id'),
            'realname' => $this->input->post('realname'),
            'remark' => $this->input->post('remark'),
        );
        //移除符合条件的指定元素
        foreach ($vals as $key => $val) {
            if ($val == '' && in_array($key, array('password'))) {
                unset($vals[$key]);
            }
        }
        if ($id) {
            $bool = $this->db->where('id', $id)->update($this->config->item('user', 'tb'), $vals);
        } else {
            $bool = $this->db->insert($this->config->item('user', 'tb'), $vals);
        }
        return $bool;
    }

    //获得角色
    public function role()
    {
        $this->db->order_by('id ASC');
        $result = $this->db->get($this->config->item('role', 'tb'))->result_array();
        return $result;
    }

    //验证用户名是否存在
    public function check_username_exists()
    {
        $username = $this->input->post('username');
        $id = $this->input->post('id');
        if ($id) {
            $this->db->where('id!=', $id);
        }
        $this->db->where('username', $username);
        $this->db->get($this->config->item('user', 'tb'));
        $rows = $this->db->affected_rows();
        return $rows;
    }
}