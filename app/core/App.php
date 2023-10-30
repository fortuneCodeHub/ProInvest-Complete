<?php

// Deny access to some pages
defined("ROOTPATH") OR exit("Access Denied");
/**
 * Creating the router
 */

class App 
{
    private $controller = "Home";
    private $method = "index";


    private function splitUrl() { 
        if (isset($_GET["url"])) {
            $splittedURL = explode("/", trim($_GET["url"], "/"));
            return $splittedURL;
        } else {
            $_GET["url"] = "home";
            $splittedURL = explode("/", trim($_GET["url"], "/"));
            return $splittedURL;
        }
    }
    
    // Creating the function that will load a page controller
    public function loadController() 
    {
        $URL = $this->splitUrl();

        /** select controller */
        $urlfirst = ucfirst($URL[0]);
        $filename = "../app/controllers/". $urlfirst .".php";
        if(file_exists($filename)) {
            require $filename;
            $this->controller = $urlfirst;
            unset($URL[0]);
        } else {
            $filename = "../app/controllers/_404.php";
            require $filename;
            $this->controller = "_404";
        }
        $mycontroller = "app\controller\\{$this->controller}";
        $controller = new $mycontroller("{$this->controller}");

        /** select method */
        // This helps us to run other methods on the page controller apart from the controller loader method
        if (!empty($URL[1])) {
            if (method_exists($controller, $URL[1])) {
                $this->method = $URL[1];
                unset($URL[1]);
            }
        }
        /** run the method on the controller */
        call_user_func_array([$controller, $this->method], $URL);
        
    }
}
