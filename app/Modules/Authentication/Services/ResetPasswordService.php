<?php

namespace App\Modules\Authentication\Services;

use App\Modules\Authentication\Interfaces\ResetPasswordServiceInterface;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordService implements ResetPasswordServiceInterface
{
    private string $email;

    private string $password;

    private string $password_confirmation;

    private string $token;

    public function __construct() {}

    public function setCredentials(array $credentials): void
    {
        $this->email = $credentials['email'];
        $this->password = $credentials['password'];
        $this->password_confirmation = $credentials['password_confirmation'];
        $this->token = $credentials['token'];
    }

    public function sendResetPasswordLink(string $email): string
    {
        return Password::sendResetLink(['email' => $email]);
    }

    public function resetPassword(): string
    {
        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status;
    }
}
