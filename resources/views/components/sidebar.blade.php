<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <!-- resources/views/components/sidebar.blade.php -->
<nav class="sidebar close">
    <header>
        <div class="image-text">
            {{-- <span class="image">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
            </span> --}}

            <div class="text logo-text">
                <span class="name">{{ Auth::user()->name }}</span>
                <span class="profession">{{ Auth::user()->role ?? 'Role' }}</span>
            </div>
        </div>

        <i class='bx bx-chevron-left toggle'></i>
    </header>

    <div class="menu-bar">
        <div class="menu">
            <ul class="menu-links">
                <li class="nav-link">
                    <a href="{{ route('home') }}">
                        <i class='bx bx-home-alt icon'></i>
                        <span class="text nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-link">
                    <i class='bx bx-user icon'></i>
                    <span class="text nav-text">Profile</span>
                </li>
                <li class="nav-link">
                    <a href="{{route('client')}}">
                    <i class='bx bx-group icon'></i>
                    <span class="text nav-text">Clients</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="{{route('product')}}">
                    <i class='bx bx-group icon'></i>
                    <span class="text nav-text">Products</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="{{ route('two-factor-setup') }}">
                        <i class='bx bx-cog icon'></i>
                        <span class="text nav-text">Settings</span>
                    </a>
                </li>
            </ul>
        </div>


        <div class="bottom-content">
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-button" style="background: none; border: none; padding: 0; cursor: pointer;">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Logout</span>
                    </button>
                </form>
            </li>
        </div>
        
    </div>
</nav>

<script>
    const body = document.querySelector('body'),
        sidebar = body.querySelector('nav'),
        toggle = body.querySelector(".toggle");

        // Ensure the sidebar is open by default
    window.addEventListener('DOMContentLoaded', () => {
        sidebar.classList.remove("close");
    });
    

    toggle.addEventListener("click", () => {
        sidebar.classList.toggle("close");
    });
</script>

</body>

</html>
