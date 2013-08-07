<?php

include_once 'user_model.php';

class Orders_Model extends User_Model
{
    public $table = 'orders';
    public $pk = 'order_id';

    public function pagination($type,$offset, $limit)
    {
        $cat_sql = "SELECT
                      p.*
                    FROM posts AS p
                    WHERE p.post_type = '".$type."'
                    LIMIT $offset, $limit";

        return $this->db->query($cat_sql)->result();
    }

    public function order_create($data, $user)
    {
        $order = array(
            'order_date_create' => date('Y-m-d H:i:s'),
            'user_id'           => (int) $user['id'],
            'order_name'        => $this->escape($user['name']),
            'order_email'       => filter_var($user['email'], FILTER_VALIDATE_EMAIL) ? $user['email'] : '',
            'order_phone'       => preg_match("/[0-9- ()+]{8,19}/", $user['phone']) ? $user['phone'] : '',
            'order_message'     => $this->escape($user['message']),
            'order_content'     => $this->escape(serialize($data))
        );

        return $this->add($order);
    }
}