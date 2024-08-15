<?php

namespace App\Livewire\Auth;

use App\Modules\Authentication\Services\LoginService;
use App\Modules\RateLimiter\Services\RateLimiterService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class Login extends Component
{
    use Toast;

    #[Validate('required|string|max:50')]
    public string $identifier = '';

    #[Validate('required|string|min:6|max:300')]
    public string $password = '';

    public bool $remember = false;

    private RateLimiterService $rateLimiterService;

    private string $pageTitle = '';

    public function render()
    {
        return view('livewire.auth.login')->title($this->pageTitle);
    }

    public function mount()
    {
        // If user already logged in, redirect to home page.
        if (Auth::check()) {
            return $this->redirect(route('home'), navigate: true);
        }

        $this->pageTitle = __('Login');
    }

    public function boot(RateLimiterService $rateLimiterService)
    {
        $this->rateLimiterService = $rateLimiterService;

        $this->rateLimiterService->setDecayOfSeconds(60)
            ->setCallerMethod('login')
            ->setAllowedNumberOfAttempts(3)
            ->setErrorMessageAttribute('login.throttled');
    }

    public function login(LoginService $loginService)
    {
        // Check for too many failed login attempts
        $this->rateLimiterService->checkTooManyFailedAttempts();

        // Validate form fields
        $this->validate();

        // Authentication attempt
        if ($loginService->attemptLogin($this->identifier, $this->password, $this->remember)) {

            // Clear the rate limiter
            $this->rateLimiterService->clearLimiter();

            // Redirect user to the main page
            return $this->success(
                title: __('auth.success'),
                description: __('auth.success_description'),
                redirectTo: route('home')
            );
        }

        // Authentication failed
        $this->error(
            title: __('auth.failed'),
        );
    }
}
