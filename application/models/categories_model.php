<?php

include_once 'user_model.php';

class Categories_Model extends User_Model
{
    public $table = 'categories';
    public $pk = 'category_id';

    public function pagination($id, $offset, $limit)
    {
        $cat_sql = "SELECT
                      p.*
                    FROM products AS p
                      LEFT OUTER JOIN categories_products AS cp
                        ON cp.id_product = p.id_product
                    WHERE cp.id_category = $id
                    GROUP BY p.id_product
                    ORDER BY p.id_product DESC
                    LIMIT $offset, $limit";

        return $this->db->query($cat_sql)->result();
    }

    public function count_all($id)
    {
        $sql = "SELECT
                  COUNT(*) as `count`
                FROM products AS p
                  LEFT OUTER JOIN categories_products AS cp
                    ON cp.id_product = p.id_product
                WHERE cp.id_category = ".(int)$id;

        return $this->db->query($sql)->row('count');
    }
}