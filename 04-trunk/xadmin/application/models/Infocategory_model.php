<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/6/28
 * Time: 15:35
 * Email: 1056811341@qq.com
 */
class Infocategory_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('category', array('tb' => $this->config->item('infocategory', 'tb')), 'my_category');
    }

    //获得列表
    public function get_list()
    {
        $this->db->select('ic.*,im.name AS infomodel_name,im.front_controller,im.controller');
        $this->db->from($this->config->item('infocategory', 'tb') . ' AS ic');
        $this->db->join($this->config->item('infomodel', 'tb') . ' AS im', 'im.id=ic.infomodel_id', 'LEFT');
        $this->db->order_by('ic.sort ASC,ic.id ASC');
        $category_result = $this->db->get()->result_array();
        $data['list'] = $this->my_category->get_children($category_result);
        $data['total_nums'] = count($data['list']);
        return $data;
    }

    /**
     * 获得分类下拉列表项
     * @param int $insert_or_update 0=新增，1=更新
     * @return mixed
     */
    public function get_category_option($insert_or_update = 0)
    {
        $id = $this->input->get('id');
        return $this->my_category->get_option(array(), 0, $id, $insert_or_update, $insert_or_update);
    }

    //更新
    public function update()
    {
        $id = $this->input->get('id');
        $result = $this->db->get_where($this->config->item('infocategory', 'tb'), array('id' => $id))->row_array();
        return $result;
    }

    //保存
    public function save()
    {
        $id = $this->input->post('id');
        $parent_id = $this->input->post('parent_id');
        $infomodel_id = $this->input->post('infomodel_id');
        $data = array(
            'name' => $this->input->post('name'),
            'infomodel_id' => $infomodel_id,
            'url' => $this->input->post('url'),
            'seo_title' => $this->input->post('seo_title'),
            'seo_description' => $this->input->post('seo_description'),
            'remark' => $this->input->post('remark'),
            'is_show' => $this->input->post('is_show'),
            'sort' => $this->input->post('sort')
        );
        if ($id) {
            $bool = $this->my_category->update_category($id, $parent_id, $data);
            if ($bool) {
                $this->single_opera($id, $infomodel_id);
            }
        } else {
            $bool = $this->my_category->insert_category($parent_id, $data);
            if ($bool) {
                $this->single_opera($bool, $infomodel_id);
            }
        }
        return $bool;
    }

    //删除
    public function delete()
    {
        $id = $this->input->post('id');
        //删除分类
        $bool = $this->my_category->delete_category($id);
        if ($bool) {
            $this->single_opera($id);
        }
        return $bool;
    }

    //信息模型
    public function get_infomodel()
    {
        $this->db->where(array('is_show' => 1));
        $this->db->order_by('sort ASC,id ASC');
        $result = $this->db->get($this->config->item('infomodel', 'tb'))->result_array();
        return $result;
    }

    /**
     * 单页操作【信息模型是单页的情况下执行的新增/删除】
     * @param string $category_id 当前操作的信息标识
     * @param string $infomodel_id 当前操作的信息所属信息模型
     */
    public function single_opera($category_id = '', $infomodel_id = '')
    {
        $infomodel = $this->db->select('controller')->where(array('id' => $infomodel_id))->get($this->config->item('infomodel', 'tb'))->row_array();
        $infosingle_exists = $this->db->get_where($this->config->item('infosingle', 'tb'), array('category_id' => $category_id))->num_rows();
        if (in_array('infosingle', $infomodel)) {//信息模型为单页的时候进行新增
            if ($infosingle_exists <= 0) {
                $this->db->insert($this->config->item('infosingle', 'tb'), array('category_id' => $category_id, 'create_time' => time()));
            }
        } else {//删除
            $this->db->where('category_id', $category_id)->delete($this->config->item('infosingle', 'tb'));
        }
    }

}