<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'firstName' => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z\s-]+$/'],
            'lastName' => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z\s-]+$/'],
            'middleName' => ['nullable','string', 'max:50', 'regex:/^[a-zA-Z\s-]+$/'],
            'userAddress' => ['required','string', 'max:50'],
            'birthDay' => ['required','string', 'max:50'],
            'phoneNum' => ['required','string', 'min:11'],

            'name' => ['required', 'string', 'max:25'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'firstName' => $input['firstName'],
                'lastName' => $input['lastName'],
                'middleName' => $input['middleName'],
                'userAddress' => $input['userAddress'],
                'birthDay' => $input['birthDay'],
                'phoneNum' => $input['phoneNum'],
                'name' => $input['name'],
                'email' => $input['email'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'firstName' => $input['firstName'],
            'lastName' => $input['lastName'],
            'middleName' => $input['middleName'],
            'userAddress' => $input['userAddress'],
            'birthDay' => $input['birthDay'],
            'phoneNum' => $input['phoneNum'],
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}