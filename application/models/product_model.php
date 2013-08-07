<?php

include_once 'user_model.php';

class Product_Model extends User_Model
{
    public  $table = 'products',
            $pk = 'id_product';
}