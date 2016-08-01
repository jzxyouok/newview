<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/7/7
 * Time: 14:48
 * Email: 1056811341@qq.com
 */
class Enum
{
    protected $CI;
    protected $tb_dict = 'dict';

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    /**
     * 枚举类型
     * @param string $param
     * @return array|mixed
     */
    public function type($param = '')
    {
        $arr = array(
            1 => '状态',
            2 => '用户类型',
            3 => '后台菜单权限',
            4 => '配置项类型',
        );
        if (is_array($param)) {
            foreach ($param as $val) {
                $data[] = $arr[$val];
            }
            return $data;
        } elseif ($param != '') {
            return $arr[$param];
        } else {
            return $arr;
        }
    }

    /**
     * 获得枚举
     * @param string $type 枚举类型：类型即为type中$arr的键值
     * @param string $ident 标识
     */
    public function get($type = '', $ident = '')
    {
        if ($type != '') {
            $this->CI->db->where('type', $type);
        }
        if ($ident != '') {
            $this->CI->db->where('ident', $ident);
        }
        $this->CI->db->from($this->tb_dict);
        $this->CI->db->order_by('sort ASC,id ASC');
        if ($ident != '') {
            return $this->CI->db->get()->row_array();
        } else {
            return $this->CI->db->get()->result_array();
        }
    }


}