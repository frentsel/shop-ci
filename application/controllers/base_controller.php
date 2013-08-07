<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class BaseController extends CI_Controller {

    public  $title = 'Codeigniter.shop',
            $description = '',
            $cart = array(),
            $user = array(
                'id' => 2,
                'email' => 'test@mail.com',
                'name' => 'Demo Name',
                'phone' => '+38-097-987-65-43',
                'address' => 'Demo Address',
                'message' => ''
            ),
            $header_cart = array(
                'total' => 0,
                'item' => 0
            );

    public function __construct()
    {
        parent::__construct();
        $this->cart_init();
    }

    public function layout($view,$data = array())
    {
        $data['view'] = $view;
        $this->load->view('layout/main',array(
            'data'=>$data,
            'cart'=>$this->header_cart
        ));
    }

    public function cart_init()
    {
        if(!empty($_SESSION['cart'])){
            $this->cart = $_SESSION['cart'];
            foreach($this->cart as $c){
                $this->header_cart['item']++;
                $this->header_cart['total'] += $c['total'];
            }
        }
    }
}