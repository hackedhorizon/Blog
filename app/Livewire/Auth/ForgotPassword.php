<?php

namespace App\Livewire\Auth;

use App\Modules\Authentication\Services\ResetPasswordService;
use App\Modules\RateLimiter\Services\RateLimiterService;
use Illuminate\Support\Facades\Password;
use Livewire\Component;
use Mary\Traits\Toast;

class ForgotPassword extends Component
{
    use Toast;

    public $email;

    public $status;

    private RateLimiterService $rateLimiterService;

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }

    public function boot(RateLimiterService $rateLimiterService)
    {
        $this->rateLimiterService = $rateLimiterService;
        $this->rateLimiterService
            ->setDecayOfSeconds(60)
            ->setCallerMethod('sendResetPasswordEmailNotification')
            ->setAllowedNumberOfAttempts(5)
            ->setErrorMessageAttribute('reset-password');
    }

    public function sendResetPasswordEmailNotification(ResetPasswordService $resetPasswordService)
    {
        $this->rateLimiterService->checkTooManyFailedAttempts();

        $this->validate([
            'email' => 'required|email|max:50',
        ]);

        $status = $resetPasswordService->sendResetPasswordLink($this->email);

        $this->handlePasswordResetStatus($status);
    }

    private function handlePasswordResetStatus($status)
    {
        $titles = [
            Password::RESET_LINK_SENT => __('passwords.sent'),
            Password::PASSWORD_RESET => __('passwords.reset'),
            Password::INVALID_USER => __('passwords.user'),
            Password::INVALID_TOKEN => __('passwords.token'),
            Password::RESET_THROTTLED => __('passwords.throttled'),
            'default' => __('passwords.error'),
        ];

        $message = $titles[$status] ?? $titles['default'];
        $method = in_array($status, [Password::RESET_LINK_SENT, Password::PASSWORD_RESET]) ? 'success' : 'error';

        $this->{$method}(
            title: $message,
            redirectTo: route('home')
        );
    }
}
