<?php
// Namespace
namespace app\migration;
// Deny access to some pages
defined("ROOTPATH") OR exit("Access Denied");

/**
 * Users class
 */

class Users
{
    use \app\thunder\Migration;

    public $table = "users";

    public function up() //To create the table
    {
        /** Allowed Methods  */
        /**
         * $this->addColumn();
         * $this->addPrimaryKey();
         * $this->addUniqueKey();
         * $this->addData();
         * $this->insertData();
         * $this->createTable();
         */
        //Create a table
        $this->addColumn("id int(17) NOT NULL AUTO_INCREMENT");
        $this->addPrimaryKey("id");

        $this->createTable("users");
    }

    public function down()//To delete the table
    {
        $this->dropTable("users");
    }
}

