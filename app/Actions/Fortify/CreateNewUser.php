<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $this->validate($input);

        $user = $this->createUser($input);

        $this->setRole($user);

        flashAlert(
            __('Register requested')
        );

        return $user;
    }

    /**
     * @param array $input
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validate(array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'document_number' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')
                    ->whereNull('deleted_at'),
            ],
            'institution' => ['required', 'string', 'max:255'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();
    }

    /**
     * @param array $input
     * @return mixed
     */
    protected function createUser(array $input)
    {
        return User::create([
            'name' => $input['name'],
            'document_number' => $input['document_number'],
            'email' => $input['email'],
            'institution' => $input['institution'],
            'password' => Hash::make($input['password']),
            'requested_at' => Carbon::now(),
        ]);
    }

    /**
     * @param mixed $user
     * @return void
     */
    protected function setRole(mixed $user): void
    {
        $user->assignRole('USI');
    }
}
