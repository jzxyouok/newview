<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/7/18
 * Time: 17:37
 * Email: 1056811341@qq.com
 */
class MY_Upload extends CI_Upload
{
    protected $relative_path;

    public function validate_upload_path()
    {
        $this->relative_path = $this->upload_path;
        str_replace('\\', '/', $this->upload_path);

        if ($this->upload_path === '') {
            $this->set_error('upload_no_filepath', 'error');
            return false;
        }

        if (stripos($this->upload_path, ':') != 1) {
            $DOCUMENT_ROOT = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
            $this->upload_path = str_replace('//', '/', $DOCUMENT_ROOT . $this->upload_path);
        }

        if (!is_dir($this->upload_path)) {
            mkdir($this->upload_path, 0777, true);
        }

        if (!is_really_writable($this->upload_path)) {
            $this->set_error('upload_not_writable', 'error');
            return false;
        }

        $this->upload_path = preg_replace('/(.+?)\/*$/', '\\1/', $this->upload_path);
        return true;
    }


    public function data($index = null)
    {
        $data = array(
            'file_name' => $this->file_name,
            'file_type' => $this->file_type,
            'file_path' => $this->upload_path,
            'full_path' => $this->upload_path . $this->file_name,
            'file_relative_path' => $this->relative_path,
            'full_relative_path' => $this->relative_path . $this->file_name,
            'raw_name' => str_replace($this->file_ext, '', $this->file_name),
            'orig_name' => $this->orig_name,
            'client_name' => $this->client_name,
            'file_ext' => $this->file_ext,
            'file_size' => $this->file_size,
            'is_image' => $this->is_image(),
            'image_width' => $this->image_width,
            'image_height' => $this->image_height,
            'image_type' => $this->image_type,
            'image_size_str' => $this->image_size_str,
        );

        if (!empty($index)) {
            return isset($data[$index]) ? $data[$index] : null;
        }

        return $data;
    }
}