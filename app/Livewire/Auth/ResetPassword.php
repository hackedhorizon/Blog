<?php

namespace App\Livewire\Auth;

use App\Modules\Authentication\Services\ResetPasswordService;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Mary\Traits\Toast;

class ResetPassword extends Component
{
    use Toast;

    #[Locked]
    public $token;

    public $email;

    public $password;

    public $password_confirmation;

    public $status;

    public function render()
    {
        return view('livewire.auth.reset-password');
    }

    public function mount($token)
    {
        $this->token = $token;
        $this->email = request()->query('email');
    }

    public function resetPassword(ResetPasswordService $resetPasswordService)
    {
        $this->validate([
            'token' => 'required',
            'email' => 'required|email|max:50',
            'password' => 'required|string|min:6|max:300',
        ]);

        $resetPasswordService->setCredentials([
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
            'token' => $this->token,
        ]);

        $status = $resetPasswordService->resetPassword();

        return $this->handlePasswordResetStatus($status);
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

        session()->flash('mary.toast.type', $method);

        $this->{$method}(
            title: $message,
            redirectTo: route('login')
        );
    }
}
