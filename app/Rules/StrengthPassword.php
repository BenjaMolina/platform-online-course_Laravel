<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StrengthPassword implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //Es opcional el campo password
        //Si viene vacio no hacemos ninguna operacion
        if (!$value) {
            return true;
        }

        $uppeercase = preg_match('@[A-Z]@', $value);
        $lowercase  = preg_match('@[a-z]@', $value);
        $number     = preg_match('@[0-9]@', $value);
        $length     = strlen($value) >= 8;

        $succes = true;

        if (!$uppeercase || !$lowercase || !$number || !$length) {
            $succes = false;
        }

        return $succes;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __("El :attribute debe tener 8 caracteres, un numero, una letra mayuscula y una letra minuscula");
    }
}
