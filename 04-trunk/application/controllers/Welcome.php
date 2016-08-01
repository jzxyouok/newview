<?php
defined('BASEPATH') OR exit('Error');

/**
 * Author: 孟祥涵
 * Date: 2016/8/1
 * Time: 21:29
 * Email: 1056811341@qq.com
 */
class Welcome extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('index.html');
    }
}