<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    public $auth;

    public function __construct()
    {
        parent::__construct();

        $this->load->library('Auth');
        $this->auth = new Auth();
    }

    public function index()
    {
        $this->load->view('admin/login');
    }

    public function check()
    {
        if(!empty($_POST['email']) &&
            !empty($_POST['password']) &&
            filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

            $this->auth->login(
                $_POST['email'],
                $_POST['password'],
                !empty($_POST['remember'])
            );
        }

        redirect('/admin');
    }

    public function logout()
    {
        $this->auth->logout();
        redirect('/admin/login');
    }

}