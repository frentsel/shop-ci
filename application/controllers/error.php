<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'base_controller.php';

class Error extends BaseController {

    public function index($key = 404)
    {
        $data = $this->user_model->_default();
        $data['error'] = 404;
        $this->layout('error/index',$data);
    }
}