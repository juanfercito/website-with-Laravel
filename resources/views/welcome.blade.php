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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="row items-center gap-2 py-10 lg:grid-cols-3">
        <header class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <!-- Logo -->
                <a class="navbar-brand" href="#">
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

                <a href="/" class="shopping-cart fa fa-cart-plus" aria-hidden="true"></a>

                <!-- Elementos de tipo enlace -->
                <div class="navbar-nav flex-row">
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
                </div>

                <div class="bars-menu">
                    <button class="navbar-toggler" id="menuToggleBtn" aria-controls="menuDropdown" aria-expanded="false">
                        <i class="text-white fas fa-bars"></i>
                    </button>
                    <ul class="menu-dropdown" id="menuDropdown">
                        <li><a href="{{ route('login') }}" class="nav-link">Log in</a></li>
                        <li><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                        <li class="li-drop"><a href="" class="nav-link">About Us</a></li>
                        <li class="li-drop"><a href="" class="nav-link">Workshop</a></li>
                        <li class="li-drop"><a href="" class="nav-link">Contact</a></li>
                        <!-- Agrega más opciones según sea necesario -->
                    </ul>
                </div>



                </ul>
            </div>

    </div>
    </header>

    </div>

    <main class="main-content">

        <div class="title-beginning">
            <h2>All in a One PLace</h2>
        </div>
        <div class="background-carousel" style="background-image: url('assets/foreground-nature.jpg');">
            <div class="container">
                <div class="row justify-content-center align-items-end" style="position: absolute; bottom: 0; width: 100%;">
                    <div class="col-md-6">
                        <!-- Contenido de Últimos añadidos -->
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Últimos añadidos</h3>
                                <!-- Agrega aquí el contenido de los últimos productos -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Contenido de Lo más vendido -->
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Lo más vendido</h3>
                                <!-- Agrega aquí el contenido de los productos más vendidos -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <footer class="footer">
        <div class="container">
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


    <!-- Script JavaScript -->
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