<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/5/7
 * Time: 9:59
 * Email: 1056811341@qq.com
 */
class Information extends MY_Controller
{
    protected $cid;

    public function __construct()
    {
        parent::__construct();
        $this->cid = $this->input->get('cid');
        $this->load->model('information_model', 'information');
        $this->load->library('category', array('tb' => $this->config->item('infocategory', 'tb'), 'is_show_val' => 1), 'my_category');
        $this->get_category_list();
    }

    public function index()
    {
        $this->common->set_auth(MYLOOK, $this->my_get_auth());
        $this->logs->add(MYLOOK);
        $this->load->view('information/index.html');
    }

    //获得分类列表
    public function get_category_list()
    {
        $plevel = $i = 0;
        $str_html = '<ul data-level="0">';
        $categoty_list = $this->my_category->get_children();
        $infomodel = $this->get_infomodel();
        foreach ($categoty_list as $val) {
            $url = 'javascript:;';
            $level = $val['level'];
            if ($this->cid == $val['id']) {
                $highlight = 'current';
            } else {
                $highlight = '';
            }
            if ($level < $plevel) {
                $str_html .= '</li>' . str_repeat('</ul></li>', $plevel - $level);
            } elseif ($level > $plevel) {
                $str_html .= '<ul data-level="' . $level . '">';
            } else {
                $str_html .= '</li>';
            }
            foreach ($infomodel as $item) {
                if ($item['id'] == $val['infomodel_id']) {
                    $url = site_url(rtrim($item['controller'], '/') . '?pid=' . $this->pid . '&cid=' . $val['id']);
                }
            }
            $str_html .= '<li>';
            $str_html .= '<a class="' . $highlight . '" href="' . $url . '" data-name="mtree_link">';
            $str_html .= '<span data-name="mtree_indent"></span>';
            $str_html .= '<span data-name="mtree_btn"></span>';
            $str_html .= '<span data-name="mtree_name">' . $val['name'] . '</span>';
            $str_html .= '</a>';
            $plevel = $level;
            $i++;
        }
        $str_html .= '<ul>';
        $data['category_list'] = $str_html;
        $this->load->vars($data);
    }

    //获得栏目类型
    public function get_infomodel()
    {
        $result = $this->db->get($this->config->item('infomodel', 'tb'))->result_array();
        return $result;
    }

}