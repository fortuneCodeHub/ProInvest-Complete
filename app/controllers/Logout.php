<?php
//Namespace 
namespace app\controller;
// Deny access to some pages
defined("ROOTPATH") OR exit("Access Denied");

use app\model\Session;

class Logout
{
    use \app\core\MainController;
    public $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    public function index()
    {
        $ses = new Session();
        // $ses->logout();
        unset($_SESSION["login_details"]);
        redirect("home/LoggedOutSuccessfully");
    }

    public function edit()
    {
        $this->view("{$this->controller}");
    }
}