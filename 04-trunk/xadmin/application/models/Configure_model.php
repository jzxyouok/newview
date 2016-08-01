<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/5/31
 * Time: 21:53
 * Email: 1056811341@qq.com
 */
class Configure_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获得表单
     * @param string $group_id 配置组标识
     * @return mixed
     */
    public function get_forms($group_id = '')
    {
        $this->db->order_by('sort ASC,id ASC');
        $this->db->where(array('config_group_id' => $group_id, 'is_show' => 1));
        $result = $this->db->get($this->config->item('config', 'tb'))->result_array();
        return $result;
    }

    //获得配置组
    public function get_config_group()
    {
        $this->db->order_by('sort ASC,id ASC');
        $result = $this->db->get($this->config->item('config_group', 'tb'))->result_array();
        return $result;
    }

    //保存
    public function save()
    {
        $rows = 0;
        $vals = $this->input->post();
        if (!empty($vals)) {
            foreach ($vals as $key => $val) {
                $value = (is_array($val)) ? implode(',', $val) : $val;
                $this->db->where(array('name' => $key))->update($this->config->item('config', 'tb'), array('value' => $value));
                $rows += $this->db->affected_rows();
            }
        }
        return $rows;
    }
}