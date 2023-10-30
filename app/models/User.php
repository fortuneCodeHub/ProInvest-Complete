<?php
// Namespace
namespace app\model;
// Deny access to some pages
defined("ROOTPATH") OR exit("Access Denied");


class User 
{
    use \app\core\MainModel;

    public $table = "users";
    protected $primaryKey = "id";
    protected $allowedColumns = [
        "firstname", "othername", "username" ,"email", "password", "rptpassword", "term"
    ];
    public $validate_data = [];
    /************************
     * rules include:
     * alpha,
     * alpha_space,
     * email,
     * unique,
     * not_less_than_8_chars,
     * required,
     * alpha_numeric,
     * alpha_symbol,
     * alpha_numeric_symbol
     * 
     * NOTE- That the lower the rule is in the array the higher it's priority
    ************************/
    protected $validationRules = [];

    // protected $CheckandValidateRules = [
    //     "name" => [
    //         "required"
    //     ],
    //     "password" =>[
    //         "required"
    //     ]
    // ];

    // public function getname()
    // {
    //     return "Fish is for free";
    // } 

    public function getError($key)
    {
        if (!empty($this->errors[$key])) {
            return $this->errors[$key];
        } else {
            return "";
        }
    }
 
    public function signup($data)
    {
        $this->validationRules = [
            "firstname" => [
                "required"
            ],
            "othername" => [
                "required"
            ],
            "username" => [
                "required",
                "unique"
            ],
            "email" => [
                "unique",
                "email",
                "required"
            ],
            "password" => [
                "not_less_than_8_chars",
                "required"
            ],
            "rptpassword" => [
                "not_less_than_8_chars",
                "required"
            ],
            "term" => [
                "required"
            ]
        ];
        if ($this->validate($data)) {
            // Add more validation to the form
            $validatedData = $this->validate_data;
            if (!empty($validatedData)) {
                // Check the passwords whether they match
                if(!empty($validatedData["rptpassword"]) && !empty($validatedData["password"])) {
                    if ($validatedData["password"] == $validatedData["rptpassword"]) {
                        $validatedData["password"] = password_hash($validatedData["password"], PASSWORD_DEFAULT);
                        $validatedData["rptpassword"] = password_hash($validatedData["rptpassword"], PASSWORD_DEFAULT);
                    } else {
                        $this->errors["passwordErr"] = "The password and repeat password you inputed don't match";
                        $this->errors["rptpasswordErr"] = "The password and repeat password you inputed don't match";
                    }
                }
            }

            if (empty($this->errors)) {
                unset($validatedData["term"]);
                $ses = new \app\model\Session();
                if ($ses->auth_user($validatedData)) {
                    return true;
                }
            } else {
                return false;
            }
        }
        return false;
    }

    public function signin($data)
    {
        $this->validationRules = [
            "email" => [
                "required"
            ],
            "password" =>[
                "required"
            ]
            ];
        $emailNotExist = "";
        if ($this->validate($data)) {
            $validatedData = $this->validate_data;
            if(!empty($validatedData)) {
                if($data["email"]) {
                    if (empty($this->errors)) {
                        $users = $this->query("SELECT * FROM ".$this->table);
                        foreach ($users as $user) {
                            if ($data["email"] == $user["email"]) {
                                $pwdhashed = $user["password"];
                                $checkpwd  = password_verify($data["password"], $pwdhashed);
                                if ($checkpwd) {
                                    $this->validate_data["id"] = $user["id"];
                                    foreach ($this->validate_data as $key => $value) {
                                        if ($key == "password") {
                                            continue;
                                        }
                                        $userV[$key] = $value;
                                    }
                                    if (!$_SESSION["login_details"]) {
                                        $_SESSION["login_details"] = $userV;
                                    }
                                    return true;
                                } else {
                                    $this->errors["passwordErr"] = "This password is incorrect or it does not exist";
                                    return false;
                                }
                            }
                        }
                        $this->errors["emailErr"] = "The username or email you put is incorrect or does not exist";
                        return false;
                    } else {
                        return false;
                    }
                }
            }
        }
        return false;
    }
}
