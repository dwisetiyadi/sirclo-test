<?php

/*
Author dwi.setiyadi@gmail.com
Made for Sirclo
*/

abstract class Cart
{
    private static function connect()
    {
        try
        {
            $username = DBuser;
            $password = DBpass;
            $host = DBhost;
            $db = DBname;
            $connection = new PDO("mysql:dbname=$db;host=$host", $username, $password);
            return $connection;
        }
        catch (Exception $e)
        {
            die($e);
        }
    }
    
    public static function installProductTable()
    {
        $is_exist = false;
        $connection = self::connect();
        
        try
        {
            $connection->exec("SELECT 1 FROM product LIMIT 1");
            $is_exists = true;
        }
        catch (Exception $e)
        {
            die($e);
        }
        
        if ($is_exists)
        {
            $sql = <<<____SQL
CREATE TABLE IF NOT EXISTS `product` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    `qty` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;
____SQL;
            $stmt = $connection->exec($sql);
            return $stmt;
        }
        else
        {
            return $is_exists;
        }
    }
    
    public static function add($product = '', $qty = 1)
    {
        if ($product !== '')
        {
            $data[':title'] = $product;
            $data[':qty'] = $qty;
            
            $connection = self::connect();
            
            $is_exists = $connection->prepare("SELECT * FROM product WHERE title = :title;");
            $is_exists->execute(['title' => $product]);
            
            if (count($is_exists->fetchAll()) > 0)
            {
                $update = $connection->prepare("UPDATE product SET qty = (qty + :qty) WHERE title=:title;");
                $update->execute(['title' => $product, 'qty' => $qty]);
            }
            else
            {
                $create = $connection->prepare("INSERT INTO product (title, qty) VALUES (:title, :qty);");
                $create->execute(['title' => $product, 'qty' => $qty]);
            }
        }
    }
    
    public static function remove($product = '')
    {
        if ($product !== '')
        {
            $connection = self::connect();
            $delete = $connection->prepare("DELETE FROM product WHERE title = :title;");
            $delete->execute(['title' => $product]);
        }
    }
    
    public static function show()
    {
        $connection = self::connect();
        $list = $connection->query("SELECT * FROM product ORDER BY qty DESC")->fetchAll();
        
        foreach ($list as $row) {
            echo $row['title'] . ' (' . $row['qty'] . ')<br>';
        }
    }
}

/* end of file */