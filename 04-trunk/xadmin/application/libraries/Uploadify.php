<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/7/22
 * Time: 22:23
 * Email: 1056811341@qq.com
 */
class Uploadify
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    /**
     * 上传的文件与数据进行关联
     * @param array $upload 上传文件标识
     * @param string $data_id 数据标识
     * @param string $tbname 数据所属表名
     */
    public function data_to_upload($upload = array(), $data_id = '', $tbname = '')
    {
        //删除记录
        if ($data_id != '' && $tbname != '') {
            $this->del_data_to_upload($data_id, $tbname);
        }

        if (empty($upload) OR $data_id == '' OR $tbname == '') {
            return false;
        }
        //新增记录
        $vals = array();
        foreach ($upload as $key => $val) {
            $vals[$key] = array(
                'upload_id' => $val,
                'data_id' => $data_id,
                'tbname' => $tbname
            );
        }
        $bool = $this->CI->db->insert_batch($this->CI->config->item('data_to_upload', 'tb'), $vals);
        return $bool;
    }

    /**
     * 删除文件与数据关系
     * @param string $data_id 数据标识
     * @param string $tbname 数据所属表名
     */
    public function del_data_to_upload($data_id = '', $tbname = '')
    {
        if ($data_id == '' OR $tbname == '') {
            return;
        }
        $this->CI->db->where(array('data_id' => $data_id, 'tbname' => $tbname));
        $bool = $this->CI->db->delete($this->CI->config->item('data_to_upload', 'tb'));
        return $bool;
    }

    /**
     * 上传文件列表【编辑时使用】
     * @param string $queue input名称
     * @param string $file_id 文件标识
     * @param string $file_path 文件路径
     * @param string $file_ext 文件后缀
     * @param string $file_is_image 是否为图片
     * @return bool
     */
    public function upload_queue($queue = '', $file_id = '', $file_path = '', $file_ext = '', $file_is_image = '')
    {
        if ($queue == '' OR $file_path == '' OR $file_id == '' OR $file_ext == '' OR $file_is_image == '') {
            return;
        }
        $strHtml = '';
        $file_id_arr = explode(',', $file_id);
        $file_path_arr = explode(',', $file_path);
        $file_ext_arr = explode(',', $file_ext);
        $file_is_image_arr = explode(',', $file_is_image);
        foreach ($file_id_arr as $key => $val) {
            $strHtml .= '<li>';
            $strHtml .= '<div class="thumbnail">';
            if ($file_is_image_arr[$key]) {
                $strHtml .= '<img src="' . $file_path_arr[$key] . '">';
            } else {
                switch ($file_ext_arr[$key]) {
                    case '.docx':
                    case '.doc':
                        $strHtml .= '<i class="fa fa-file-word-o"></i>';
                        break;
                    case '.xlsx':
                    case '.xls':
                        $strHtml .= '<i class="fa fa-file-excel-o"></i>';
                        break;
                    case '.pptx':
                    case '.ppt':
                        $strHtml .= '<i class="fa fa-file-powerpoint-o"></i>';
                        break;
                    case '.pdf':
                        $strHtml .= '<i class="fa fa-file-pdf-o"></i>';
                        break;
                    case '.txt':
                        $strHtml .= '<i class="fa fa-file-text-o"></i>';
                        break;
                    case '.rar':
                    case '.zip':
                    case '.7z':
                        $strHtml .= '<i class="fa fa-file-zip-o"></i>';
                        break;
                    case '.mp3':
                    case '.wav':
                    case '.rm':
                        $strHtml .= '<i class="fa fa-file-sound-o"></i>';
                        break;
                    case '.avi':
                    case '.wma':
                    case '.rmvb':
                    case '.flv':
                    case '.mp4':
                    case '.3gp':
                    case '.flash':
                        $strHtml .= '<i class="fa fa-file-movie-o"></i>';
                        break;
                    default:
                        $strHtml .= '<i class="fa fa-file-o"></i>';
                        break;
                }
                $strHtml .= ' ' . $file_ext_arr[$key];
            }
            $strHtml .= '</div>';
            $strHtml .= '<div class="opera">';
            $strHtml .= '<div class="row">';
            // $strHtml .= '<a href="javascript:;" class="btn btn-default btn-sm pull-left">编辑</a>';
            $strHtml .= '<a href="javascript:;" class="btn btn-danger btn-sm pull-right" data-name="upload_remove">删除</a>';
            $strHtml .= '</div>';
            $strHtml .= '</div>';
            $strHtml .= '<input type="hidden" name="' . $queue . '[]" value="' . $val . '">';
            $strHtml .= '</li>';
        }
        return $strHtml;
    }
}