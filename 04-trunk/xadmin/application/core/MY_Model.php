<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/7/8
 * Time: 11:01
 * Email: 1056811341@qq.com
 */
class MY_Model extends CI_Model
{
    //构造函数
    public function __construct()
    {
        parent::__construct();
    }

    //获取管理员菜单
    public function get_menu()
    {
        $role_id = $_SESSION['session']['role_id'];
        $role_type = $_SESSION['session']['role_type'];
        $user_type = $_SESSION['session']['user_type'];

        if ($user_type == 'developer') {//开发者
            $sql = "SELECT *
                FROM (
                        SELECT m.*
                        FROM " . $this->db->dbprefix . $this->config->item('menu_to_auth', 'tb') . " AS mta
                        INNER JOIN " . $this->db->dbprefix . $this->config->item('menu', 'tb') . " AS m ON m.id = mta.menu_id
                        WHERE m.is_show = 1
                    ) t
                GROUP BY id ORDER BY sort ASC,id ASC";
        } else {
            if ($role_type == 1) {//超级管理员
                $sql = "SELECT *
                FROM (
                        SELECT m.*
                        FROM " . $this->db->dbprefix . $this->config->item('menu_to_auth', 'tb') . " AS mta
                        INNER JOIN " . $this->db->dbprefix . $this->config->item('menu', 'tb') . " AS m ON m.id = mta.menu_id
                        WHERE m.is_show = 1 AND m.user_type = '" . $user_type . "'
                    ) t
                GROUP BY id ORDER BY sort ASC,id ASC";
            } else {//普通管理员
                $sql = "SELECT *
                FROM (
                        SELECT m.*
                        FROM " . $this->db->dbprefix . $this->config->item('role_to_auth', 'tb') . " AS rta
                        INNER JOIN " . $this->db->dbprefix . $this->config->item('menu', 'tb') . " AS m ON m.id = rta.menu_id
                        WHERE rta.role_id = " . $role_id . " AND m.is_show = 1 AND m.user_type = '" . $user_type . "'
                    ) t
                GROUP BY id ORDER BY sort ASC,id ASC";
            }
        }
        $result = $this->db->query($sql)->result_array();
        //echo $this->db->last_query();die;
        return $result;
    }
}