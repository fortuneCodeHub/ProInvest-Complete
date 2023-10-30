<?php
//Namespace 
namespace app\controller;

use app\model\Image;
use app\model\Session;
// Deny access to some pages
defined("ROOTPATH") OR exit("Access Denied");
class Home
{
    use \app\core\MainController;
    public $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    public function index()
    {
        // $ses = new Session();
        $data["sessions"] = isset($_SESSION["login_details"]) ? $_SESSION["login_details"] : [];
        $this->view("{$this->controller}", $data); 
    }

    public function edit()
    {
        $this->view("{$this->controller}");
    }
}