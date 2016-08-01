<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/5/7
 * Time: 9:58
 * Email: 1056811341@qq.com
 */
class Information_model extends MY_Model
{
    protected $cid;

    public function __construct()
    {
        parent::__construct();
        $this->cid = $this->input->get('cid');
        $this->load->library('pagination');
        $this->load->library('category', array('tb' => $this->config->item('infocategory', 'tb'), 'is_show' => 1), 'my_category');
    }

    //获得当前分类下的所有分类标识
    public function get_category_children_id()
    {
        $data = $this->my_category->get_children_id(array(), $this->cid, '', 1);
        return $data;
    }

    //获取和当前分类模型相同的分类id
    public function get_same_model_categroy_id()
    {
        $sql = "SELECT id 
            FROM " . $this->db->dbprefix . $this->config->item('infocategory', 'tb') . " 
            WHERE infomodel_id IN (
            SELECT infomodel_id 
            FROM " . $this->db->dbprefix . $this->config->item('infocategory', 'tb') . " 
            WHERE id = " . $this->cid . ")";
        $result = $this->db->query($sql)->result_array();
        return $this->common->multi_to_one($result);
    }

    //获取分类【用于下拉列表】
    public function get_category_option()
    {
        $result = $this->my_category->get_option(array(), 0, $this->cid, 1, 0, '', 0, $this->get_same_model_categroy_id(), 0);
        return $result;
    }

}