<?php
//Namespace 
namespace app\controller;
// Deny access to some pages
defined("ROOTPATH") OR exit("Access Denied");

/**
 * Admindashboard class
 */

class Admindashboard
{
    use \app\core\MainController;

    public $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    public function index()
    {
        $this->view("{$this->controller}");
    }

    public function edit()
    {
        $this->view("{$this->controller}");
    }
}