<footer class="px-4 py-2 text-gray-600" id="footer">
    <div class="container mx-auto flex flex-wrap items-center justify-center space-y-4 sm:justify-between sm:space-y-0">
        <div class="flex flex-row space-x-4 pr-3 sm:space-x-8">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full">
                <a rel="noopener noreferrer" href="{{ route('welcome') }}">
                    <img src="{{ asset('img/yh-no-bg.png') }}" alt="Logo" class="mt-2 h-12 w-12 dark:invert" />
                </a>
            </div>
            <ul class="flex flex-wrap items-center space-x-4 dark:text-white sm:space-x-8">
                <li>
                    <a rel="noopener noreferrer" href="{{ route('terms') }}" wire:navigate>Terms of Use</a>
                </li>
                <li>
                    <a rel="noopener noreferrer" href="{{ route('privacy') }}" wire:navigate>Privacy</a>
                </li>
                <li>
                    <x-mary-theme-toggle />
                </li>
            </ul>
        </div>
        <ul class="flex flex-wrap space-x-4 pl-3 sm:space-x-8">
            <li>
                <a
                    rel="noopener noreferrer"
                    target="_blank"
                    href="https://www.facebook.com/profile.php?id=61568732690309"
                    class="dark:text-white"
                >
                    Facebook
                </a>
            </li>
            {{--
                <li>
                <a rel="noopener noreferrer" href="#">Twitter</a>
                </li>
            --}}
        </ul>
    </div>
</footer>
