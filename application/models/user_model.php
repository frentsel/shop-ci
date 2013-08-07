<?php

class User_Model extends CI_Model
{
    public  $table = '',
            $pk = '';

    public function _default()
    {
        return array(
            'categories' => $this->db->order_by('category_priority','asc')->get('categories')->result(),
            'pages' => $this->db->get_where('posts',array('post_type'=>'page'))->result(),
        );
    }

    public function get_products()
    {
        $prod_sql = "SELECT * FROM products AS p ORDER BY p.id_product DESC LIMIT 0,9";
        return $this->db->query($prod_sql)->result();
    }

    /*
    Get one record
    */
    public function get_one($where)
    {
        return $this->db
                    ->get_where($this->table,$this->db->escape($where))
                    ->row();
    }

    public function get_by_pk($id)
    {
        return $this->db
            ->get_where($this->table,array($this->pk => (int)$id))
            ->row();
    }

    /*
    Get all records
    */
    public function get_all($table = '')
    {
        if(!empty($table))
        return $this->db->get($this->table)->result();
    }

    /*
    Remove record from table
    */
    public function delete($where)
    {
        return $this->db
                    ->delete($this->table)
                    ->where($this->db->escape($where));
    }

    /*
    Insert new record
    */
    public function add($data)
    {
        $this->db->insert($this->table,$data);
        return $this->db->insert_id();
    }

    /*
    Edit record
    */
    public function update($where)
    {
        return $this->db
                    ->update($this->table)
                    ->where($this->db->escape($where));
    }

    public function escape($var)
    {
        return addslashes(strip_tags(trim($var)));
    }
}