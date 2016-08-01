<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/5/31
 * Time: 21:53
 * Email: 1056811341@qq.com
 */
class Configure extends MY_Controller
{
    protected $gid;

    public function __construct()
    {
        parent::__construct();
        $this->template();
        $this->load->model('configure_model', 'configure');
        $this->gid = $this->input->get('gid');
        if (empty($this->gid)) {
            $result = $this->configure->get_config_group();
            foreach ($result as $val) {
                $this->gid = $val['id'];
                break;
            }
        }
    }

    //模板内容
    public function template()
    {
        $tpl['tpl_save_url'] = site_url('configure/save?pid=' . $this->pid . '&gid=' . $this->gid);
        $tpl['tpl_save_btn'] = $this->common->set_auth(MYUPDATE, $this->my_get_auth(), '<button type="submit" class="btn btn-default btn-primary">更新</button>');
        $this->load->vars($tpl);
    }

    public function index()
    {
        $this->common->set_auth(MYLOOK, $this->my_get_auth());
        $this->logs->add(MYLOOK);
        $data['config_group'] = $this->get_config_group($this->gid);
        $data['forms'] = $this->configure->get_forms($this->gid);
        foreach ($data['forms'] as $key => $val) {
            $data['forms'][$key]['param_array'] = $this->transform_param($val['param']);
            $data['forms'][$key]['val'] = ($val['type'] == 'checkbox') ? explode(',', $val['value']) : $val['value'];
        }
        $this->load->view('configure/index.html', $data);
    }

    /**
     * 获得配置组菜单
     * @param string $group_id 配置组标识
     * @return string
     */
    public function get_config_group($group_id = '')
    {
        $html = '';
        $result = $this->configure->get_config_group();
        if (count($result) > 1) {
            foreach ($result as $key => $val) {
                if (!empty($gid)) {
                    $active = ($group_id == $val['id']) ? 'active' : '';
                } else {
                    $active = ($key == 0) ? 'active' : '';
                }
                $html .= '<a href="' . site_url('configure?pid=' . $this->pid . '&gid=' . $val['id']) . '" class="btn btn-default ' . $active . '">' . $val['name'] . '</a>';
            }
        }
        return $html;
    }

    /**
     * 转换参数
     * @param string $str 待转换字符串
     */
    public function transform_param($str = '')
    {
        if ($str == '') return;
        $array = explode(',', $str);
        if (!empty($array)) {
            foreach ($array as $key => $item) {
                $result[$key] = explode('|', $item);
                $result[$key] = array(
                    'value' => $result[$key][0],
                    'name' => $result[$key][1]
                );
            }
        }
        return $result;
    }

    //保存
    public function save()
    {
        $this->common->set_auth(MYUPDATE, $this->my_get_auth());
        $this->logs->add(MYUPDATE);
        $rows = $this->configure->save();
        if ($rows) {
            $this->tip->show_success('操作成功！', site_url('configure?pid=' . $this->pid . '&gid=' . $this->gid));
        } else {
            $this->tip->show_error('操作失败！', site_url('configure?pid=' . $this->pid . '&gid=' . $this->gid));
        }
    }
}