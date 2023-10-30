<?php 
// Namespace
namespace app\thunder;

// Deny access to some pages
defined("CPATH") OR exit("Access Denied");

/** 
 *  Database Class
 *  
 */

Trait Migration
{
    use \app\core\MainModel;
    use \app\core\Database;

    protected $columns       = [];
    protected $keys          = [];
    protected $primaryKeys   = [];
    protected $uniqueKeys    = [];
    protected $data          = [];

    
    protected function createTable($tableName)
    {
        if (!empty($this->columns)) 
        {
           $query = " CREATE TABLE $tableName ( ";
            foreach ($this->columns as $column) {
                $query .= $column . ",";
            }
            foreach ($this->primaryKeys as $primaryKey) {
                $query .= "PRIMARY KEY ($primaryKey) ,";
            }
            foreach ($this->uniqueKeys as $uniqueKey) {
                $query .= "UNIQUE ($uniqueKey) ,";
            }
            foreach ($this->keys as $key) {
                $query .= "KEY ($key) ,";
            }
            $query = rtrim($query, ",");
            $query .= " ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
            $this->query($query);

            //Empty all the migration properties for a new table
            $this->columns        = [];
            $this->keys           = [];
            $this->primaryKeys    = [];
            $this->uniqueKeys     = [];

            echo "\n\r Table $tableName successfully created! \n\r"; 
        } else {
            echo "\n\r Table $tableName could not be created! \n\r"; 
        }
        
    }

    protected function addColumn($text)
    {
        $this->columns[] = $text;
    }

    protected function addPrimaryKey($text) 
    {
        $this->primaryKeys[] =  $text;
    } 

    protected function addUniqueKey($text) 
    {
        $this->uniqueKeys[] =  $text;
    } 
    
    protected function addData($key, $value) 
    {
        $this->data[$key] =  $value; 
    } 

    protected function dropTable($tableName) 
    {
        $this->query("DROP TABLE ". $tableName);
        die("\n\r Table $tableName successfully deleted \n\r");
    } 

    protected function insertData($tableName) 
    {
        if (!empty($this->data)) {
            $keys = array_keys($this->data);
            $this->insert($this->data);
            $this->data = [];
            echo "\n\r Data inserted successfully in table: $tableName \n\\r";
        } else {
            echo "\n\r Data could not be inserted into the table: $tableName \n\\r";   
        }
        
    }

    // CREATE TABLE `users` (
    //     `id` int(17) NOT NULL AUTO_INCREMENT,
    //     `name` varchar(200) NOT NULL,
    //     `age` varchar(17) NOT NULL,
    //     `email` varchar(2000) NOT NULL,
    //     `password` varchar(2000) NOT NULL,
    //     `term` varchar(100) NOT NULL,
    //     `date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    //     PRIMARY KEY (`id`),
    //     UNIQUE KEY `email` (`email`) USING HASH
    // ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci


}