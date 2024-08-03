<div class="flex flex-col items-center gap-6 mx-5 text-center">

    <p class="text-3xl">{{ __('register.thanks_for_registering') }} </p>
    <p>{{ __('Please click the button below to resend the verification email.') }}</p>

    <x-buttons.primary-button click="resendEmailVerification"
        class="btn btn-neutral w-fit text-primary-500 bg-surface-300 hover:bg-surface-400"
        translation="{{ __('register.resend_verification_email') }}" />
</div>
