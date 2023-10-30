<?php
// Deny access to some pages
// require_once "DBname.php";
 

defined("ROOTPATH") OR exit("Access Denied");
//Name of the folder
$foldername = "ProInvest";

// define("DS", DIRECTORY_SEPARATOR);

$folder = "../app/DB_Folder/Db_Handler.php";
$Db_Handler_File = file_get_contents($folder);
preg_match("/\{[^}]*\}/", $Db_Handler_File, $match);
$dbname = $match[0];
$dbname = ltrim($dbname, "{");
$dbname = rtrim($dbname, "}");

if ((empty($_SERVER["SERVER_NAME"]) && php_sapi_name() == "cli") || (!empty($_SERVER["SERVER_NAME"]) && $_SERVER["SERVER_NAME"] == "localhost")) {
    // This is the Database config
    if (empty($dbname)) {
        $dbname = "my_db";
    }
    define("DBNAME", $dbname);
    define("DBHOST", "localhost");
    define("DUSER", "root");
    define("DPASS", "");
    define("DDRIVER", "");

    // This is the ROOT_URL config
    $url = "http://localhost/$foldername/public";
    define("ROOT_URL", $url);
} else {
    // This is the Database config
    if (empty($dbname)) {
        $dbname = "my_db";
    }
    define("DBNAME", "$dbname");
    define("DBHOST", "localhost");
    define("DUSER", "root");
    define("DPASS", "");
    define("DDRIVER", "");

    // define("ROOT_URL", "https://www.yourwebsite.com");
}

// true if it has errors
define("DEBUG", true);

/**
 * When you want to create upload your website to the internet you will use this format of URL
 * define("ROOT_URL", "https://www.yourwebsite.com");
 */