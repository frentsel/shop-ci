<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

    public $auth;

    public function __construct()
    {
        parent::__construct();

        $this->load->library('Auth');
        $this->auth = new Auth();
    }

    public function index()
    {
        $this->load->view('admin/register');
    }

    public function save()
    {
        if(!empty($_POST['email']) &&
            !empty($_POST['password']) &&
            filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

            $this->auth->register(
                $_POST['email'],
                $_POST['password']
            );
        }

        redirect('/admin');
    }

}