<?php 

/**
 * Session class
 * Save or read data to the current session
 * 
 */

namespace app\model;

defined("ROOTPATH") OR exit("Access Denied");

class Session
{
    public $mainkey = "APP";
    public $userkey = "USER";
    /**
     * activate session if not yet started
     */

    /** put data into the session */
    public function set(mixed $keyorArray,mixed $value):int
    {

        if(is_array($keyorArray)) {
            foreach ($keyorArray as $key => $value) {
                $_SESSION[$this->mainkey][$key] = $value;
                return 1;
            }
        } else {
            $_SESSION[$this->mainkey][$keyorArray] = $value;
            return 1;
        }
    }

    /** get data from the session, default is return if data not found */
    public function get(string $key, mixed $default = ""):mixed
    {

        if (isset($_SESSION[$this->mainkey][$key])) {
            return $_SESSION[$this->mainkey][$key];
        } else {
            show($_SESSION[$this->mainkey]);
            return $default;
        }
    }
    /** saves the user row data into the session after a login */
    public function auth_user(mixed $user_row):int
    {

        $_SESSION[$this->userkey] = $user_row;
        return 1;
    }

    /** removes user data from the session */
    public function logout():int
    {

        if(!empty($_SESSION[$this->userkey])) {
            unset($_SESSION[$this->userkey]);
        }
        return 1;
    }

    /** checks if user is logged in */
    public function is_logged_in():bool
    {

        if (!empty($_SESSION[$this->userkey])) {
            return true;
        } else {
            return false;
        }
    }

    /** gets data from a column in the session user data */
    public function user(string $key = "", mixed $default = ""):mixed
    {

        if (empty($key) && !empty($_SESSION[$this->userkey])) {
            return $_SESSION[$this->userkey];
        } else {
            if (!empty($_SESSION[$this->userkey][$key])) {
                return $_SESSION[$this->userkey][$key];
            } else {
                return $default;
            }
        }
    }

    /** return data from a key and delete it */
    public function pop(string $key, mixed $default = ""):mixed 
    {

        if (!empty($_SESSION[$this->mainkey][$key])) {
            $value = $_SESSION[$this->mainkey][$key];
            unset($_SESSION[$this->mainkey][$key]);
            return $value;
        } else {
            return $default;
        }
    }
    
    /** returns all data from the APP array */
    public function all():mixed 
    {

        if (!empty($_SESSION[$this->mainkey])) {
            return $_SESSION[$this->mainkey];
        } else {
            return "It is empty";
        }
    }

}