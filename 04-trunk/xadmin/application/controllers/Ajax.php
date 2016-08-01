<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/5/9
 * Time: 16:31
 * Email: 1056811341@qq.com
 */
class Ajax extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ajax_model', 'ajax');
    }

    //删除
    public function del()
    {
        $this->logs->add(MYDELETE);
        $rows = $this->ajax->del();
        echo $rows;
    }

    //批量删除
    public function batch_del()
    {
        $this->logs->add(MYDELETE);
        $rows = $this->ajax->batch_del();
        echo $rows;
    }
}