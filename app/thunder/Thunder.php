<?php 
// Namespace
namespace app\thunder;

// Deny access to some pages
defined("CPATH") OR exit("Access Denied");

use app\thunder\Database;
use app\thunder\MainModel;

/** 
 *  Thunder Class
 *  
 */

class Thunder
{ 
    private $version = "1.0.0";


    public function help()
    {
        echo "

            Thunder v$this->version Command Line Tool

            Database 
                db:create         Create a new database schema.
                db:seed           Runs the specified seeder to populate known data into the database.
                db:table          Retrieves information on the selected table.
                db:drop           Drop/Delete a database.
                migrate           Locates and runs a migration from the specified plugin folder.
                migrate:refresh   Does a rollback followed by a latest to refresh the current state of the database.
                migrate:rollback  Runs the 'down' method for a migration in the specified plugin folder.

            Generators 
                make:controller  Generates a new controller file
                make:model       Generates a new model file
                make:migration   Generates a new migration file
                make:seeder      Generates a new seeder file

            Other
                list:migrations  Displays all migration files available

            When Creating Features
                When creating a model related to a table, you should give it the same name as the table 
                just that it should not end with an 's'

        ";
    }

    public function list($argv)
    {
        $mode = $argv[1] ?? ""; 

        switch ($mode) {
            case 'list:migrations':
                $folder =  "app".DS."migrations".DS;
                if (!file_exists($folder)) {
                    die("\n\r No migration files were found \n\r");
                }
                //How to get all the files from a folder, it comes as an array 
                $files = glob($folder."*.php");
                echo "\n\r Migration Files:\n\r";
                foreach ($files as $file) {
                    echo basename($file)."\n\r";
                }
                break;
            
            default:
                # code...
                break;
        }
    }

    public function make($argv):mixed
    {
        $mode = $argv[1] ?? ""; 
        $classname = $argv[2] ?? "";
        /** check if class name is empty */
        if (empty($classname)) {
            die("\n\rPlease provide a classname\n\r");
        }
        /** clean class name starts with a symbol */
        $classname = preg_replace("/[^a-zA-z0-9_]+/", "", $classname);

        /** check if class name starts with a number*/
        if (preg_match("/^[^a-zA-z_]+/", $classname)) {
            die("\n\rClass names cannot start with a number\n\r");
        }

        switch ($mode) {
            case 'make:controller':
                /** the new file to be created an it is dir */
                $filename = "app".DS."controllers".DS.ucfirst($classname).".php";
                if (file_exists($filename)) {
                    die("\n\rThat controller already exists\n\r");
                }

                $sample_file = file_get_contents("app".DS."thunder".DS."samples".DS."controller-sample.php"); 
                $sample_file = preg_replace("/\{CLASSNAME\}/", ucfirst($classname), $sample_file);
                if (file_put_contents($filename, $sample_file)) {
                    die("\n\rController created successfully\n\r");
                } else {
                    die("\n\rFailed to create Controller due to an error\n\r");
                }
                break;
            case 'make:model':
                /** the new file to be created an it is dir */
                $filename = "app".DS."models".DS.ucfirst($classname).".php";
                if (file_exists($filename)) {
                    die("\n\rThat model already exists\n\r");
                }

                $sample_file = file_get_contents("app".DS."thunder".DS."samples".DS."model-sample.php"); 

                $sample_file = preg_replace("/\{CLASSNAME\}/", ucfirst($classname), $sample_file);

                /** only adds an 's' at the end of table name if it does not exist */
                if (!preg_match("/s$/", $classname)) {
                    $sample_file = preg_replace("/\{table\}/", strtolower($classname). "s", $sample_file);
                }

                if (file_put_contents($filename, $sample_file)) {
                    die("\n\rModel created successfully\n\r");
                } else {
                    die("\n\rFailed to create Model due to an error\n\r");
                }

                break;
            case 'make:migration':
                /** the new file to be created an it is dir */
                $folder =  "app".DS."migrations".DS;
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }
                $filename = $folder.date("jS_M_Y_H_i_s_").ucfirst($classname).".php";
                if (file_exists($filename)) {
                    die("\n\rThat migration file already exists\n\r");
                }

                $sample_file = file_get_contents("app".DS."thunder".DS."samples".DS."migration-sample.php"); 

                $sample_file = preg_replace("/\{CLASSNAME\}/", ucfirst($classname), $sample_file);
                $sample_file = preg_replace("/\{classname\}/", strtolower($classname), $sample_file);

                if (file_put_contents($filename, $sample_file)) {
                    die("\n\r Migration File created:". basename($filename) ."\n\r");
                } else {
                    die("\n\rFailed to create Migration File due to an error\n\r");
                }
                break;
            case 'make:seeder':
                break;
            default:
                die("\n\r Unknown Command $argv [1]\n\r");
                break;
        }
    }

    public function db($argv)
    {
        
        $mode   = $argv[1] ?? ""; //Command
        $param1 = $argv[2] ?? ""; //Content

        switch ($mode) {
            case 'db:create':
                /** check if param1 is empty */
                if (empty($param1)) {
                    die("\n\rPlease provide a database name\n\r");
                }

                $db = new Database();
                $query = "CREATE DATABASE IF NOT EXISTS ". $param1;
    
                $folder =  "app".DS."DB_Folder".DS;
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }
                echo $folder;
                $files = glob($folder."*.php");
                show_array($files);

                if (empty($files)) {
                    $filename = $folder."Db_Handler.php";

                    $sample_file = file_get_contents("app".DS."thunder".DS."samples".DS."Dbname-sample.php"); 

                    $sample_file = preg_replace("/\{DBNAME\}/", $param1, $sample_file);

                    if (file_put_contents($filename, $sample_file)) {
                        echo "\n\r Db Handler File Created:". basename($filename) ."\n\r";
                    } else {
                        die("\n\rFailed to create Db Handler File due to an error\n\r");
                    }
                } else {
                    die("\n\r Database already exists \n\r");
                }
                $db->query($query);
                exit("\n\r Database created Successfully \n\r");

            case 'db:table': //Gives the description of a table (i.e the column names, their specialties and so on and so forth)
                /** check if param1 is empty */
                if (empty($param1)) {
                    die("\n\rPlease provide a table name\n\r");
                }
                $db = new Database();
                $query = "DESCRIBE ". $param1;
                $res = $db->query($query);

                if($res) {
                    echo "<pre>";
                    print_r($res);
                    echo "</pre>";
                } else {
                    echo "\n\rCould not find $param1 data\n\r";
                }
                // die("");
                break;
            case 'db:drop':
                /** check if param1 is empty */
                if (empty($param1)) {
                    die("\n\rPlease provide a database name that exists\n\r");
                }

                $db = new Database();
                $query = "DROP DATABASE ". $param1;
                $db->query($query);
                
                die("\n\rDatabase deleted successfully\n\r");
                break;
            case 'db:seed':
                break;
            default:
                return $this->help();
                die("\n\rUnknown Command $argv[1]\n\r");
                break;
        }

    }

    public function migrate($argv)
    {
        $mode = $argv[1] ?? ""; 
        $filename = $argv[2] ?? "";

        $filename = "app".DS."migrations".DS.$filename;

        if (file_exists($filename)) {
            require $filename;

            preg_match("/_[_a-zA-Z]+\.php$/", $filename, $match);
            $classname = str_replace(".php", "", $match[0]);
            $classname = ltrim($classname,"_");

            $myclass = new ("\app\migration\\$classname")();
            $myclass->up();
        } else {
            die("\n\r This file does not exist \n\r");
        }
        die("\n\r Migration file run successfully: ".basename($filename)." \n\r");
    }
}