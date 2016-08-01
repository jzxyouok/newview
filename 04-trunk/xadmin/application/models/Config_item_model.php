<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/5/7
 * Time: 9:58
 * Email: 1056811341@qq.com
 */
class Config_item_model extends MY_Model
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
        $this->db->select('c.*,cg.name AS group_name');
        $this->db->from($this->config->item('config', 'tb') . ' AS c');
        $this->db->join($this->config->item('config_group', 'tb') . ' AS cg', 'cg.id=c.config_group_id', 'LEFT');
        if ($key) {
            $this->db->like('c.title', $key);
        }
        $config['total_rows'] = $this->db->count_all_results('', false);
        $config['per_page'] = MYPERPAGE;
        $config['cur_page'] = $page;
        $this->pagination->initialize($config);
        $this->db->order_by('c.sort ASC,c.id ASC');
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
        $result = $this->db->get_where($this->config->item('config', 'tb'), array('id' => $id))->row_array();
        return $result;
    }

    //保存
    public function save()
    {
        $id = $this->input->post('id');
        $vals = array(
            'title' => $this->input->post('title'),
            'name' => $this->input->post('name'),
            'config_group_id' => $this->input->post('config_group_id'),
            'type' => $this->input->post('type'),
            'param' => $this->input->post('param'),
            'remark' => $this->input->post('remark'),
            'is_show' => $this->input->post('is_show'),
            'sort' => $this->input->post('sort')
        );
        if ($id) {
            $bool = $this->db->where('id', $id)->update($this->config->item('config', 'tb'), $vals);
        } else {
            $bool = $this->db->insert($this->config->item('config', 'tb'), $vals);
        }
        return $bool;
    }

    //获得配置组
    public function get_config_group()
    {
        $this->db->order_by('sort ASC,id ASC');
        $result = $this->db->get($this->config->item('config_group', 'tb'))->result_array();
        return $result;
    }
}