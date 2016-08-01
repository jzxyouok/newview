<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/7/17
 * Time: 16:57
 * Email: 1056811341@qq.com
 */
class Uploadify extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->template();
    }

    public function template()
    {
        $tpl['tpl_timestamp'] = time();
        $tpl['tpl_token'] = md5('unique_salt' . $tpl['tpl_timestamp']);
        $tpl['tpl_uploadify_swf'] = base_url('plugin/uploadify/uploadify.swf');
        $tpl['tpl_upload_server_url'] = site_url('uploadify/upload');
        $this->load->vars($tpl);
    }

    public function index()
    {
        $this->load->view('uploadify/index.html');
    }

    //文件上传
    public function upload()
    {
        $config['upload_path'] = '/uploads/' . date('Ymdhis', time()) . '/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['file_name'] = md5(uniqid(microtime(true), true));

        $this->load->library('upload', $config);
        $this->upload->do_upload('files');
        $data = $this->upload->data();
        $data['insert_id'] = $this->save($data);
        echo json_encode($data);
    }

    //保存至数据库
    public function save($data = array())
    {
        $vals = array(
            'file_name' => $data['file_name'],
            'file_type' => $data['file_type'],
            'file_path' => $data['file_path'],
            'full_path' => $data['full_path'],
            'file_relative_path' => $data['file_relative_path'],
            'full_relative_path' => $data['full_relative_path'],
            'raw_name' => $data['raw_name'],
            'orig_name' => $data['orig_name'],
            'client_name' => $data['client_name'],
            'file_ext' => $data['file_ext'],
            'file_size' => $data['file_size'],
            'is_image' => $data['is_image'],
            'image_width' => $data['image_width'],
            'image_height' => $data['image_height'],
            'image_type' => $data['image_type'],
            'image_size_str' => $data['image_size_str'],
            'create_time' => time(),
        );
        $this->db->insert($this->config->item('upload', 'tb'), $vals);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

}