<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/4/29
 * Time: 23:38
 * Email: 1056811341@qq.com
 */
class Category
{
    private $CI;
    private $tb;
    private $id;
    private $name;
    private $pid;
    private $pid_val;
    private $sort;
    private $level;
    private $level_val;
    private $is_show;
    private $is_show_val;
    private $order_type;
    private $list_tpl;
    private $item_tpl;
    private $withself;

    /**
     * 构造函数
     * Category constructor.
     * @param array $arr 参数名，如果没定义，则采用默认值
     */
    public function __construct($params = array())
    {
        $this->CI =& get_instance();
        // 初始化参数
        $this->tb = (isset($params['tb'])) ? $params['tb'] : 'menu';
        $this->id = (isset($params['id'])) ? $params['id'] : 'id';
        $this->name = (isset($params['name'])) ? $params['name'] : 'name';
        $this->pid = (isset($params['pid'])) ? $params['pid'] : 'parent_id';
        $this->pid_val = (isset($params['pid_val'])) ? $params['pid_val'] : 0;
        $this->sort = (isset($params['sort'])) ? $params['sort'] : 'sort';
        $this->level = (isset($params['level'])) ? $params['level'] : 'level';
        $this->level_val = (isset($params['level_val'])) ? $params['level_val'] : 0;
        $this->is_show = (isset($params['is_show'])) ? $params['is_show'] : 'is_show';
        $this->is_show_val = (isset($params['is_show_val'])) ? $params['is_show_val'] : '';
        $this->order_type = (isset($params['order_type'])) ? $params['order_type'] : 'ASC';
        $this->list_tpl = (isset($params['list_tpl'])) ? $params['list_tpl'] : 'list_tpl';
        $this->item_tpl = (isset($params['item_tpl'])) ? $params['item_tpl'] : 'item_tpl';
        $this->withself = (isset($params['withself'])) ? $params['withself'] : 0;
    }

    /**
     * 获得所有数据
     * @param string $is_show_val 审核：1=显示，0=隐藏，空值=全部
     * @return mixed
     */
    public function get_all($is_show_val = '')
    {
        if ($is_show_val == '') {
            $is_show_val = $this->is_show_val;
        }
        $this->CI->db->order_by($this->sort . ' ' . $this->order_type . ',' . $this->id . ' ' . $this->order_type);
        if ($is_show_val != '') {
            $query = $this->CI->db->get_where($this->tb, array($this->is_show => $is_show_val));
        } else {
            $query = $this->CI->db->get($this->tb);
        }
        return $query->result_array();
    }

    /**
     * 获得指定数据
     * @param array $data 所有数据
     * @param string $id 唯一标识
     * @return array|mixed
     */
    public function get_one($data = array(), $id = '')
    {
        $result = array();
        if ($id == '') {
            return array();
        }
        if (!empty($data)) {
            foreach ($data as $val) {
                if ($val[$this->id] == $id) {
                    $result = $val;
                }
            }
            return $result;
        } else {
            $query = $this->CI->db->get_where($this->tb, array($this->id => $id));
            return $query->row_array();
        }
    }

    /**
     * 获得当前及其下级
     * @param array $data 所有数据
     * @param int $pid_val 上级唯一标识值
     * @param string $is_show_val 审核：1=显示，0=隐藏，空=全部
     * @param int $withself 包含当前：1=包含，0=不包含【默认0】
     * @return array
     */
    public function get_children($data = array(), $pid_val = 0, $is_show_val = '', $withself = 0)
    {
        $result_array = array();
        if (empty($data)) {
            $data = $this->get_all($is_show_val);
        }
        if (empty($data)) {
            return array();
        }
        foreach ($data as $val) {
            if ($val[$this->pid] == $pid_val) {
                $level_val = $val[$this->level];
            }
            if ($withself != '') {
                if ($val[$this->id] == $pid_val) {
                    $result_array[] = $val;
                    $level_val = $val[$this->level] + 1;
                    //$level_val = $val[$this->level];
                }
            }
        }
        if (!isset($level_val)) {
            return array();
        }
        return array_merge($result_array, $this->_get_children($data, $pid_val, $level_val));
    }

    /**
     * 遍历获得所有下级
     * @param $data 所有数据
     * @param int $pid_val 上级唯一标识值
     * @param int $level_val 级别【默认0】
     * @return array
     */
    public function _get_children($data = array(), $pid_val = 0, $level_val = 0)
    {
        $result_array = array();
        $children_array = array();
        if (empty($data)) {
            return array();
        }
        foreach ($data as $val) {
            if ($val[$this->pid] == $pid_val && ($val[$this->level] == $level_val)) {
                $children_array[] = $val;
            }
        }
        if (empty($children_array)) {
            return array();
        }
        foreach ($children_array as $val) {
            $result_array[] = $val;
            $result = $this->_get_children($data, $val[$this->id], ($val[$this->level] + 1));
            if (!empty($result)) {
                $result_array = array_merge($result_array, $result);
            }
        }

        return $result_array;
    }

    /**
     * 获得当前及其上级
     * @param array $data 所有数据
     * @param int $id 唯一标识
     * @param string $is_show_val 审核：1=显示，0=隐藏，空=全部
     * @param int $withself 包含当前：1=包含，0=不包含【默认0】
     * @return array
     */
    public function get_parents($data = array(), $id = 0, $is_show_val = '', $withself = 0)
    {
        $result_array = array();
        if (empty($id)) {
            return array();
        }
        if (empty($data)) {
            $data = $this->get_all($is_show_val);
        }
        if (empty($data)) {
            return array();
        }
        $result_array[] = $res = $this->get_one($data, $id);
        if ($withself = '') {
            $result_array = array();
        }
        if (empty($res)) {
            return array();
        }
        return array_merge($this->_get_parents($data, $res[$this->pid]), $result_array);
    }

    /**
     * 遍历获得所有上级
     * @param $data 所有数据
     * @param int $pid_val 上级唯一标识值
     * @return array
     */
    public function _get_parents($data = array(), $pid_val = 0)
    {
        $result_array = array();
        if ($pid_val == 0) {
            return array();
        }
        foreach ($data as $val) {
            if ($val[$this->id] == $pid_val) {
                $result_array[] = $res = $val;
            }
        }
        if (empty($result_array)) {
            return array();
        }
        if ($pid_val == '') {
            return array();
        }
        $result = $this->_get_parents($data, $res[$this->pid]);
        if (!empty($result)) {
            $result_array = array_merge($result, $result_array);
        }
        return $result_array;
    }

    /**
     * 获得当前及其下级id
     * @param array $data 所有数据
     * @param int $pid_val 上级唯一标识值
     * @param string $is_show_val 审核：1=显示，0=隐藏，空=全部
     * @param int $withself 包含当前：1=包含，0=不包含【默认0】
     * @return array
     */
    public function get_children_id($data = array(), $pid_val = 0, $is_show_val = '', $withself = 0)
    {
        $id_array = array();
        if (empty($data)) {
            $data = $this->get_all($is_show_val);
        }
        if (empty($data)) {
            return array();
        }
        $result = $this->get_children($data, $pid_val, $is_show_val, $withself);
        foreach ($result as $val) {
            $id_array[] = $val[$this->id];
        }
        if (empty($id_array)) {
            return array();
        }
        return $id_array;
    }

    /**
     * 获得当前及其上级id
     * @param array $data 所有数据
     * @param int $id 下级唯一标识
     * @param string $is_show_val 审核：1=显示，0=隐藏，空=全部
     * @param int $withself 包含当前：1=包含，0=不包含【默认0】
     * @return array
     */
    public function get_parents_id($data = array(), $id = 0, $is_show_val = '', $withself = 0)
    {
        $id_array = array();
        if (empty($data)) {
            $data = $this->get_all($is_show_val);
        }
        if (empty($data)) {
            return array();
        }
        $result = $this->get_parents($data, $id, $is_show_val, $withself);
        foreach ($result as $val) {
            $id_array[] = $val[$this->id];
        }
        if (empty($id_array)) {
            return array();
        }
        return $id_array;
    }

    /**
     * 获得option【用户下拉列表】
     * @param array $data 所有数据
     * @param int $pid_val 上级标识值
     * @param string $select 选中项
     * @param string $disable 禁止选择：0=关闭，1=打开【默认1】
     * @param string $insert_or_update 新增/更新：0=新增，1=更新【默认0】
     * @param string $is_show_val 审核：0=隐藏，1=显示，空=全部
     * @param int $withself 包含当前：0=不包含,1=包含【默认0】
     * @param array $allow_select_array 允许选择列表
     * @param int $is_root 是否包含根目录：0=不包含，1=包含【默认1】
     * @return string|void
     */
    public function get_option($data = array(), $pid_val = 0, $select = 0, $disable = 1, $insert_or_update = 0, $is_show_val = '', $withself = 0, $allow_select_array = array(), $is_root = 1)
    {
        if (empty($data)) {
            $data = $this->get_all($is_show_val);
        }
        if ($is_root == 0) {
            $option_str = '';
        } else {
            $option_str = '<option value="0">根目录</option>';
        }
        $result = $this->get_children($data, $pid_val, $is_show_val, $withself);
        if ($select != '' || empty($allow_select_array)) {
            $selected_children_id = $this->get_children_id(array(), $select, $is_show_val, 1);
        }
        if (!empty($result)) {
            if ($insert_or_update == 1) {
                foreach ($result as $val) {
                    if ($val[$this->id] == $select) {
                        $selected_id = $val[$this->pid];
                    }
                }
            } else {
                $selected_id = $select;
            }
            foreach ($result as $val) {
                $disabled = '';
                if (!empty($selected_children_id)) {
                    if ($disable == 1) {
                        $disabled = (in_array($val[$this->id], $selected_children_id)) ? 'disabled' : '';
                    }
                }
                if (!empty($allow_select_array)) {
                    if ($disable == 1) {
                        $disabled = (!in_array($val[$this->id], $allow_select_array)) ? 'disabled' : '';
                    }
                }
                $selected = ($val[$this->id] == $selected_id) ? 'selected' : '';
                if ($is_root == 0 && $val[$this->level] == 0) {
                    $prefix = '';
                } else {
                    $prefix = '└─&nbsp;';
                }
                $space = str_repeat('&nbsp;&nbsp;', $val[$this->level] * 2);
                $option_str .= '<option value="' . $val[$this->id] . '" ' . $selected . ' ' . $disabled . '>' . $space . $prefix . $val[$this->name] . '</option>';
            }
        }
        return $option_str;
    }


    /**
     * 自动获取父级分类url
     * @param array $data 所有数据
     * @param string $is_show_val 审核：0=隐藏，1=显示，空=全部
     * @return mixed
     */
    function get_parents_category_url($data = array(), $is_show_val = '')
    {
        if (empty($data)) {
            $data = $this->get_all($is_show_val);
        }
        $result = array();
        foreach ($data as $key => $val) {
            if ($val[$this->level] == 0) {
                $result[$key] = $this->get_children($data, $val['id'], '', 1);
                foreach ($result[$key] as $res) {
                    if ($res['module'] OR $res['controller'] OR $res['method']) {
                        $module = ($res['module']) ? $res['module'] . '/' : '';
                        $controller = ($res['controller']) ? $res['controller'] . '/' : '';
                        $method = ($res['method']) ? $res['method'] . '/' : '';
                        $param = ($res['param']) ? '?' . $res['param'] : '?pid=' . $res['id'];
                        $url[$key] = site_url($module . $controller . $method . $param);
                        break;
                    }
                }
                if (empty($url[$key])) {
                    $url[$key] = 'javascript:;';
                }
            }
        }
        //var_dump($result);die;
        return $url;
    }

    /**
     * 新增
     * @param string $pid_val 待插入数据的上级标识值
     * @param array $array 待插入的数据
     * @return bool
     */
    public function insert_category($pid_val = '', $array = array())
    {
        if ($pid_val == '') {
            return false;
        }
        $parent_array = $this->get_one(array(), $pid_val);
        if (!empty($parent_array)) {
            if ($this->CI->db->field_exists($this->list_tpl, $this->tb)) {
                $field[$this->list_tpl] = $parent_array[$this->list_tpl];
            }
            if ($this->CI->db->field_exists($this->item_tpl, $this->tb)) {
                $field[$this->item_tpl] = $parent_array[$this->item_tpl];
            }
            $field[$this->level] = $parent_array[$this->level] + 1;
        } else {
            $field[$this->level] = 0;
        }
        $field[$this->pid] = $pid_val;
        $data = array_merge($array, $field);
        $bool = $this->CI->db->insert($this->tb, $data);
        return $this->CI->db->insert_id();
    }

    /**
     * 更新数据
     * @param string $id 标识
     * @param string $pid_val 上级标识值
     * @param array $array 更新的数据
     * @return bool
     */
    public function update_category($id = '', $pid_val = '', $array = array())
    {
        if ($id == '' OR $pid_val == '') {
            return false;
        }
        $parent_result = $this->get_one(array(), $pid_val);
        $result = $this->get_one(array(), $id);
        $parent_level = (!empty($parent_result)) ? $parent_result[$this->level] : -1;
        $new_level = $parent_level + 1;
        $level = $result[$this->level];
        $level_differ = $new_level - $level;
        if ($level_differ != 0) {
            $children_id = $this->get_children_id(array(), $id);
            if ($children_id != '') {
                foreach ($children_id as $val) {
                    $this->CI->db->set($this->level, $this->level . '+' . $level_differ
                        , false);
                    $this->CI->db->where($this->id, $val);
                    $this->CI->db->update($this->tb);
                }
            }
        }
        $field[$this->level] = $new_level;
        $field[$this->pid] = $pid_val;
        $data = array_merge($array, $field);
        $bool = $this->CI->db->where(array($this->id => $id))->update($this->tb, $data);
        return $bool;
    }

    /**
     * 删除数据 【删除当前以及下级数据】
     * @param string $id 标识
     * @return mixed
     */
    public function delete_category($id = '')
    {
        $id_array = $this->get_children_id(array(), $id, '', 1);
        $this->CI->db->where_in($this->id, $id_array);
        $this->CI->db->delete($this->tb);
        $rows = $this->CI->db->affected_rows();
        return $rows;
    }

}