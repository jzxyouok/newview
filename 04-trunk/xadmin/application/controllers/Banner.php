<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/5/7
 * Time: 9:59
 * Email: 1056811341@qq.com
 */
class Banner extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->template();
        $this->load->library('uploadify');
        $this->load->model('banner_model', 'banner');
    }

    //模板内容
    public function template()
    {
        $tpl['tpl_insert_btn'] = $this->common->set_auth(MYINSERT, $this->my_get_auth(), '<a href="' . site_url('banner/insert?pid=' . $this->pid) . '" class="btn btn-default">新增幻灯片</a>');
        $tpl['tpl_search_btn'] = '<button type="button" data-name="searchbtn" class="btn btn-default">搜索</button>';
        $tpl['tpl_batch_del_btn'] = $this->common->set_auth(MYDELETE, $this->my_get_auth(), '<li><a href="javascript:;" data-name="batch_del" data-tb="' . $this->config->item('banner', 'tb') . '" data-checkname="id" data-url = "' . site_url('ajax/batch_del?pid=' . $this->pid) . '">批量删除</a></li>');
        $tpl['tpl_update_url'] = site_url('banner/update?pid=' . $this->pid);
        $tpl['tpl_get_list_url'] = site_url('banner/get_list?pid=' . $this->pid);
        $tpl['tpl_save_url'] = site_url('banner/save?pid=' . $this->pid);
        $this->load->vars($tpl);
    }

    public function index()
    {
        $this->common->set_auth(MYLOOK, $this->my_get_auth());
        $this->logs->add(MYLOOK);
        $this->load->view('banner/index.html');
    }

    //获得列表
    public function get_list()
    {
        $data['list'] = $this->banner->get_list();
        foreach ($data['list']['list'] as $key => $val) {
            foreach ($this->enum->get($this->config->item('is_show', 'dict')) as $item) {
                if ($item['ident'] == $val['is_show'])
                    $data['list']['list'][$key]['is_show'] = $item['name'];
            }
            $data['list']['list'][$key]['update_btn'] = $this->common->set_auth(MYUPDATE, $this->my_get_auth(), '<a href="' . site_url('banner/update?pid=' . $this->pid . '&id=' . $val['id']) . '">编辑</a>');
            $data['list']['list'][$key]['del_btn'] = $this->common->set_auth(MYDELETE, $this->my_get_auth(), '<a href="javascript:;" data-name="del" data-tb="' . $this->config->item('banner', 'tb') . '" data-id="' . $val['id'] . '" data-url="' . site_url('ajax/del?pid=' . $this->pid) . '">删除</a>');
        }
        echo json_encode($data);
    }

    //新增
    public function insert()
    {
        $this->common->set_auth(MYINSERT, $this->my_get_auth());
        $this->logs->add(MYINSERT);
        $data['is_show'] = $this->enum->get($this->config->item('is_show', 'dict'));
        foreach ($data['is_show'] as $key => $val) {
            $data['is_show'][$key]['checked'] = ($key == 0) ? 'checked' : '';
        }
        $this->load->view('banner/insert.html', $data);
    }

    //更新
    public function update()
    {
        $this->common->set_auth(MYUPDATE, $this->my_get_auth());
        $this->logs->add(MYUPDATE);
        $data['item'] = $this->banner->update();
        $data['image'] = $this->uploadify->upload_queue('fileupload', $data['item']['file_id'], $data['item']['file_path'], $data['item']['file_ext'], $data['item']['file_is_image']);
        $data['is_show'] = $this->enum->get($this->config->item('is_show', 'dict'));
        foreach ($data['is_show'] as $key => $val) {
            $data['is_show'][$key]['checked'] = ($val['ident'] == $data['item']['is_show']) ? 'checked' : '';
        }
        $this->load->view('banner/update.html', $data);
    }

    //保存
    public function save()
    {
        $bool = $this->banner->save();
        if ($bool) {
            switch ($this->is_save) {
                case '1':
                    $this->tip->show_success('操作成功！', site_url('banner?pid=' . $this->pid));
                    break;
                case '2':
                    $this->tip->show_success('操作成功！', $this->peferer);
                    break;
            }
        } else {
            $this->tip->show_error('操作失败！', site_url('banner?pid=' . $this->pid));
        }
    }

}