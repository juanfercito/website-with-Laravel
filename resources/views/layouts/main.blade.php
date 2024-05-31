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
    @include('partials.navbar')

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
    <main class="py-4">
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
<style>
    .back {
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        margin-top: 60px;
        margin-left: 10px;
        width: 60px;
        height: 30px;
        font-size: 2rem;
        border-radius: 10px;
        background-color: #4299E1;
        color: white;
        border: 1px solid transparent;
        z-index: 1;
    }

    .back:hover {
        background: linear-gradient(to right, #4299E1, #1b2029, #4299E1);
        cursor: pointer;
    }
</style>
@endpush