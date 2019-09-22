<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function getSubMenu()
    {
        $query = "SELECT user_sub_menu.*, user_menu.menu
                    FROM user_sub_menu JOIN user_menu
                    ON user_sub_menu.menu_id = user_menu.menu_id
                ";
        return $this->db->query($query)->result_array();
    }
    
    public function dateTransaction()
    {
        $query = "SELECT *, DATE_FORMAT(date_transaction,'%Y %m') as date
                    FROM transaction
                    GROUP BY DATE_FORMAT(date_transaction,'%Y %m')
                ";
        return $this->db->query($query)->result_array();
    }
    
    public function search($year_transaction)
    {
        $query = "SELECT transaction.product_id, product.product, SUM(transaction.total) as total, DATE_FORMAT(transaction.date_transaction,'%Y %m') AS date, COUNT(transaction.product_id) as modus
                    FROM product JOIN transaction
                    ON product.product_id = transaction.product_id
                    WHERE DATE_FORMAT(transaction.date_transaction,'%Y %m') = '$year_transaction'
                    GROUP BY transaction.product_id
                ";
        return $this->db->query($query)->result_array();
    }
    
    public function currentnode($year_transaction)
    {
        $query = "SELECT transaction.product_id, product.product, SUM(transaction.total) as total, DATE_FORMAT(transaction.date_transaction,'%Y %m') AS date, COUNT(transaction.product_id) as modus
                    FROM product JOIN transaction
                    ON product.product_id = transaction.product_id
                    WHERE DATE_FORMAT(transaction.date_transaction,'%Y %m') = '$year_transaction'
                    GROUP BY transaction.product_id
                    ORDER BY RAND() LIMIT 1
                ";
        return $this->db->query($query)->result_array();
    }

    public function medoid($year_transaction)
    {
        $query = "SELECT transaction.product_id, product.product, SUM(transaction.total) as total, DATE_FORMAT(transaction.date_transaction,'%Y %m') AS date, COUNT(transaction.product_id) as modus
                    FROM product JOIN transaction
                    ON product.product_id = transaction.product_id
                    WHERE DATE_FORMAT(transaction.date_transaction,'%Y %m') = '$year_transaction'
                    GROUP BY transaction.product_id
                    ORDER BY RAND() LIMIT 1
                ";
        return $this->db->query($query)->result_array();
    }

    public function nonmedoid($year_transaction)
    {
        $query = "SELECT transaction.product_id, product.product, SUM(transaction.total) as total, DATE_FORMAT(transaction.date_transaction,'%Y %m') AS date, COUNT(transaction.product_id) as modus
                    FROM product JOIN transaction
                    ON product.product_id = transaction.product_id
                    WHERE DATE_FORMAT(transaction.date_transaction,'%Y %m') = '$year_transaction'
                    GROUP BY transaction.product_id
                    ORDER BY RAND() LIMIT 1
                ";
        return $this->db->query($query)->result_array();
    }

    public function viewSearch($year_transaction)
    {
        $query = "ALTER VIEW total AS
                    SELECT transaction.product_id, product.product, SUM(transaction.total) as total, DATE_FORMAT(transaction.date_transaction,'%Y %m') AS date, COUNT(transaction.product_id) as modus
                    FROM product JOIN transaction
                    ON product.product_id = transaction.product_id
                    WHERE DATE_FORMAT(transaction.date_transaction,'%Y %m') = '$year_transaction'
                    GROUP BY transaction.product_id
                ";
        return $this->db->query($query);
    }

    public function calculate ($medoid, $currentnode)
    {
        $query = "SELECT $medoid['total'] - $currentnode['modus']
                ";
        return $this->db->query($query);
    }
    
    public function getRoleAccess()
    {
        $query = "SELECT * FROM user_role
                    WHERE role_id IN
                    (SELECT role_id FROM user_access_menu)";
        return $this->db->query($query)->result_array();
    }

    public function deleteRoleAccess()
    {
        $query = "DELETE FROM user_role
                    WHERE role_id NOT IN
                    (SELECT role_id FROM user_access_menu)";
        return $this->db->query($query)->result_array;
    }

    // public function getMenuActive()
    // {
    //     $query = "SELECT * FROM user_menu
    //                 WHERE menu_id IN
    //                 (SELECT menu_id FROM user_sub_menu)";
    //     return $this->db->query($query)->result_array();
    // }

    public function deleteMenu()
    {
        $query = "DELETE FROM user_menu
                    WHERE menu_id NOT IN
                    (SELECT menu_id FROM user_sub_menu)";
        return $this->db->query($query)->result_array;
    }

    // public function getToken()
    // {
    //     $query = "SELECT * FROM user_token";
    //     return $this->db->query($query)->result_array;
    // }
}
