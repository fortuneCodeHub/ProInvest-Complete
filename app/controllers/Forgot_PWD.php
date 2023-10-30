<?php
//Namespace 
namespace app\controller;
// Deny access to some pages
defined("ROOTPATH") OR exit("Access Denied");

/**
 * Forgot_PWD class
 */

class Forgot_PWD
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
        $emailErr = [];
        $data = [];
        $req = new \app\model\Request();
        if ($req->posted()) {
            if (!empty($req->post("email"))) {
                $emailPost = $req->post("email");
                $user = new \app\model\User();
                $users = $user->query("SELECT * FROM users");
                foreach ($users as $key => $userValue) {
                    if ($userValue["email"] == $emailPost) {
                        if ($_SESSION["forgot_Email"] && $_SESSION["forgot_Id"]) {
                            unset($_SESSION["forgot_Email"]);
                            unset($_SESSION["forgot_Id"]);
                        }
                        $_SESSION["forgot_Email"] = $emailPost;
                        $_SESSION["forgot_Id"] = $userValue["id"];
                        $otp = rand(100000, 999999);
                        $ses = new \app\model\Session();
                        if ($ses->get("otp")) {
                            $ses->pop("otp");
                        }
                        $ses->set("otp", $otp);
                        $email = new \app\model\Email();
                        $recipient = $_SESSION["forgot_Email"];
                        $subject = "Email Verification";
                        $message = "<p></p>Your OTP Verification code is <b>$otp</b></p>
                        <p>Use this to verify your account</p>";
                        if ($email->send_mail($recipient, $subject, $message)) {
                            redirect("verify_OTP/forgot_password");
                        } else {
                            return false;
                        }
                    } else {
                        $emailErr["emailErr"] = "This email does not exist";
                    }
                }
            } else {
                $emailErr["emailErr"] = "Pls the email is required";
            }
            $data["emailErr"] = $emailErr;
            $this->view("{$this->controller}", $data);
        } else {
            $this->view("{$this->controller}");
        }
        
    }
}