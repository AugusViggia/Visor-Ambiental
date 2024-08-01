<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidLatitude implements Rule
{
    private string $regex;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->regex = config('custom.points.validation.latitude.regex');
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
        return preg_match($this->regex, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('Invalid Latitude');
    }
}
