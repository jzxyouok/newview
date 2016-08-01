<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/4/30
 * Time: 22:33
 * Email: 1056811341@qq.com
 */
class Menu extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->template();
        $this->load->model('menu_model');
    }

    //模板内容
    function template()
    {
        $tpl['tpl_insert_btn'] = $this->common->set_auth(MYINSERT, $this->my_get_auth(), '<a href="' . site_url('menu/insert?pid=' . $this->pid) . '" class="btn btn-default">新增菜单</a>');
        $tpl['tpl_get_list_url'] = site_url('menu/get_list?pid=' . $this->pid);
        $tpl['tpl_delete_url'] = site_url('menu/delete?pid=' . $this->pid);
        $tpl['tpl_save_url'] = site_url('menu/save?pid=' . $this->pid);
        $this->load->vars($tpl);
    }

    public function index()
    {
        $this->common->set_auth(MYLOOK, $this->my_get_auth());
        $this->logs->add(MYLOOK);
        $this->load->view('menu/index.html');
    }

    //获得列表
    public function get_list()
    {
        $data['list'] = $this->menu_model->get_list();
        foreach ($data['list']['list'] as $key => $val) {
            $module = ($val['module']) ? $val['module'] . '/' : '';
            $controller = ($val['controller']) ? $val['controller'] . '/' : '';
            $method = ($val['method']) ? $val['method'] : '';
            $param = ($val['param']) ? '?' . $val['param'] : '';
            $data['list']['list'][$key]['url'] = $module . $controller . $method . $param;
            foreach ($this->enum->get($this->config->item('is_show', 'dict')) as $item) {
                if ($item['ident'] == $val['is_show'])
                    $data['list']['list'][$key]['is_show'] = $item['name'];
            }
            $data['list']['list'][$key]['update_btn'] = '<a href="' . site_url('menu/update?pid=' . $this->pid . '&id=' . $val['id']) . '">编辑</a>';
            $data['list']['list'][$key]['insert_next_btn'] = '<a href="' . site_url('menu/insert?pid=' . $this->pid . '&id=' . $val['id']) . '">新增下级</a>';
            $data['list']['list'][$key]['del_btn'] = '<a href="javascript:;" data-name="delete" data-id="' . $val['id'] . '">删除</a>';
            $data['list']['list'][$key]['prefix'] = str_repeat('&nbsp;&nbsp;', $val['level'] * 2) . ((!empty($val['level']) ? '└─&nbsp;' : ''));
            foreach ($this->enum->get($this->config->item('user_type', 'dict')) as $item) {
                if (($item['ident'] == $val['user_type']))
                    $data['list']['list'][$key]['user_type'] = $item['name'];
            }
        }
        echo json_encode($data);
    }

    //新增
    public function insert()
    {
        $this->common->set_auth(MYINSERT, $this->my_get_auth());
        $this->logs->add(MYINSERT);
        $data['menu_auth_checkbox'] = $this->get_menu_auth();
        $data['category_option'] = $this->menu_model->get_category_option();
        $data['user_type'] = $this->enum->get($this->config->item('user_type', 'dict'));
        foreach ($data['user_type'] as $key => $val) {
            $data['user_type'][$key]['checked'] = ($key == 0) ? 'checked' : '';
        }
        $data['is_show'] = $this->enum->get($this->config->item('is_show', 'dict'));
        foreach ($data['is_show'] as $key => $val) {
            $data['is_show'][$key]['checked'] = ($key == 0) ? 'checked' : '';
        }
        $this->load->view('menu/insert.html', $data);
    }

    //更新
    public function update()
    {
        $this->common->set_auth(MYUPDATE, $this->my_get_auth());
        $this->logs->add(MYUPDATE);
        $data['item'] = $this->menu_model->update();
        $data['menu_auth_checkbox'] = $this->get_menu_auth($data['item']['id']);
        $data['is_show'] = $this->enum->get($this->config->item('is_show', 'dict'));
        foreach ($data['is_show'] as $key => $val) {
            $data['is_show'][$key]['checked'] = ($val['ident'] == $data['item']['is_show']) ? 'checked' : '';
        }
        $data['category_option'] = $this->menu_model->get_category_option(1);
        $data['user_type'] = $this->enum->get($this->config->item('user_type', 'dict'));
        foreach ($data['user_type'] as $key => $val) {
            $data['user_type'][$key]['checked'] = ($val['ident'] == $data['item']['user_type']) ? 'checked' : '';
        }
        $this->load->view('menu/update.html', $data);
    }

    //保存
    public function save()
    {
        $bool = $this->menu_model->save();
        if ($bool) {
            switch ($this->is_save) {
                case '1':
                    $this->tip->show_success('操作成功！', site_url('menu?pid=' . $this->pid));
                    break;
                case '2':
                    $this->tip->show_success('操作成功！', $this->peferer);
                    break;
            }
        } else {
            $this->tip->show_error('操作失败！', site_url('menu?pid=' . $this->pid));
        }
    }

    //删除
    public function delete()
    {
        $this->common->set_auth(MYDELETE, $this->my_get_auth());
        $this->logs->add(MYDELETE);
        $bool = $this->menu_model->delete();
        echo $bool;
    }

    /**
     * 获得权限
     * @param string $menu_id 权限标识
     * @return string
     */
    public function get_menu_auth($menu_id = '')
    {
        $menu_to_auth = ($menu_id) ? $this->menu_model->get_menu_to_auth($menu_id) : array();
        $result = $this->menu_model->menu_auth();
        $html = '';
        foreach ($result as $val) {
            $checked = (in_array($val['id'], $menu_to_auth)) ? 'checked' : '';
            $html .= '<label><input type="checkbox" name="menu_auth[]" value="' . $val['id'] . '" ' . $checked . '/><ins></ins>' . $val['name'] . "[" . $val['ident'] . "]" . '</label>';
        }
        return $html;
    }
}