<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/6/28
 * Time: 15:34
 * Email: 1056811341@qq.com
 */
class Infocategory extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->template();
        $this->load->model('infocategory_model', 'infocategory');
    }

    //模板内容
    function template()
    {
        $tpl['tpl_insert_btn'] = $this->common->set_auth(MYINSERT, $this->my_get_auth(), '<a href="' . site_url('infocategory/insert?pid=' . $this->pid) . '" class="btn btn-default">新增分类</a>');
        $tpl['tpl_get_list_url'] = site_url('infocategory/get_list?pid=' . $this->pid);
        $tpl['tpl_delete_url'] = site_url('infocategory/delete?pid=' . $this->pid);
        $tpl['tpl_save_url'] = site_url('infocategory/save?pid=' . $this->pid);
        $this->load->vars($tpl);
    }

    public function index()
    {
        $this->load->view('infocategory/index.html');
    }

    //获得列表
    public function get_list()
    {
        $data['list'] = $this->infocategory->get_list();
        foreach ($data['list']['list'] as $key => $val) {
            foreach ($this->enum->get($this->config->item('is_show', 'dict')) as $item) {
                if ($item['ident'] == $val['is_show'])
                    $data['list']['list'][$key]['is_show'] = $item['name'];
            }
            $data['list']['list'][$key]['update_btn'] = '<a href="' . site_url('infocategory/update?pid=' . $this->pid . '&id=' . $val['id']) . '">编辑</a>';
            $data['list']['list'][$key]['insert_next_btn'] = '<a href="' . site_url('infocategory/insert?pid=' . $this->pid . '&id=' . $val['id']) . '">新增下级</a>';
            $data['list']['list'][$key]['del_btn'] = '<a href="javascript:;" data-name="delete" data-id="' . $val['id'] . '">删除</a>';
            $data['list']['list'][$key]['prefix'] = str_repeat('&nbsp;&nbsp;', $val['level'] * 2) . ((!empty($val['level']) ? '└─&nbsp;' : ''));
        }
        echo json_encode($data);
    }

    //新增
    public function insert()
    {
        $this->common->set_auth(MYINSERT, $this->my_get_auth());
        $this->logs->add(MYINSERT);
        $data['category_option'] = $this->infocategory->get_category_option();
        $data['infomodel'] = $this->infocategory->get_infomodel();
        $data['is_show'] = $this->enum->get($this->config->item('is_show', 'dict'));
        foreach ($data['is_show'] as $key => $val) {
            $data['is_show'][$key]['checked'] = ($key == 0) ? 'checked' : '';
        }
        $this->load->view('infocategory/insert.html', $data);
    }

    //更新
    public function update()
    {
        $this->common->set_auth(MYUPDATE, $this->my_get_auth());
        $this->logs->add(MYUPDATE);
        $data['item'] = $item = $this->infocategory->update();
        $infomodel = $this->infocategory->get_infomodel();
        $infomodel_option = '';
        foreach ($infomodel as $val) {
            $selected = $this->common->selected($data['item']['infomodel_id'], $val['id']);
            $infomodel_option .= '<option value="' . $val['id'] . '" ' . $selected . '>' . $val['name'] . '</option>';
        }
        $data['infomodel_option'] = $infomodel_option;
        $data['is_show'] = $this->enum->get($this->config->item('is_show', 'dict'));
        foreach ($data['is_show'] as $key => $val) {
            $data['is_show'][$key]['checked'] = ($val['ident'] == $data['item']['is_show']) ? 'checked' : '';
        }
        $data['category_option'] = $this->infocategory->get_category_option(1);
        $this->load->view('infocategory/update.html', $data);
    }

    //保存
    public function save()
    {
        $bool = $this->infocategory->save();
        if ($bool) {
            switch ($this->is_save) {
                case '1':
                    $this->tip->show_success('操作成功！', site_url('infocategory?pid=' . $this->pid));
                    break;
                case '2':
                    $this->tip->show_success('操作成功！', $this->peferer);
                    break;
            }
        } else {
            $this->tip->show_error('操作失败！', site_url('infocategory?pid=' . $this->pid));
        }
    }

    //删除
    public function delete()
    {
        echo $this->infocategory->delete();
    }
}