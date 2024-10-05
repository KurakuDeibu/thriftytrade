<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'firstName' => ['required', 'string', 'max:255'],
            'middleName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'birthDay' => ['required', 'date'],
            'userAddress' => ['required', 'string', 'max:255'],
            'phoneNum' => ['required', 'string', 'max:11'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'firstName' => $input['firstName'],
            'middleName' => $input['middleName'],
            'lastName' => $input['lastName'],
            'name' => $input['name'],
            'email' => $input['email'],
            'birthDay' => $input['birthDay'],
            'userAddress' => $input['userAddress'],
            'phoneNum' => $input['phoneNum'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
