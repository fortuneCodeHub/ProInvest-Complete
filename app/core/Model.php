<?php
// Namespace
namespace app\core;
// Deny access to some pages
defined("ROOTPATH") OR exit("Access Denied");
/**
 * Main Model Trait
 */

Trait MainModel
{
    use Database;
    // This is how you add more traits to the class
    # use Database, Home, Controller, Product etc

    protected $limit = 10;
    protected $offset = 0;
    protected $order_type = "DESC";
    protected $order_column = "date";
    public $errors = [];

    public function findAll()
    {
        $query = "SELECT * FROM {$this->table} ORDER BY {$this->order_column} {$this->order_type} LIMIT {$this->limit} OFFSET {$this->offset}";
        $result = $this->query($query);
        if ($result) {
            return $result;
        } else {
            return false;
        }
        
    }

    public function where($data, $data_not = [])
    {
        
        $query = "SELECT * FROM {$this->table} WHERE ";
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        foreach ($keys as $key) {
            $query .= "$key = :$key && ";
        }
        foreach ($keys_not as $key) {
            $query .= "$key != :$key && ";
        }
        $query = trim($query, " && ");
        $query .= " ORDER BY {$this->order_column} {$this->order_type} LIMIT {$this->limit} OFFSET {$this->offset}";
        $data = array_merge($data, $data_not);
        $result = $this->query($query, $data);
        if ($result) {
            return $result;
        } else {
            return false;
        }
        
    }

    public function first($data, $data_not=[])
    {
        $query = "SELECT * FROM {$this->table} WHERE ";
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        foreach ($keys as $key) {
            $query .= "$key = :$key && ";
        }
        foreach ($keys_not as $key) {
            $query .= "$key != :$key && ";
        }
        $query = trim($query, " && ");
        $query .= " LIMIT {$this->limit} OFFSET {$this->offset}";
        $data = array_merge($data, $data_not);
        $result = $this->query($query, $data);
        if ($result) {
            return $result[0];
        } else{
            return false;
        }
    }

    public function insert($data):void
    {
        // Remove Unwanted Data
        if (!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }
        $keys  = array_keys($data);
        $query = "INSERT INTO {$this->table}(". implode(", ", $keys). ")
        VALUES( :". implode(", :",$keys). ")";
        $this->query($query, $data);   
    }

    public function update($data, $id, $id_column = "id")
    {
        // Remove unwanted data
        if (!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }
        $query = "UPDATE {$this->table} SET ";
        foreach ($data as $key => $value) {
            $query .= "$key = :$key, ";
        }
        $query = trim($query, ", ");
        $query .= " WHERE $id_column = :$id_column";
        $data[$id_column] = $id;
        $this->query($query, $data);
    }

    public function delete($id, $id_column = "id"):void
    {
        $query = "DELETE FROM {$this->table} WHERE $id_column = :$id_column";
        $data[$id_column] = $id;
        $this->query($query, $data);
    }


    protected function getPrimaryKey():string
    {
        return $this->primaryKey ?? "id";
    }

    /** 
     * alpha,
     * alpha_space,
     * alpha_numeric,
     * alpha_symbol,
     * alpha_numeric_symbol,
     * email,
     * unique,
     * not_less_than_8_chars,
     * required
     */
    public function  validate($data) 
    {
        $this->errors  = [];

        if (!empty($this->validationRules)) {
            foreach ($this->validationRules as $column => $rules) {
                if (!isset($data[$column])) {
                    continue;
                } else {        
                    if (is_array($rules)) {
                        foreach ($rules as $rule) {
                        switch ($rule) {
                            case 'not_less_than_8_chars':
                                if (strlen(test_function($data[$column])) < 8) {
                                    $this->errors["{$column}Err"] = ucfirst($column)." should be greater than 8 characters";
                                }
                                break;
                            case 'email':
                                if (!filter_var(test_function($data[$column]), FILTER_VALIDATE_EMAIL)) {
                                    $this->errors["{$column}Err"] = "Invalid Email Address";
                                }
                                break;
                            case 'alpha':
                                if (!preg_match("/^[a-zA-Z]+$/", test_function($data[$column]))) {
                                    $this->errors["{$column}Err"] = ucfirst($column)." should only have alphabetical letters";
                                }
                                break;
                            case 'alpha_space':
                                if (!preg_match("/^[a-zA-Z ]+$/", test_function($data[$column]))) {
                                    $this->errors["{$column}Err"] = ucfirst($column)." should only have alphabetical letters & white spaces";
                                }
                                break;
                            case 'unique':
                                $primarykey = $this->getPrimaryKey();
                                if (!empty($data[$primarykey])) {
                                    // edit mode
                                    $user = $this->where([$column => test_function($data[$column])], [$column => $data[$primarykey]]);
                                    if ($user) {
                                        $this->errors["{$column}Err"] = "This $column already exists";
                                    }
                                } else {
                                    // insert mode
                                    $user = $this->where([$column => test_function($data[$column])]);
                                    if ($user) {
                                        $this->errors["{$column}Err"] = "This $column already exists";
                                    }
                                }
                                break;
                            case 'alpha_numeric':
                                if (!preg_match("/^[a-zA-Z0-9]+$/", test_function($data[$column]))) {
                                    $this->errors["{$column}Err"] = ucfirst($column)." should only have alphabetical letters & numbers";
                                }
                                break;
                            case 'alpha_symbol':
                                if (!preg_match("/^[a-zA-Z\-\_\[\]\(\)\%\:\;\*\&]+$/", test_function($data[$column]))) {
                                    $this->errors["{$column}Err"] = ucfirst($column)." should only have alphabetical letters and symbols";
                                }
                                break;
                            case 'alpha_numeric_symbol':
                                if (!preg_match("/^[a-zA-Z0-9\-\_\[\]\(\)\%\:\;\*]+$/", test_function($data[$column]))) {
                                    $this->errors["{$column}Err"] = ucfirst($column)." should only have alphabetical letters, numbers and symbols";
                                }
                                break;
                            case 'required':
                                if (empty(test_function($data[$column]))) {
                                    $this->errors["{$column}Err"] = "This $column is required";
                                }
                                break;
                            default:
                                $this->errors["ruleErr"] = "The rule $rule was not found";
                                break;
                        }
                        }
                    }
                }
            }
        }
        if (empty($this->errors)) {
            foreach ($data as $key => $value) {
                $value = test_function($value);
                $this->validate_data[$key] = $value;
            }
            return true;
        } else {
            return false;
        }
    }

    // public function check_validate($data)
    // {
    //     $this->errors = [];
    //     if (!empty($this->CheckandValidateRules)) {
    //         foreach ($this->CheckandValidateRules as $column => $rules) {
    //             if(!isset($data[$column])) {
    //                 continue;
    //             } else {
    //                 if (is_array($rules)) {
    //                     foreach($rules as $rule) {
    //                         switch ($rule) {
    //                             case 'required':
    //                                 if (empty(test_function($data[$column]))) {
    //                                     $this->errors["{$column}Err"] = "This $column is required";
    //                                 }
    //                                 break;
    //                             default:
    //                                 $this->errors[$rule] = "This rule $rule was not found";
    //                                 break;
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }
    //     if (empty($this->errors)) {
    //         foreach($data as $key => $value){
    //             $value = test_function($value);
    //             $this->validate_data[$key] = $value;
    //         }
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
}