<?php

declare(strict_types=1);

namespace App;

class Form
{    
    /**
    * @var  Array   Stores rules from form fields
    */
    private $field = array();
  
    /**
    * Execute the validation routine
    *
    * @return 	Array   $errors ["field_name"]["rule"] => "message"
    */
    public function validate()
    {
        $errors = array();
        foreach($this->field as $field) {
            foreach($field[2] as $rule) {
                if(method_exists($this, $rule)) {
                    $error = $this->{$rule}($field[1],$field[3]);
                    if($error) {
                        $errors[$field[0]][$rule] = $error;
                    }
                }
            }
        }
        return $errors; 
    }
       
    /**
    * This function takes a field name, value and set of rules 
    * and appends to member variable for validation
    *
    * @param 	String  $fieldName   The field name
    * @param 	String   $value   The field value
    * @param 	Array   $rules   The validation rules
    */
    public function addRule(string $fieldName, string $value, array $rules)
    {
        $this->field[] = array($fieldName, $value, $rules);
    }
        
    /**
    * Checks if argument has data
    *
    * @param 	String  $data   The field data
    * @return   String  Error message
    */
    private function required(string $data)
    {
        if($data === null || $data === "") {
            return "Missing data field";
        }
    }
        
    /*
     * Generate CSRF Token for injection into HTML form
     * 
     * @return  String  HTML CSRF token hidden input
     */
    public function generateHTMLCSRFToken()
    {
        $token = $this->generateCSRFToken();
        return "<input type = 'hidden' name = 'csrf_token' value = '$token'/>";
    }
    
    /*
     * Generate CSRF token
     * 
     * @return  String  CSRF Token
     */
    public function generateCSRFToken()
    {
        if(function_exists('mcrypt_create_iv')) {
            $_SESSION['csrf_token'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
        } else { 
            $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /*
     * Vaildate CSRF form token
     * 
     * @param   String  $data   CSRF Token 
     * 
     * @return  String  Error message
     */
    private function validateCSRFToken(string $data)
    {
        if(!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $data)) {
            return "Invalid form token, please refresh the page and try again.";
        }
    }
}
