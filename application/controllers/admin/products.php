<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'base_controller.php';

class Products extends BaseController {

    function index()
    {
        $this->crud
            ->set_table('products')
            ->set_subject($this->lang->line('admin_product'));

        $this->crud->columns(
            'product_image_front',
            'product_title',
            'product_description',
            'product_price',
            'product_action_price',
            'product_count',
            'product_date_create',
            'product_date_update',
            'product_status'
        );

        $this->crud->unset_columns(
            'product_description',
            'product_image_1',
            'product_image_2',
            'product_image_3',
            'product_image_4',
            'product_image_5',
            'product_image_6',
            'product_image_7',
            'product_image_8',
            'product_image_9',
            'product_image_10'
        );

        $this->crud
            ->display_as('product_title','Title')
            ->display_as('product_description','Description')
            ->display_as('product_price','Price')
            ->display_as('product_action_price','Sale Price')
            ->display_as('product_count','Count')
            ->display_as('product_date_create','Create')
            ->display_as('product_date_update','Update')
            ->display_as('product_status','Status')
            ->display_as('product_image_front','General Image')
            ->display_as('product_image_1','Image 1')
            ->display_as('product_image_2','Image 2')
            ->display_as('product_image_3','Image 3')
            ->display_as('product_image_4','Image 4')
            ->display_as('product_image_5','Image 5');

        $this->crud->required_fields(
            'product_image_front',
            'product_title',
            'product_price',
            'product_count',
            'product_date_create',
            'product_date_update'
        );

        $this->crud
            ->set_field_upload('product_image_front','uploads/images')
            ->set_field_upload('product_image_1','uploads/images')
            ->set_field_upload('product_image_2','uploads/images')
            ->set_field_upload('product_image_3','uploads/images')
            ->set_field_upload('product_image_4','uploads/images')
            ->set_field_upload('product_image_5','uploads/images');

        $this->crud->callback_after_upload(array($this,'my_callback_after_upload'));

        #$this->crud->callback_delete(array($this,'clear_image_callback_delete'));

        $this->crud->set_relation_n_n(
            'categories',
            'categories_products',
            'categories',
            'id_product',
            'id_category',
            'category_title'
        );

        $output = $this->crud->render();
        $this->_output($output);
    }

    public function clear_image_callback_delete($app)
    {
        // to do: remove all refer images for it's product
        //var_dump($app);
        //die;
    }

    public function my_callback_after_upload($app)
    {
        $this->load->library('image_lib');

        $config['image_library'] = 'gd2';
        $config['source_image']	= 'uploads/images/'.$app[0]->name;
        $config['new_image'] = 'uploads/images/thumbnails/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 130;
        $config['height'] = 200;

        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();

        $config['new_image'] = 'uploads/images/thumbnails_gallery/'.$app[0]->name;
        $config['width'] = 55;
        $config['height'] = 55;

        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }
}