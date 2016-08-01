<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/6/4
 * Time: 13:06
 * Email: 1056811341@qq.com
 */
class Operation_log_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
    }

    public function get_list()
    {
        $start_time = strtotime($this->input->post('start_time'));
        $end_time = strtotime($this->input->post('end_time'));
        $page = ($this->input->post('page')) ?: 1;
        $this->db->from($this->config->item('logs', 'tb'));
        if ($start_time && $end_time) {
            $this->db->where('time >', $start_time);
            $this->db->where('time <', $end_time);
        }
        if ($_SESSION['session']['user_type'] == 'producter' OR $_SESSION['session']['role_type'] == 0) {
            $this->db->where('user_id', $_SESSION['session']['id']);
        }
        $config['total_rows'] = $this->db->count_all_results('', false);
        $config['per_page'] = MYPERPAGE;
        $config['cur_page'] = $page;
        $this->pagination->initialize($config);
        $this->db->order_by('time DESC');
        $this->db->limit($config['per_page'], ($page - 1) * $config['per_page']);
        $data['list'] = $this->db->get()->result_array();
        $data['pagination'] = $this->pagination->create_ajax_links();
        $data['total'] = $config['total_rows'];
        return $data;
    }
}