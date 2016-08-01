<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/6/4
 * Time: 12:14
 * Email: 1056811341@qq.com
 */
class Operation_log extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('operation_log_model', 'operation_log');
        $this->template();
    }

    //模板内容
    public function template()
    {
        $tpl['tpl_search_btn'] = '<button type="button" data-name="searchbtn" class="btn btn-default">搜索</button>';
        $tpl['tpl_get_list_url'] = site_url('operation_log/get_list?pid=' . $this->pid);
        $this->load->vars($tpl);
    }

    public function index()
    {
        $this->common->set_auth(MYLOOK, $this->my_get_auth());
        $this->logs->add(MYLOOK);
        $this->load->view('operation_log/index.html');
    }

    //获得列表
    public function get_list()
    {
        $data['list'] = $this->operation_log->get_list();
        foreach ($data['list']['list'] as $key => $val) {
            $data['list']['list'][$key]['datetime'] = date('Y-m-d H:i:s', $val['time']);
        }
        echo json_encode($data);
    }
}