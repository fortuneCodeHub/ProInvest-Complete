<?php
// Namespace
namespace app\model;
// Deny access to some pages
defined("ROOTPATH") OR exit("Access Denied");

/**
 * {CLASSNAME} class
 */

class {CLASSNAME}
{
    use \app\core\MainModel;

    protected $table = "";
    protected $primaryKey = "id";
    protected $allowedColumns = [
        "name", "age", "email", "password", "term"
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
    protected $validationRules = [
        "name" => [
            "unique",
            "alpha_space",
            "required"
        ],
        "age" => [
            "required"
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
}




