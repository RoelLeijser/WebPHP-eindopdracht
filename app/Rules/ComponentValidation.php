<?php

namespace App\Rules;

use Closure;

use App\Models\Component;
use Illuminate\Contracts\Validation\ValidationRule;

class ComponentValidation implements ValidationRule
{

    public function __construct($params) 
    {
        $this->first = $params['first'];
        $this->second = $params['second'];
        $this->third = $params['third'];
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if(!Component::where('name', $value)->exists() && !is_null($value)) {
            $fail('The component must exist.');
        }

        if (($attribute == 'first' && ($value == $this->second || $value == $this->third) && !is_null($value)) 
                || ($attribute == 'second' && ($value == $this->first || $value == $this->third) && !is_null($value)) 
                || ($attribute == 'third' && ($value == $this->first || $value == $this->second) && !is_null($value))) {
            $fail('The component must be unique');
        }
    }
}
