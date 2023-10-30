<?php
// Deny access to some pages
defined("ROOTPATH") OR exit("Access Denied");
/**
 * Creating the autoloader
 */

// This helps to autoload all model classes that are called on the index.php page but can't be found
spl_autoload_register(function($classname){
    $classname = explode("\\", $classname);
    $classname = end($classname);
    $filename = "../app/models/". ucfirst($classname). ".php";
    if (file_exists($filename)) {
        require_once $filename;
    }  
});

// require_once "config.php";
require_once "functions.php";
require_once "Database.php";
require_once "Model.php";
require_once "Controller.php";
require_once "config.php";
require_once "App.php";