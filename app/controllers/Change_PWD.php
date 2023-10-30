<?php
//Namespace 
namespace app\controller;
// Deny access to some pages
defined("ROOTPATH") OR exit("Access Denied");

/**
 * Change_PWD class
 */

class Change_PWD
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

    public function change_auth()
    {
        $data = [];
        $values = "";
        $passwordsErr = [];
        $passwordErr = [];
        $rptpasswordErr = [];
        $req = new \app\model\Request();
        $ses = new \app\model\Session();
        if ($ses->get("ability")) {
            if ($req->posted()) {
                // show_array($req->post());
                if ($_SESSION["forgot_Email"] && $_SESSION["forgot_Id"]) {
                    $user = new \app\model\User();
                    $password = $req->post("password");
                    $rptpassword = $req->post("rptpassword");
                    $password = test_function($password);
                    $rptpassword = test_function($rptpassword);
                    if (!empty($password) && !empty($rptpassword)) {
                        if (strlen($password) < 8 && strlen($rptpassword) < 8) {
                            $passwordErr["passwordErr"] = "Please password should be more than 8 characters";
                            $rptpasswordErr["rptpasswordErr"] = "Please rptpassword should be more than 8 characters";
                        } else {
                            if ($password == $rptpassword) {
                                $password = password_hash($password, PASSWORD_DEFAULT);
                                $rptpassword = password_hash($password, PASSWORD_DEFAULT);
                                $id = $_SESSION["forgot_Id"];
                                $values = $ses->user();
                                $values["password"] = $password;
                                $values["rptpassword"] = $rptpassword;
                                $values["othername"] = "Fuck That Bitch";
                                $user->update($values, $id);
                                redirect("login/auth");
                            } else {
                                $passwordsErr["passwordsErr"] = "Pls the passwords you put do not match";
                            }
                        }
                    } else {
                        $passwordsErr["passwordsErr"] = "Pls both passwords are required";
                    }
                }
                $data["passwordsErr"] = $passwordsErr;
                $data["passwordErr"] = $passwordErr;
                $data["rptpasswordErr"] = $rptpasswordErr;
                $this->view("{$this->controller}", $data);   
            } else {
                $this->view("{$this->controller}");
            }
        } else {
            redirect("home");
        }
    }
}