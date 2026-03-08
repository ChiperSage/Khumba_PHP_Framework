<?php

class Validator
{
    protected $errors   = [];
    protected $messages = [];

    // -------------------------------------------------------
    // Custom messages
    // -------------------------------------------------------

    public function setMessages(array $messages)
    {
        $this->messages = $messages;
        return $this;
    }

    protected function addError($field, $rule, $default)
    {
        $key = $field . '.' . $rule;
        $this->errors[$field][] = $this->messages[$key] ?? $default;
    }

    // -------------------------------------------------------
    // Rules
    // -------------------------------------------------------

    /** Field wajib diisi */
    public function required($field, $value)
    {
        if (trim((string)$value) === '') {
            $this->addError($field, 'required', "Field $field wajib diisi.");
        }
    }

    /** Harus berformat email valid */
    public function email($field, $value)
    {
        if ($value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, 'email', "Field $field harus berupa email valid.");
        }
    }

    /** Hanya boleh angka (integer atau float) */
    public function numeric($field, $value)
    {
        if ($value !== '' && !is_numeric($value)) {
            $this->addError($field, 'numeric', "Field $field harus berupa angka.");
        }
    }

    /** Hanya boleh bilangan bulat */
    public function integer($field, $value)
    {
        if ($value !== '' && filter_var($value, FILTER_VALIDATE_INT) === false) {
            $this->addError($field, 'integer', "Field $field harus berupa bilangan bulat.");
        }
    }

    /** Panjang minimum karakter — format: min:6 */
    public function min($field, $value, $param)
    {
        $param = (int) $param;
        if ($value !== '' && mb_strlen((string)$value) < $param) {
            $this->addError($field, 'min', "Field $field minimal $param karakter.");
        }
    }

    /** Panjang maksimum karakter — format: max:255 */
    public function max($field, $value, $param)
    {
        $param = (int) $param;
        if ($value !== '' && mb_strlen((string)$value) > $param) {
            $this->addError($field, 'max', "Field $field maksimal $param karakter.");
        }
    }

    /** Nilai minimum angka — format: min_val:1 */
    public function min_val($field, $value, $param)
    {
        if ($value !== '' && is_numeric($value) && (float)$value < (float)$param) {
            $this->addError($field, 'min_val', "Field $field tidak boleh kurang dari $param.");
        }
    }

    /** Nilai maksimum angka — format: max_val:100 */
    public function max_val($field, $value, $param)
    {
        if ($value !== '' && is_numeric($value) && (float)$value > (float)$param) {
            $this->addError($field, 'max_val', "Field $field tidak boleh lebih dari $param.");
        }
    }

    /** Harus sama dengan field lain — format: confirmed:password */
    public function confirmed($field, $value, $param, $data = [])
    {
        if ($value !== ($data[$param] ?? '')) {
            $this->addError($field, 'confirmed', "Field $field tidak cocok dengan $param.");
        }
    }

    /** Hanya boleh huruf (a-z, A-Z) */
    public function alpha($field, $value)
    {
        if ($value !== '' && !ctype_alpha(str_replace(' ', '', $value))) {
            $this->addError($field, 'alpha', "Field $field hanya boleh berisi huruf.");
        }
    }

    /** Hanya boleh huruf dan angka */
    public function alpha_num($field, $value)
    {
        if ($value !== '' && !ctype_alnum(str_replace(' ', '', $value))) {
            $this->addError($field, 'alpha_num', "Field $field hanya boleh berisi huruf dan angka.");
        }
    }

    /** Harus berupa URL valid */
    public function url($field, $value)
    {
        if ($value !== '' && !filter_var($value, FILTER_VALIDATE_URL)) {
            $this->addError($field, 'url', "Field $field harus berupa URL valid.");
        }
    }

    /** Harus salah satu dari nilai yang diizinkan — format: in:active,inactive,pending */
    public function in($field, $value, $param)
    {
        $allowed = explode(',', $param);
        if ($value !== '' && !in_array($value, $allowed)) {
            $this->addError($field, 'in', "Field $field berisi nilai yang tidak diizinkan.");
        }
    }

    /** Harus berupa tanggal valid (Y-m-d) */
    public function date($field, $value)
    {
        if ($value !== '') {
            $d = \DateTime::createFromFormat('Y-m-d', $value);
            if (!$d || $d->format('Y-m-d') !== $value) {
                $this->addError($field, 'date', "Field $field harus berupa tanggal valid (YYYY-MM-DD).");
            }
        }
    }

    // -------------------------------------------------------
    // Result helpers
    // -------------------------------------------------------

    public function hasError()
    {
        return !empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }

    /** Ambil pesan error pertama dari semua field */
    public function firstErrors()
    {
        $first = [];
        foreach ($this->errors as $field => $messages) {
            $first[$field] = $messages[0];
        }
        return $first;
    }

    /** Ambil pesan error pertama dari field tertentu */
    public function first($field)
    {
        return $this->errors[$field][0] ?? null;
    }
}
