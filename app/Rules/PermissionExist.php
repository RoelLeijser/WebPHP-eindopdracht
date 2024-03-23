<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Spatie\Permission\Models\Permission;

class PermissionExist implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $permissions = Permission::all()->pluck('name');
        foreach($value as $item){
            if(!$permissions->contains($item)) {
                $fail('The :attribute must exist.');
            }
        }


    }
}
