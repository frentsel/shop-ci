<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH.'/controllers/admin/base_controller.php';

class Main extends BaseController {

    function _example_output($output = null)
    {
        $this->load->view('admin/main',$output);
    }

    function index()
    {
        $this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
    }

    function orders()
    {
        $this->crud->set_subject('Order');

        $this->crud->fields(
            'order_name',
            'order_phone',
            'order_date_create',
            'order_address',
            'order_email',
            'order_status',
            'order_message',
            'user_id'
        );

        $this->crud
            ->display_as('order_name','Name')
            ->display_as('order_phone','Phone')
            ->display_as('order_date_create','Create')
            ->display_as('order_address','Address')
            ->display_as('order_status','Status')
            ->display_as('order_email','Email')
            ->display_as('order_message','Message')
            ->display_as('user_id','User');

        $this->crud->unset_columns('order_content');

        $this->crud->set_relation('user_id','users','user_name');

        $output = $this->crud->render();

        $this->_example_output($output);
    }

    function categories()
    {
        $this->crud->set_subject('Category');

        $output = $this->crud->render();

        $this->_example_output($output);
    }

    function products()
    {
        $this->crud->set_table('products');
        $this->crud->set_subject($this->lang->line('admin_product'));

        //$this->crud->set_relation('id_product','images','image_src');

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
            ->display_as('product_image_5','Image 5')
            ->display_as('product_image_6','Image 6')
            ->display_as('product_image_7','Image 7')
            ->display_as('product_image_8','Image 8')
            ->display_as('product_image_9','Image 9')
            ->display_as('product_image_10','Image 10');

        $this->crud
            ->set_field_upload('product_image_front','uploads/images')
            ->set_field_upload('product_image_1','uploads/images')
            ->set_field_upload('product_image_2','uploads/images')
            ->set_field_upload('product_image_3','uploads/images')
            ->set_field_upload('product_image_4','uploads/images')
            ->set_field_upload('product_image_5','uploads/images')
            ->set_field_upload('product_image_6','uploads/images')
            ->set_field_upload('product_image_7','uploads/images')
            ->set_field_upload('product_image_8','uploads/images')
            ->set_field_upload('product_image_9','uploads/images')
            ->set_field_upload('product_image_10','uploads/images');

        $this->crud->set_relation_n_n(
            'categories',
            'categories_products',
            'categories',
            'id_product',
            'id_category',
            'category_title'
        );

        $output = $this->crud->render();
        $this->_example_output($output);
    }

    function pages()
    {
        $this->crud->where('post_type','page');
        $this->crud->set_table('posts');
        $this->crud->set_subject('Page');

        $this->crud
            ->display_as('post_title','Title')
            ->display_as('post_description','Description')
            ->display_as('post_text','Text')
            ->display_as('post_date_create','Create')
            ->display_as('post_date_update','Update')
            ->display_as('post_url','Url')
            ->display_as('post_type','Type')
            ->display_as('post_seo_description','SEO Description')
            ->display_as('user_id','User');

        //$this->crud->unset_columns('post_type');

        $this->crud->set_relation('user_id','users','user_name');

        $output = $this->crud->render();
        $this->_example_output($output);
    }

    function blog()
    {
        $this->crud->where('post_type','blog');
        $this->crud->set_table('posts');
        $this->crud->set_subject('Article');

        $this->crud
            ->display_as('post_title','Title')
            ->display_as('post_description','Description')
            ->display_as('post_text','Text')
            ->display_as('post_date_create','Create')
            ->display_as('post_date_update','Update')
            ->display_as('post_url','Url')
            ->display_as('post_type','Type')
            ->display_as('post_seo_description','SEO Description')
            ->display_as('user_id','User');

        //$this->crud->unset_columns('post_type');

        $this->crud->set_relation('user_id','users','user_name');

        $output = $this->crud->render();
        $this->_example_output($output);
    }

    function news()
    {
        $this->crud->where('post_type','news');
        $this->crud->set_table('posts');
        $this->crud->set_subject('News');

        $this->crud
            ->display_as('post_title','Title')
            ->display_as('post_description','Description')
            ->display_as('post_text','Text')
            ->display_as('post_date_create','Create')
            ->display_as('post_date_update','Update')
            ->display_as('post_url','Url')
            ->display_as('post_type','Type')
            ->display_as('post_seo_description','SEO Description')
            ->display_as('user_id','User');

        //$this->crud->unset_columns('post_type');

        $this->crud->set_relation('user_id','users','user_name');

        $output = $this->crud->render();
        $this->_example_output($output);
    }

    function users()
    {
        $this->crud->set_subject('User');

        $output = $this->crud->render();
        $this->_example_output($output);
    }

    function settings()
    {
        $this->crud
            ->display_as('title','Title')
            ->display_as('value','Value');

        $this->crud->field_type('title','readonly');

        $output = $this->crud->render();
        $this->_example_output($output);
    }

    public function return_false()
    {
        return false;
    }
}
