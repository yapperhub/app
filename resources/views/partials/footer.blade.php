<footer class="px-4 py-8 text-gray-600" id="footer">
    <div class="container mx-auto flex flex-wrap items-center justify-center space-y-4 sm:justify-between sm:space-y-0">
        <div class="flex flex-row space-x-4 pr-3 sm:space-x-8">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full">
                <a rel="noopener noreferrer" href="{{ route('welcome') }}">
                    <img src="{{ asset('img/yh-no-bg.png') }}" alt="Logo" class="mt-2 h-12 w-12" />
                </a>
            </div>
            <ul class="flex flex-wrap items-center space-x-4 sm:space-x-8">
                <li>
                    <a rel="noopener noreferrer" href="{{ route('terms') }}">Terms of Use</a>
                </li>
                <li>
                    <a rel="noopener noreferrer" href="{{ route('privacy') }}">Privacy</a>
                </li>
            </ul>
        </div>
        <ul class="flex flex-wrap space-x-4 pl-3 sm:space-x-8">
            <li>
                <a rel="noopener noreferrer" href="#">Instagram</a>
            </li>
            <li>
                <a rel="noopener noreferrer" href="#">Facebook</a>
            </li>
            <li>
                <a rel="noopener noreferrer" href="#">Twitter</a>
            </li>
        </ul>
    </div>
</footer>
