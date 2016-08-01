<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/5/4
 * Time: 18:47
 * Email: 1056811341@qq.com
 */
class Tip
{
    private $CI;

    //构造方法
    public function __construct()
    {
        $this->CI =& get_instance();
    }

    /**
     * 成功提示
     * @param string $message 提示信息
     * @param string $jump_url 跳转地址
     * @param string $detail 详细说明
     * @param int $wait_second 停留时间
     */
    public function show_success($message = '', $jump_url = '', $detail = '', $wait_second = 1)
    {
        if ($jump_url == '') {
            $jump_url = $_SERVER["HTTP_REFERER"];
        }
        $this->_dispatch_jump($message, 1, $jump_url, $detail, $wait_second);
    }

    /**
     * 失败提示
     * @param string $message 提示信息
     * @param string $jump_url 跳转地址
     * @param string $detail 详细说明
     * @param int $wait_second 停留时间
     */
    public function show_error($message = '', $jump_url = '', $detail = '', $wait_second = 3)
    {
        if ($jump_url == '') {
            $jump_url = 'javascript:history.back(-1);';
        }
        $this->_dispatch_jump($message, 0, $jump_url, $detail, $wait_second);
    }

    /**
     * 默认跳转操作 支持错误导向和正确跳转
     * @param string $message 提示信息
     * @param string $status 状态：0=失败，1=成功
     * @param string $jump_url 跳转地址
     * @param string $detail 详细说明
     * @param $wait_second 停留时间
     */
    private function _dispatch_jump($message = '', $status = '', $jump_url = '', $detail = '', $wait_second)
    {
        $data['item'] = array(
            'status' => $status,
            'message' => $message,
            'jump_url' => $jump_url,
            'detail' => $detail,
            'wait_second' => $wait_second
        );
        echo $this->CI->load->view('tip/dispatch_jump.html', $data, true);
        exit();
    }


}