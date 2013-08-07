<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'base_controller.php';

class News extends BaseController {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('posts_model');
    }

    public function index($start = 0)
    {
        $this->load->library('pagination');

        $data = $this->posts_model->_default();

        $config = array(
            'first_url' => '/news/0/',
            'base_url' => '/news/',
            'total_rows' => $this->posts_model->count_all('news'),
            'uri_segment' => 2,
        );

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['posts'] = $this->posts_model->pagination(
            'news',
            $start,
            10
        );

        $this->layout('news/index',$data);
    }


}