<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/5/7
 * Time: 9:58
 * Email: 1056811341@qq.com
 */
class Banner_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->library('uploadify');
    }

    //获得列表
    public function get_list()
    {
        $key = $this->input->post('key');
        $page = ($this->input->post('page')) ?: 1;
        $this->db->from($this->config->item('banner', 'tb'));
        if ($key) {
            $this->db->like('remark', $key);
        }
        $config['total_rows'] = $this->db->count_all_results('', false);
        $config['per_page'] = MYPERPAGE;
        $config['cur_page'] = $page;
        $this->pagination->initialize($config);
        $this->db->order_by('sort DESC,id ASC');
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
        $this->db->select('b.*,GROUP_CONCAT(u.full_relative_path) AS file_path,GROUP_CONCAT(u.id) AS file_id,GROUP_CONCAT(u.file_ext) AS file_ext,GROUP_CONCAT(u.is_image) AS file_is_image');
        $this->db->from($this->config->item('banner', 'tb') . ' AS b');
        $this->db->join($this->config->item('data_to_upload', 'tb') . ' AS dtu', 'dtu.data_id=b.id', 'LEFT');
        $this->db->join($this->config->item('upload', 'tb') . ' AS u', 'u.id=dtu.upload_id AND dtu.tbname = "' . $this->config->item('banner', 'tb') . '"', 'LEFT');
        $this->db->where(array('b.id' => $id));
        $result = $this->db->get()->row_array();
        return $result;
    }

    //保存
    public function save()
    {
        $id = $this->input->post('id');
        $vals = array(
            'url' => $this->input->post('url'),
            'remark' => $this->input->post('remark'),
            'is_show' => $this->input->post('is_show'),
            'sort' => $this->input->post('sort')
        );
        if ($id) {
            $bool = $this->db->where('id', $id)->update($this->config->item('banner', 'tb'), $vals);
        } else {
            $this->db->insert($this->config->item('banner', 'tb'), $vals);
            $bool = $id = $this->db->insert_id();
        }
        $this->uploadify->data_to_upload($this->input->post('image'), $id, $this->config->item('banner', 'tb'));

        return $bool;
    }
}