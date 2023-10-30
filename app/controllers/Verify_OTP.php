<?php
//Namespace 
namespace app\controller;
// Deny access to some pages
defined("ROOTPATH") OR exit("Access Denied");

/**
 * Verify_OTP class
 */

class Verify_OTP
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

    public function verify()
    {
        $otpErr = [];
        $req = new \app\model\Request();
        $URL = explode("/", $req->get("url"));
        $count = count($URL);
        if ($count < 3) {
            if ($req->posted()) {
                if (!empty($_SESSION["APP"])) {
                    $ses = new \app\model\Session();
                    $sesOTP = $ses->get("otp");
                    $postOTP = $req->post("otp");
                    if (!empty($postOTP)) {
                        if ($sesOTP == $postOTP) {
                            $user = new \app\model\User();
                            if (!empty($ses->user())) {
                                $ses->pop("otp");
                                $user->insert($ses->user());
                                redirect("login/auth/SignUpSuccessful");
                            }
                        } else {
                            $otpErr["otpErr"] = "Pls confirm the OTP Verification Code and Try Again";
                        }
                    } else {
                        $otpErr["otpErr"] = "Pls input the OTP Verification Code sent to your email";
                    }
                }
                $data["otpErr"] = $otpErr;
                $this->view("{$this->controller}", $data);
            } else {
                $this->view("{$this->controller}");
            }
        } elseif ($URL[2] == "resend") {
            if($this->resend_verify()) {
                if ($req->posted()) {
                    if (!empty($_SESSION["APP"])) {
                        $ses = new \app\model\Session();
                        $sesOTP = $ses->get("otp");
                        $postOTP = $req->post("otp");
                        if (!empty($postOTP)) {
                            if ($sesOTP == $postOTP) {
                                $user = new \app\model\User();
                                if (!empty($ses->user())) {
                                    $ses->pop("otp");
                                    $user->insert($ses->user());
                                    redirect("login/auth/SignUpSuccessful");
                                }
                            } else {
                                $otpErr["otpErr"] = "Pls confirm the OTP Verification Code and Try Again";
                            }
                        } else {
                            $otpErr["otpErr"] = "Pls input the OTP Verification Code sent to your email";
                        }
                    }
                    $data["otpErr"] = $otpErr;
                    $this->view("{$this->controller}", $data);
                } else {
                    $this->view("{$this->controller}");
                }
            } else {
                echo "Error in resending OTP Verification code";
            }
        }
    }

    public function resend_verify()
    {
        $email = new \app\model\Email();
        $ses = new \app\model\Session();
        $recipient = $ses->user("email");
        $subject = "Email Verification";
        $otp = rand(100000, 999999);
        if ($ses->get("otp")) {
            $ses->pop("otp");
        }
        $ses->set("otp", $otp);
        $message = "<p></p>Your OTP Verification code is <b>$otp</b></p>
        <p>Use this to verify your account</p>";
        if ($email->send_mail($recipient, $subject, $message)) {
            return true;
        } else {
            return false;
        }
    }

    public function forgot_password() 
    {
        $otpErr = [];
        $req = new \app\model\Request();
        $URL = explode("/", $req->get("url"));
        $count = count($URL);
        if ($count < 3) {
            if ($req->posted()) {
                if (!empty($_SESSION["APP"])) {
                    $ses = new \app\model\Session();
                    $sesOTP = $ses->get("otp");
                    $postOTP = $req->post("otp");
                    if (!empty($postOTP)) {
                        if ($sesOTP == $postOTP) {
                            $ses->pop("otp");
                            $ses->set("ability", "Change Password Abilty");
                            redirect("change_PWD/change_auth");
                        } else {
                            $otpErr["otpErr"] = "Pls confirm the OTP Verification Code and Try Again";
                        }
                    } else {
                        $otpErr["otpErr"] = "Pls input the OTP Verification Code sent to your email";
                    }
                }
                $data["otpErr"] = $otpErr;
                $this->view("{$this->controller}", $data);
            } else {
                $this->view("{$this->controller}");
            }
        } elseif ($URL[2] == "resend") {
            if($this->resend_verify()) {
                if ($req->posted()) {
                    if (!empty($_SESSION["APP"])) {
                        $ses = new \app\model\Session();
                        $sesOTP = $ses->get("otp");
                        $postOTP = $req->post("otp");
                        if (!empty($postOTP)) {
                            if ($sesOTP == $postOTP) {
                                $ses->pop("otp");
                                $ses->set("ability", "Change Password Abilty");
                                redirect("change_PWD/change_auth");
                            } else {
                                $otpErr["otpErr"] = "Pls confirm the OTP Verification Code and Try Again";
                            }
                        } else {
                            $otpErr["otpErr"] = "Pls input the OTP Verification Code sent to your email";
                        }
                    }
                    $data["otpErr"] = $otpErr;
                    $this->view("{$this->controller}", $data);
                } else {
                    $this->view("{$this->controller}");
                }
            } else {
                echo "Error in resending OTP Verification code";
            }
        }
    }
}