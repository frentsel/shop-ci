<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

    public function index()
    {
        for($i=1; $i++; $i<=100){
            if($i != 79 || $i != 54){
                $this->db->where('id_product',$i)->update('products',array(
                    'product_image_1' => rand(1,28).'.jpg',
                    'product_image_2' => rand(2,28).'.jpg',
                    'product_image_3' => rand(3,28).'.jpg',
                    'product_image_4' => rand(4,28).'.jpg',
                    'product_image_5' => rand(5,28).'.jpg',
                    'product_image_6' => rand(6,28).'.jpg',
                    'product_image_7' => rand(7,28).'.jpg',
                    'product_image_8' => rand(8,28).'.jpg',
                    'product_image_9' => rand(9,28).'.jpg',
                    'product_image_10' => rand(10,28).'.jpg',
                ));
            }
        }
        echo 'complete';
        die;
    }
}