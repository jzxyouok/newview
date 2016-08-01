<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/4/30
 * Time: 22:36
 * Email: 1056811341@qq.com
 */
class Menu_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('category');
    }

    //获得列表
    public function get_list()
    {
        $this->db->select('m.*,GROUP_CONCAT(concat("<kbd class=bg-primary>",d.name,"</kbd>")SEPARATOR "&nbsp;") as menu_auth_name');
        $this->db->from($this->config->item('menu', 'tb') . ' AS m');
        $this->db->join($this->config->item('menu_to_auth', 'tb') . ' AS mta', 'mta.menu_id=m.id', 'LEFT');
        $this->db->join($this->config->item('dict', 'tb') . ' AS d', 'd.id=mta.menu_auth_id', 'LEFT');
        $this->db->group_by('m.id');
        $category_result = $this->db->get()->result_array();
        $data['list'] = $this->category->get_children($category_result);
        $data['total_nums'] = count($data['list']);
        return $data;
    }

    //获得分类下拉列表项
    public function get_category_option($insert_or_update = 0)
    {
        $id = $this->input->get('id');
        return $this->category->get_option(array(), 0, $id, $insert_or_update, $insert_or_update);
    }

    //更新
    public function update()
    {
        $id = $this->input->get('id');
        $result = $this->db->get_where($this->config->item('menu', 'tb'), array('id' => $id))->row_array();
        return $result;
    }

    //保存
    public function save()
    {
        $id = $this->input->post('id');
        $parent_id = $this->input->post('parent_id');
        $menu_auth_id = $this->input->post('menu_auth');
        $data = array(
            'name' => $this->input->post('name'),
            'module' => $this->input->post('module'),
            'controller' => $this->input->post('controller'),
            'method' => $this->input->post('method'),
            'param' => $this->input->post('param'),
            'remark' => $this->input->post('remark'),
            'is_show' => $this->input->post('is_show'),
            'user_type' => $this->input->post('user_type'),
            'sort' => $this->input->post('sort')
        );
        if ($id) {
            $bool = $this->category->update_category($id, $parent_id, $data);
            //更新菜单权限关系
            $this->menu_model->update_menu_to_auth($id, $menu_auth_id);
        } else {
            $bool = $this->category->insert_category($parent_id, $data);
            //更新菜单权限关系
            $this->menu_model->update_menu_to_auth($bool, $menu_auth_id);
        }
        return $bool;
    }

    //删除
    public function delete()
    {
        $id = $this->input->post('id');
        //删除分类
        $bool = $this->category->delete_category($id);
        if ($bool) {
            //删除菜单权限关系
            $this->del_menu_to_auth($id);
        }
        return $bool;
    }

    //获得菜单权限
    public function menu_auth()
    {
        $this->db->order_by('sort ASC,id ASC');
        $this->db->where(array('type' => $this->config->item('menu_auth', 'dict')));
        $result = $this->db->get($this->config->item('dict', 'tb'))->result_array();
        return $result;
    }

    //更新菜单权限关系
    public function update_menu_to_auth($menu_id = '', $menu_auth_id = array())
    {
        //删除原始数据
        $this->db->delete($this->config->item('menu_to_auth', 'tb'), array('menu_id' => $menu_id));
        //插入新数据
        if (!empty($menu_auth_id)) {
            foreach ($menu_auth_id as $val) {
                if ($val != '') {
                    $this->db->insert($this->config->item('menu_to_auth', 'tb'), array('menu_id' => $menu_id, 'menu_auth_id' => $val));
                }
            }
        }
    }

    //删除菜单权限关系
    public function del_menu_to_auth($id)
    {
        $this->db->delete($this->config->item('menu_to_auth', 'tb'), array('menu_id' => $id));
    }

    //获得菜单权限关系
    public function get_menu_to_auth($id = '')
    {
        if ($id != '') {
            $this->db->where('menu_id', $id);
        }
        $this->db->select('menu_auth_id');
        $result = $this->db->get($this->config->item('menu_to_auth', 'tb'))->result_array();
        return $this->common->multi_to_one($result);
    }
}