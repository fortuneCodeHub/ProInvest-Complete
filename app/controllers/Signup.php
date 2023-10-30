<?php
//Namespace
namespace app\controller; 

use app\model\User;
use app\model\Request; 
// Deny access to some pages
defined("ROOTPATH") OR exit("Access Denied");

class Signup
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
        if ($req->posted()) {
            if (!isset($_POST["term"])) {
                $_POST["term"] = "";
            }
            // show_array($_POST);
            $user = new User();
            if ($user->signup($_POST)) {
                $email = new \app\model\Email();
                if (!empty($_SESSION["USER"])) {
                    $ses = new \app\model\Session();
                    $recipient = $ses->user("email");
                    $subject = "Email Verification";
                    $otp = rand(100000, 999999);
                    $message = "<p></p>Your OTP Verification code is <b>$otp</b></p>
                    <p>Use this to verify your account</p>";
                    if ($email->send_mail($recipient, $subject, $message)) {
                        if ($ses->get("otp")) {
                            $ses->pop("otp");
                        }
                        $ses->set("otp", $otp);
                        redirect("verify_OTP/verify");
                    } else {
                        $user->errors["sendemailErr"] = "Please check if your email is correct";
                    }
                }
            }
            // This makes whatever is the output of the validation to the to be automatically set to the data array
            $data["user"] = $user;
            $this->view("{$this->controller}", $data);
        } else {
            $this->view("{$this->controller}");
        }
    }
}