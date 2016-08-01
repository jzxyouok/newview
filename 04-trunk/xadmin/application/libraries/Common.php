<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/5/11
 * Time: 10:29
 * Email: 1056811341@qq.com
 */
class Common
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }


    /**
     * 设置单选框/复选框选中状态
     * @param null $param 参数
     * @param      $check 选中的值
     * @return string|void
     */
    public function checked($param = '', $check = '')
    {
        if (is_array($check)) {
            if (empty($check)) {
                return;
            } elseif (in_array($param, $check)) {
                return 'checked';
            } else {
                return;
            }
        } else {
            if ($check == '') {
                return;
            } elseif ($param == $check) {
                return 'checked';
            } else {
                return;
            }
        }
    }

    /**
     * 设置下拉菜单选中状态
     * @param string $param
     * @param string $selected
     */
    public function selected($param = '', $selected = '')
    {
        if ($param == '' OR $selected == '') {
            return;
        }
        if ($param == $selected) {
            return 'selected';
        } else {
            return;
        }
    }

    /**
     * 情景文本颜色
     * @param null $param 参数
     * @param array $explain 例：array('参数'=>array('转译','颜色'))
     * @return string|void
     */
    public function set_state($param = '', $explain = array())
    {
        if ($param == '' OR empty($explain)) {
            return;
        }
        foreach ($explain as $key => $val) {
            if ($param == $key) {
                return '<i style="color:' . $val[1] . '">' . $val[0] . '</i>';
            }
        }
    }

    /**
     * 多维数组转一维数组
     * @param array $array 原始数据
     * @param array $num 判断是否为第一次执行此函数，防止多次转换时存在冗余
     * @return array
     */
    public function multi_to_one($array = array(), $num = 1)
    {
        static $result = array();
        //第一次执行时清空数组
        if ($num == 1) {
            $result = array();
        }
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                $this->multi_to_one($val, $num++);
            } else {
                $result[] = $val;
            }
        }
        return $result;
    }

    /**
     * 设置权限
     * @param string $ident 权限标识
     * @param array $array 栏目所拥有权限
     * @param string $str 返回字符串
     * @return string
     */
    public function set_auth($ident = '', $array = array(), $str = '')
    {
        if ($str != '') {
            //设置入口
            if (in_array(strtolower($ident), $array)) {
                return $str;
            } else {
                return '';
            }
        } else {
            //判断是否有权限访问此method
            if (!in_array(strtolower($ident), $array)) {
                $this->CI->tip->show_error('暂无权限访问此模块', '0');
            }
        }
    }

}