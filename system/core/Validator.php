<?php

class Validator
{
    protected $errors = [];

    public function required($field, $value)
    {
        if (trim($value) === '') {
            $this->errors[$field][] = 'required';
        }
    }

    public function email($field, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = 'email';
        }
    }

    public function hasError()
    {
        return !empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }
}
