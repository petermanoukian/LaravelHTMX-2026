<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.admin.head')
</head>
<body class="d-flex flex-column min-vh-100">

    @include('includes.admin.header')

    <main class="container flex-grow-1">
        @yield('content')
    </main>

    <footer class="bg-light text-center py-3 mt-auto">
        <p class="mb-0">&copy; {{ date('Y') }} Admin Panel</p>
    </footer>

    @include('includes.admin.scripts')
</body>
</html>
