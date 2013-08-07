<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'base_controller.php';

class Main extends BaseController {

    public function index()
    {
        $data = $this->user_model->_default();
        $data['products'] = $this->user_model->get_products();
        $this->layout('main/index',$data);
    }
}