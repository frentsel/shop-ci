<?php

include_once 'user_model.php';

class Posts_Model extends User_Model
{
    public $table = 'posts';
    public $pk = 'post_id';

    public function pagination($type,$offset, $limit)
    {
        $cat_sql = "SELECT
                      p.*,
                      u.user_name
                    FROM posts AS p
                    LEFT OUTER JOIN users AS u
                    ON u.user_id = p.user_id
                    WHERE p.post_type = '".$type."'
                    LIMIT $offset, $limit";

        return $this->db->query($cat_sql)->result();
    }

    public function count_all($type)
    {
        $sql = "SELECT
                  COUNT(*) AS `count`
                FROM posts AS p
                WHERE p.post_type = ?";

        return $this->db->query($sql,array($type))->row('count');
    }

    public function get_page($key)
    {
        $this->load->helper('security');
        $key = addslashes(xss_clean($key));
        $sql = "SELECT
                  p.*
                FROM posts AS p
                WHERE p.post_url REGEXP ?";

        return $this->db->query($sql,array($key))->row();
    }
}