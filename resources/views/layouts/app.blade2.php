<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Student') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheets" />
    <link rel="stylesheets" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheets" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    @yield('styles')
</head>
<body class="font-sans antialiased">
    <nav>
        <ul>
            <li><a href="{{ url('student_auth')}}">Login</a></li>
            <li><a>About</a></li>
            <li><a>Services</a></li>
            <li><a>Contact Us</a></li>
        </ul>
    </nav>

    <div class="container">
        <aside class="sidebar">
            <h2>Sidebar</h2>
            <ul>
                {{-- <li><a href="{{ url('student')}}">Student</a></li>
                <li><a href="{{ url('subject')}}">Subject</a></li>
                <li><a href="{{ url('regist')}}">Registration</a></li>
                <li><a href="{{ url('regist/subject_regist')}}">Subject Registration Report</a></li> --}}
                <li><a href="">Faculty</a></li>
                <li><a href="">Program</a></li>
                <li><a href="">Student</a></li>
                <li><a href="">Subject</a></li>
                <li><a href="">Registration</a></li>
                <li><a href="">Subject Registration Report</a></li>

            </ul>
        </aside>

        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <footer>
        <p>&copy; 2025 My Website. All rights reserved.</p>
    </footer>


</body>
@yield('scripts')
</html>
