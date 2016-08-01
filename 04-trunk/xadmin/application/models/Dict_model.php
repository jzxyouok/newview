<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/5/7
 * Time: 9:58
 * Email: 1056811341@qq.com
 */
class Dict_model extends MY_Model
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
        $this->db->from($this->config->item('dict', 'tb'));
        if ($key) {
            $this->db->like('name', $key);
        }
        $config['total_rows'] = $this->db->count_all_results('', false);
        $config['per_page'] = MYPERPAGE;
        $config['cur_page'] = $page;
        $this->pagination->initialize($config);
        $this->db->order_by('type ASC,sort ASC,id ASC');
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
        $result = $this->db->get_where($this->config->item('dict', 'tb'), array('id' => $id))->row_array();
        return $result;
    }

    //保存
    public function save()
    {
        $id = $this->input->post('id');
        $vals = array(
            'name' => $this->input->post('name'),
            'ident' => $this->input->post('ident'),
            'type' => $this->input->post('type'),
            'remark' => $this->input->post('remark'),
            'sort' => $this->input->post('sort')
        );
        if ($id) {
            $bool = $this->db->where('id', $id)->update($this->config->item('dict', 'tb'), $vals);
        } else {
            $bool = $this->db->insert($this->config->item('dict', 'tb'), $vals);
        }
        return $bool;
    }

    /**
     * 验证同类型下标识是否已存在
     * @param string $type 类型
     * @param string $ident 标识
     * @return mixed
     */
    public function ident_exists($type = '', $ident = '')
    {
        $this->db->where(array('type' => $type, 'ident' => $ident));
        $result = $this->db->get($this->config->item('dict', 'tb'))->result_array();
        return $result;
    }
}