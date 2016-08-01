<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/7/11
 * Time: 23:37
 * Email: 1056811341@qq.com
 */
require_once 'Information_model.php';

class Infoarticle_model extends Information_model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('uploadify');
        $this->load->library('pagination');
    }

    //获得列表
    public function get_list()
    {
        $key = $this->input->post('key');
        $pid = $this->get_category_children_id();
        $page = ($this->input->post('page')) ?: 1;
        $this->db->select('i.*,ic.name AS category_name');
        $this->db->from($this->config->item('infoarticle', 'tb') . ' AS i');
        $this->db->join($this->config->item('infocategory', 'tb') . ' AS ic', 'ic.id=i.category_id', 'LEFT');
        if ($key) {
            $this->db->like('i.title', $key);
        }
        if (!empty($pid)) {
            $this->db->where_in('i.category_id', $pid);
        }
        $config['total_rows'] = $this->db->count_all_results('', false);
        $config['per_page'] = MYPERPAGE;
        $config['cur_page'] = $page;
        $this->pagination->initialize($config);
        $this->db->order_by('i.sort DESC,i.id ASC');
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
        $this->db->from($this->config->item('infoarticle', 'tb') . ' AS b');
        $this->db->join($this->config->item('data_to_upload', 'tb') . ' AS dtu', 'dtu.data_id=b.id', 'LEFT');
        $this->db->join($this->config->item('upload', 'tb') . ' AS u', 'u.id=dtu.upload_id AND dtu.tbname = "' . $this->config->item('infoarticle', 'tb') . '"', 'LEFT');
        $this->db->where(array('b.id' => $id));
        $result = $this->db->get()->row_array();
        return $result;
    }

    //保存
    public function save()
    {
        $id = $this->input->post('id');
        $vals = array(
            'category_id' => $this->input->post('category_id'),
            'title' => $this->input->post('title'),
            'remark' => $this->input->post('remark'),
            'content' => $this->input->post('content'),
            'is_show' => $this->input->post('is_show'),
            'sort' => $this->input->post('sort'),
            'update_time' => time()
        );
        if ($id) {
            $bool = $this->db->where('id', $id)->update($this->config->item('infoarticle', 'tb'), $vals);
        } else {
            $this->db->insert($this->config->item('infoarticle', 'tb'), $vals);
            $bool = $id = $this->db->insert_id();
        }
        $this->uploadify->data_to_upload($this->input->post('image'), $id, $this->config->item('infoarticle', 'tb'));
        return $bool;
    }

}