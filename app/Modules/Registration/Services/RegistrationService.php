<?php

namespace App\Modules\Registration\Services;

use App\Models\User;
use App\Modules\Registration\Interfaces\RegistrationServiceInterface;
use App\Modules\UserManagement\Services\WriteUserService;
use App\Notifications\SuccessfulRegistrationNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class RegistrationService implements RegistrationServiceInterface
{
    private WriteUserService $userService;

    public function __construct(WriteUserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * {@inheritdoc}
     */
    public function registerUser(string $name, string $username, string $email, string $password): User
    {
        // Hash the password
        $hashedPassword = Hash::make($password);

        // Create a new user with the provided data
        $user = $this->userService->createUser($name, $username, $email, $hashedPassword);

        // Send the verification email to the user and create a notification in the database
        if (config('services.should_verify_email')) {
            event(new Registered($user));
            $user->notify(new SuccessfulRegistrationNotification());
        }

        // Return the registered user object
        return $user;
    }
}
