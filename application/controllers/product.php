<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'base_controller.php';

class Product extends BaseController {

    public function index($id = 0)
    {
        $this->load->model('product_model');
        $data = $this->product_model->_default();
        $data['product'] = $this->product_model->get_by_pk($id);
        $this->layout('product/index',$data);
    }
}