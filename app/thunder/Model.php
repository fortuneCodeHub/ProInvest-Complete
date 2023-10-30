<?php 
// Namespace
namespace app\thunder;

// Deny access to some pages
defined("CPATH") OR exit("Access Denied");

/** 
 *  Database Class
 *  
 */

class MainModel
{
    use \app\core\MainModel;
}