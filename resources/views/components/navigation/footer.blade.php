<footer class="p-10 md:flex md:justify-evenly footer text-primary-500 bg-surface-200">
    <nav>
        <h6 class="opacity-70 footer-title ">Services</h6>
        <a href="{{ route('home') }}" wire:navigate
            class="transition-colors duration-300 link link-hover hover:text-lime-main ">{{ __('Home') }}
        </a>
        <a class="transition-colors duration-300 link link-hover hover:text-lime-main ">{{ __('About') }}</a>
        <a class="transition-colors duration-300 link link-hover hover:text-lime-main ">{{ __('Contact') }}</a>
    </nav>
    <nav>
        <h6 class="opacity-70 footer-title ">Legal</h6>
        <a class="transition-colors duration-300 link link-hover hover:text-lime-main">Terms of use</a>
        <a class="transition-colors duration-300 link link-hover hover:text-lime-main">Privacy policy</a>
        <a class="transition-colors duration-300 link link-hover hover:text-lime-main">Cookie policy</a>
    </nav>
    <nav>
        <form>
            <h6 class="opacity-70 footer-title ">Newsletter</h6>
            <fieldset class="form-control w-80">
                <label class="label">
                    <span class="label-text text-primary-500">{{ __('Enter your email address') }}</span>
                </label>
                <div class="join">
                    <input type="text" placeholder="username@site.com"
                        class="w-full input input-bordered placeholder-lime-shadow/50 bg-surface-300 join-item" />
                    <button
                        class="btn bg-primary-100 hover:bg-surface-100 hover:text-primary-100 text-surface-100 join-item">{{ __('Subscribe') }}</button>
                </div>
            </fieldset>
        </form>
    </nav>
</footer>

<footer
    class="flex flex-wrap justify-around w-full p-10 mb-16 border-t footer text-primary-500 bg-surface-200 md:mb-0 border-surface-600">

    <aside class="flex justify-center md:justify-start">
        <img src="{{ Vite::asset('resources/images/svg/logo-no-background.svg') }}" class="w-full max-h-44">
    </aside>

    <nav class="items-center gap-8 place-self-center">

        <div class="flex items-center gap-1">
            Made with @svg('heroicon-s-heart', ['class' => 'w-5 transition-colors duration-300 hover:text-red-500']) by
            <span class="text-lime-main">HackedHorizon</span>
        </div>

        <div class="flex justify-center w-full animate-bounce">
            <a href="https://github.com/hackedhorizon" target="_"
                class="transition-all duration-300 hover:text-lime-main">@svg('iconoir-github')</a>
        </div>

    </nav>
</footer>
