<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Illuminate\Foundation\Auth\User;
class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param  User  $user
     * @param  array<string, string>  $input
     * @return void
     */
    public function update(User $user, array $input): void
    {
        // Define validation rules
        $validator = Validator::make($input, [
            'current_password' => ['required', 'string', 'current_password:web'],
            'password' => [
                'required',
                'string',
                'min:8', // Ensure the new password is at least 8 characters long
                'different:current_password', // Ensure the new password is different from the current one
            ],
        ], [
            'current_password.current_password' => __('The provided password does not match your current password.'),
            'password.min' => __('The new password must be at least 8 characters.'),
            'password.different' => __('The new password cannot be the same as the current password.'),
        ]);

        // Validate input and handle errors
        $validator->validateWithBag('updatePassword');

        // Update the user's password
        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
