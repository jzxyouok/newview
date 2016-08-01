<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/5/7
 * Time: 9:58
 * Email: 1056811341@qq.com
 */
class Role_auth_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获得菜单权限
     * @param $menu_id   菜单标识
     * @return mixed
     */
    public function menu_auth($menu_id)
    {
        $this->db->select('d.id,d.name,d.ident');
        $this->db->from($this->config->item('menu_to_auth', 'tb') . ' AS mta');
        $this->db->join($this->config->item('dict', 'tb') . ' AS d', 'd.id=mta.menu_auth_id', 'LEFT');
        $this->db->where(array('mta.menu_id' => $menu_id, 'd.type' => $this->config->item('menu_auth', 'dict')));
        $this->db->order_by('d.sort ASC,d.id ASC');
        $result = $this->db->get()->result_array();
        return $result;
    }

    //保存
    public function save()
    {
        $role_id = $this->input->post('role_id');
        $menu_auth = $this->input->post('menu_auth');
        //删除原始数据
        $this->db->delete($this->config->item('role_to_auth', 'tb'), array('role_id' => $role_id));
        //插入新数据【如果没有数据则不执行插入操作】
        if (!empty($menu_auth)) {
            foreach ($menu_auth as $key => $val) {
                foreach ($val as $rows) {
                    $vals = array(
                        'role_id' => $role_id,
                        'menu_id' => $key,
                        'menu_auth_id' => $rows
                    );
                    $this->db->insert($this->config->item('role_to_auth', 'tb'), $vals);
                }
            }
        }
        $rows = $this->db->affected_rows();
        return $rows;
    }

    /**
     * 获取已选项
     * @param $role_id  角色标识
     * @return mixed
     */
    public function role_to_auth($role_id)
    {
        $this->db->select('menu_id,menu_auth_id');
        $result = $this->db->get_where($this->config->item('role_to_auth', 'tb'), array('role_id' => $role_id))->result_array();
        return $result;
    }

    /**
     * 根据角色获取菜单
     * @param $role_id  角色标识
     * @return mixed
     */
    public function get_role_menu($role_id)
    {
        $sql = "SELECT *
            FROM " . $this->db->dbprefix . $this->config->item('menu', 'tb') . " AS m
            WHERE m.id IN (
                    SELECT DISTINCT menu_id
                    FROM " . $this->db->dbprefix . $this->config->item('role_to_auth', 'tb') . "
                    WHERE role_id = " . $role_id . "
                )
            ORDER BY sort ASC, id ASC";
        $result = $this->db->query($sql)->result_array();
        return $result;
    }

    /**
     * 根据角色获取每个菜单对应的权限
     * @param $role_id  角色标识
     * @param $menu_id  菜单标识
     * @return string
     */
    public function get_role_menu_auth($role_id, $menu_id)
    {
        $sql = "SELECT ident
            FROM " . $this->db->dbprefix . $this->config->item('dict', 'tb') . "
            WHERE id IN (
                    SELECT menu_auth_id
                    FROM " . $this->db->dbprefix . $this->config->item('role_to_auth', 'tb') . "
                    WHERE role_id = " . $role_id . " AND menu_id = " . $menu_id . "
                )";
        $result = $this->db->query($sql)->result_array();
        return implode(',', $this->common->multi_to_one($result));
    }


}