<?php

class Validate
{
    /**
     * Jalankan validasi.
     *
     * Format rules:
     *   'field' => ['required', 'email']
     *   'field' => ['min:6', 'max:255']
     *   'field' => ['confirmed:password']
     *   'field' => ['in:active,inactive']
     *
     * Format custom messages (opsional):
     *   'field.rule' => 'Pesan custom kamu'
     *   e.g. 'email.required' => 'Email wajib diisi!'
     *
     * @param  array  $data      Data input (biasanya $_POST)
     * @param  array  $rules     Rules per field
     * @param  array  $messages  Custom messages (opsional)
     * @return Validator
     */
    public static function check(array $data, array $rules, array $messages = [])
    {
        $v = new Validator();
        $v->setMessages($messages);

        foreach ($rules as $field => $list) {
            foreach ($list as $rule) {

                // Pisahkan rule dari parameternya, contoh: "min:6" → rule=min, param=6
                if (strpos($rule, ':') !== false) {
                    list($ruleName, $param) = explode(':', $rule, 2);
                } else {
                    $ruleName = $rule;
                    $param    = null;
                }

                if (!method_exists($v, $ruleName)) {
                    continue;
                }

                $value = $data[$field] ?? '';

                // Rule dengan parameter + akses ke seluruh $data (untuk confirmed)
                if ($param !== null) {
                    $v->$ruleName($field, $value, $param, $data);
                } else {
                    $v->$ruleName($field, $value);
                }
            }
        }

        return $v;
    }
}
