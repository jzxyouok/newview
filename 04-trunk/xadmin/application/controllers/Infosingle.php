<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/7/5
 * Time: 13:16
 * Email: 1056811341@qq.com
 */
require_once 'Information.php';

class Infosingle extends Information
{
    public function __construct()
    {
        parent::__construct();
        $this->template();
        $this->load->model('infosingle_model', 'infosingle');
    }

    //模板内容
    public function template()
    {
        $tpl['tpl_save_url'] = site_url('infosingle/save?pid=' . $this->pid . '&cid=' . $this->cid);
        $this->load->vars($tpl);
    }

    public function index()
    {
        $data['item'] = $this->infosingle->index();
        $data['update_time'] = date('Y-m-d H:i:s', time());
        $this->load->view('infosingle/index.html', $data);
    }

    //保存
    public function save()
    {
        $bool = $this->infosingle->save();
        if ($bool) {
            $this->tip->show_success('操作成功！', site_url('infosingle?pid=' . $this->pid . '&cid=' . $this->cid));
        } else {
            $this->tip->show_error('操作失败！', site_url('banner?pid=' . $this->pid . '&cid=' . $this->cid));
        }
    }
}