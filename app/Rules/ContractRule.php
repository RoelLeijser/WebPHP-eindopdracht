<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ContractRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $name = $value->getClientOriginalName();
        $path = public_path('storage\contracts\\'.$name);

        if(!file_exists($path)) 
        {
            $fail('The :attribute does not exists within file system');

        }
        else {
            $storage_hash = hash_file('sha256', $path);
            $uploaded_hash = hash_file('sha256', $value->getRealPath());

            if($storage_hash == $uploaded_hash)
            {
                $fail('The :attribute is not modified the original contract is the same as the 1 in file system');
            }
        }
    }
}
