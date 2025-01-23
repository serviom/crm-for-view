<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;

class UserExistsWithTrashed implements Rule
{
    public function passes($attribute, $value)
    {
        return User::withTrashed()->where('id', $value)->exists();
    }

    public function message()
    {
        return 'Цей користувач не існує або був видалений.';
    }
}
