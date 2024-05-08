<section class="hero">
    <div class="w-full max-w-screen-sm px-10 hero-content">
        <div class="w-full card bg-surface-200">

            <h1 class="pt-4 text-xl font-bold leading-tight tracking-tight text-center text-white md:text-2xl">
                <p>{{ __('Reset Password') }}</p>
            </h1>

            <form wire:submit.prevent="sendResetPasswordEmailNotification" class="space-y-4 card-body md:space-y-6">
                <div class="form-control">
                    <label for="email" class="label">
                        <span class="label-text text-primary-500">Email</span>
                    </label>

                    <x-forms.input id="email" name="email" type="email" placeholder="Email" variable="email"
                        class="w-full input input-bordered placeholder-lime-shadow/50 bg-surface-300" />
                </div>

                <div class="mt-6 form-control">
                    <button class="btn btn-neutral text-primary-500 bg-surface-300 hover:bg-surface-400"
                        type="submit">{{ __('Send') }}</button>
                </div>
            </form>

            {{-- Reset password error message --}}
            <x-forms.error attribute='reset-password' />
        </div>
    </div>
</section>
