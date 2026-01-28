<?php

class Validate
{
    public static function check($data, $rules)
    {
        $v = new Validator();

        foreach ($rules as $field => $list) {
            foreach ($list as $rule) {
                if (method_exists($v, $rule)) {
                    $v->$rule($field, $data[$field] ?? '');
                }
            }
        }

        return $v;
    }
}
