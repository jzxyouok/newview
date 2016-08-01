<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/5/29
 * Time: 14:17
 * Email: 1056811341@qq.com
 */
class Update_psw extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('update_psw_model', 'update_psw');
        $this->template();
    }

    //模板内容
    public function template()
    {
        $tpl['tpl_save_url'] = site_url('update_psw/save?pid=' . $this->pid);
        $tpl['tpl_save_btn'] = $this->common->set_auth(MYUPDATE, $this->my_get_auth(), '<button type="submit" name="is_save" value="1" class="btn btn-default btn-primary">保存</button>');
        $tpl['tpl_check_old_password_url'] = site_url('update_psw/check_old_password');
        $this->load->vars($tpl);
    }

    public function index()
    {
        $this->common->set_auth(MYLOOK, $this->my_get_auth());
        $this->logs->add(MYLOOK);
        $data['item'] = $this->update_psw->index();
        $this->load->view('update_psw/index.html', $data);
    }

    //保存
    public function save()
    {
        $this->common->set_auth(MYUPDATE, $this->my_get_auth());
        $this->logs->add(MYUPDATE);
        $bool = $this->update_psw->save();
        if ($bool) {
            $this->tip->show_success('操作成功！', site_url('update_psw?pid=' . $this->pid));
        } else {
            $this->tip->show_success('操作成功！', $this->peferer);
        }
    }

    //验证就密码是否正确
    public function check_old_password()
    {
        $rows = $this->update_psw->check_old_password();
        echo $rows;
    }
}