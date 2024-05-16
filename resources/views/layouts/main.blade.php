<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Online Shop')</title> <!-- Aquí se define el título de la página -->
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="icon" type="image" href="favicons/favicon.ico">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @stack('css')
</head>


<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <!-- Header -->
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
                    <a href="{{ url('/shopping-cart') }}" class="shopping-cart fa fa-cart-plus" aria-hidden="true"></a>
                    @auth
                    <a href="{{ url('/dashboard') }}" class=" nav-link rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
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

    <!-- Banner -->
    <div>
        @yield('dropdown_menu')
        <div class="menu-dropdown" id="menuDropdown">
            <ul>
                <li><a href="{{ route('login') }}" class="nav-link">Log in</a></li>
                <li><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                <li class="li-drop"><a href="" class="nav-link">About Us</a></li>
                <li class="li-drop"><a href="" class="nav-link">Workshop</a></li>
                <li class="li-drop"><a href="" class="nav-link">Contact</a></li>
                <!-- Adding more options if necessary -->
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="row">
                <div class="credits">
                    <div class="parr-1">
                        <p>juanfercito Corp.</p>
                    </div>
                    <div class="parr-2">
                        <p>By Juanfercito Content Inc.</p>
                    </div>
                    <div class="parr-3">
                        <p>Almost All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#menuToggleBtn').click(function() {
                $('#menuDropdown').toggle();
            });
            $(document).on('click', function(event) {
                if (!$(event.target).closest('#menuToggleBtn, #menuDropdown').length) {
                    $('#menuDropdown').hide();
                }
            });
        });
    </script>
</body>

</html>
@push('css')
@endpush