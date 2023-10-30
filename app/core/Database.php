<?php
// Namespace
namespace app\core;
// Deny access to some pages
defined("ROOTPATH") OR exit("Access Denied");

/**
 * Using traits is better than using class extension, because with traits a class can inherit more parent classes, but with normal class extension you can only inherit one single parent class
 * The only problem with a trait is that you can't instantiate it directly from itself, you have to instantiate it through its child class 
 */

Trait Database
{
    private function connect()
    {
        $connection = new \PDO("mysql:host=".DBHOST.";dbname=". DBNAME, DUSER, "");
        return $connection;
    }

    public function query($query, $data = [])
    {
        $connection = $this->connect();
        $statement = $connection->prepare($query);
        $statement->execute($data);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
    
        if (is_array($result)) {
            return $result;
        }
        return false;
    }

    public function get_row($query, $data = [])
    {
        $connection = $this->connect();
        $statement = $connection->prepare($query);
        $check = $statement->execute($data);
        if ($check) {
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
            if (is_array($result)) {
                return $result[0];
            }
        }
        return false;
    }
}