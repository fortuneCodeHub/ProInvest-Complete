<?php
//Namespace 
namespace app\controller;

use app\model\User;
use app\model\Request;
use app\model\Session;

// Deny access to some pages
defined("ROOTPATH") OR exit("Access Denied");

class Login
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

    public function auth()
    {
        $req = new Request();
        $ses = new Session();
        if ($req->posted()) {
            $user = new User();
            $user->signin($_POST);
            $data["user"] = $user;
            redirect("userdashboard/LoggedInSuccessfully");
            $this->view("{$this->controller}",$data);
        } else {
            $this->view("{$this->controller}");   
            echo $this->controller;
        }
    }
}

// show_array($_POST);