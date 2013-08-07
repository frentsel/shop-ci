<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BaseController extends CI_Controller {

    public $crud;

    function __construct()
    {
        parent::__construct();

        $this->load->library('Auth');
        $auth = new Auth();

        if(!$auth->is_logged_in()){
            redirect('admin/login');
            die;
        }

        $this->load->library('grocery_CRUD');
        $this->crud = new grocery_CRUD();
    }

    function _output($output = null)
    {
        $this->load->view('admin/main',$output);
    }
}