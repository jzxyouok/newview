<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/5/9
 * Time: 16:32
 * Email: 1056811341@qq.com
 */
class Ajax_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('uploadify');
    }

    //删除
    public function del()
    {
        $tbname = $this->input->post('tbname');
        $id = $this->input->post('id');
        $primary = (!empty($this->input->post('primary'))) ? $this->input->post('primary') : 'id';
        $this->db->where($primary, $id);
        $this->db->delete($tbname);
        $rows = $this->db->affected_rows();
        //删除上传文件与数据的关系
        $this->uploadify->del_data_to_upload($id, $tbname);
        return $rows;
    }

    //批量删除
    public function batch_del()
    {
        $tbname = $this->input->post('tbname');
        $id = $this->input->post('id');
        $id_array = explode(',', $id);
        $primary = (!empty($this->input->post('primary'))) ? $this->input->post('primary') : 'id';
        $this->db->where_in($primary, $id_array);
        $this->db->delete($tbname);
        $rows = $this->db->affected_rows();
        //删除上传文件与数据的关系
        $this->uploadify->del_data_to_upload($id, $tbname);
        return $rows;
    }
}