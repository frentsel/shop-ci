<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'base_controller.php';

class Category extends BaseController {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('categories_model');
    }

    public function index($id = 0, $separate = '', $start = 0)
    {
        $this->load->library('pagination');

        $data = $this->categories_model->_default();

        $config = array(
            'first_url' => '/category/'.$id.'/'.$separate.'/0/',
            'base_url' => '/category/'.$id.'/'.$separate.'/',
            'total_rows' => $this->categories_model->count_all($id),
            'uri_segment' => 4,
        );

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['products'] = $this->categories_model->pagination(
            $id,
            $start,
            9
        );

        $category = $this->categories_model->get_by_pk($id);
        $data['title'] = $category->category_title;

        $this->layout('category/index',$data);
    }


}