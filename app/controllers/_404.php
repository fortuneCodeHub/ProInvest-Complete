<?php
//Namespace 
namespace app\controller;
// Deny access to some pages 
defined("ROOTPATH") OR exit("Access Denied");
class _404
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
}