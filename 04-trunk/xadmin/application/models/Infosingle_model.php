<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/7/11
 * Time: 15:40
 * Email: 1056811341@qq.com
 */
require_once 'Information_model.php';

class Infosingle_model extends Information_model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->db->select('is.*,ic.name');
        $this->db->from($this->config->item('infosingle', 'tb') . ' AS is');
        $this->db->join($this->config->item('infocategory', 'tb') . ' AS ic', 'ic.id=is.category_id', 'left');
        $this->db->where(array('is.category_id' => $this->cid));
        $result = $this->db->get()->row_array();
        return $result;
    }

    //保存
    public function save()
    {
        $category_id = $this->input->post('category_id');
        $data = array(
            'content' => $this->input->post('content'),
            'update_time' => time()
        );
        $bool = $this->db->where(array('category_id' => $category_id))->update($this->config->item('infosingle', 'tb'), $data);
        return $bool;
    }
}