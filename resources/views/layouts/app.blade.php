<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .nav {
    background-color: #333;
    overflow: hidden;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 10px;
    position: sticky; /* Keeps it at the top */
    top: 0;
    z-index: 1000; /* Ensures it stays above other elements */
}


        .nav a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            text-align: center;
        }

        .nav a:hover {
            background-color: #575757;
            color: white;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
</head>
<body>
    <nav class="nav">
        <div class="nav-links">
            <a href="{{ route('homepage') }}">Home</a>
            <a href="{{ route('profilepage') }}">Profile</a>
        </div>
        <div class="auth-links">
            @auth
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-danger">Sign Out</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
            @endauth
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>
</body>
</html>

