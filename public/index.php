<?php
session_start();
// session_unset();
// use app\core;
/** Valid PHP Version  */
$minPHPVersion = "8.0";
if (phpversion() < $minPHPVersion) {
    die("Your PHP Version must be $minPHPVersion or higher to run this app. Your current version is ". phpversion());
}

// Path to this file
define("ROOTPATH", __DIR__. DIRECTORY_SEPARATOR);

// The autoloader
require_once "../app/core/init.php";

DEBUG ? ini_set("display_errors", 1) : ini_set("display_errors", 0);

$app = new App();
$app->loadController();


require_once __DIR__."/../vendor/autoload.php";
