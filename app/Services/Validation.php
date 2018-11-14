<?php
namespace App\Services;

use Illuminate\Validation\Validator;

class Validation extends Validator
{
    public function ValidateUsername($attribute, $value, $parameters)
    {
//        return preg_match("/^[A-Za-z0-9_]*$/", $value);
        return preg_match("/^[A-Za-z]*$/", $value);
    }
}
?>