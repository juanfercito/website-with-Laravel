<header class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="header-fluid">
        <!-- Links to Go -->
        <div class="navbar-nav flex-row">
            @if (Route::has('login'))
            <nav class="navbar navbar-brand navbar-nav -mx-3 flex flex-1 justify-end">
                <!-- Logo -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('assets/onlineshop1.png') }}" alt="logo" style="max-height: 40px;">
                </a>
                <!-- links to info -->
                <div class="flex lg:justify-center lg:col-start-2">
                    <a href="#" class="nav-info">About Us</a>
                </div>
                <div class="flex lg:justify-center lg:col-start-2">
                    <a href="#" class="nav-info">Workshop</a>
                </div>
                <div class="flex lg:justify-center lg:col-start-2">
                    <a href="#" class="nav-info">Contact</a>
                </div>
                <!-- Search Bar -->
                <form class="search d-flex flex-grow-1">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="search-btn" type="submit">
                        <i class="text-white fas fa-search"></i>
                    </button>
                </form>
                <a href="{{ route('cart.show') }}" class="shopping-cart fa fa-shopping-cart" aria-hidden="true">
                    <span class="cart-count">{{ \Cart::count() }}</span>
                </a>

                @auth
                <a href="{{ url('/dashboard') }}" class="nav-link rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                    Dashboard
                </a>
                @else
                <a href="{{ route('login') }}" class="nav-link rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                    Log in
                </a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="nav-link rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                    Register
                </a>
                @endif
                @endauth
                <div class="bars-menu">
                    <button class="navbar-toggler" id="menuToggleBtn" aria-controls="menuDropdown" aria-expanded="false">
                        <i class="text-white fas fa-bars"></i>
                    </button>
                </div>
            </nav>
            @endif
        </div>
    </div>
</header>