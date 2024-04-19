<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Online Shop</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="icon" type="image" href="favicons/favicon.ico">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/fontawsome-font_awsome5.15.4.css') }}" integrity="sha384-4btnbNA1LDi0I/ALO38oumWvDNakjBRUAIaTOUTae/KOAv2o2Gwc8Vw1F8HDN6bE" crossorigin="anonymous">

</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D99] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="row items-center gap-2 py-10 lg:grid-cols-3">
                    <div class="flex lg:justify-center lg:col-start-2">
                        <button class="bars-menu fas fa-bars"></button>
                    </div>
                    <div class="flex lg:justify-center lg:col-start-2">
                        <img class="launch-logo" src="{{ asset('assets/onlineshop1.png') }}" alt="logo">
                    </div>

                    <div class="flex lg:justify-center lg:col-start-2">
                        <a href="#" class="nav-info">About Us</a>
                    </div>
                    <div class="flex lg:justify-center lg:col-start-2">
                        <a href="#" class="nav-info">Contact</a>
                    </div>

                    <div class="search-bar">
                        <input type="text" placeholder="Search..." class="search-input">
                        <button class="search-button">
                            <i class="text-white fas fa-search"></i> <!-- Icono de búsqueda -->
                        </button>
                    </div>

                    <div class="flex lg:justify-center lg:col-start-2">
                        <a href="/" class="shopping-cart fa fa-cart-plus" aria-hidden="true"></a>
                    </div>


                    @if (Route::has('login'))
                    <nav class="navbar navbar-brand navbar-nav -mx-3 flex flex-1 justify-end">
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
                    </nav>
                    @endif
                </header>
                <main>
                    <div>
                        <section>
                            <div class="title-beginning">
                                <div>
                                    <div>
                                        <h2>All in a one Place</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="image-beginning">
                                <div class="background">

                                    <div class="image-container">
                                        <img src="{{ asset('assets/trabajodesdecasa.jpg') }}" alt="landing_image">
                                    </div>

                                </div>
                            </div>
                        </section>
                    </div>
                </main>

                <footer>
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
                </footer>
            </div>
        </div>
    </div>
</body>

</html>