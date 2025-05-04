<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuntasin</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <main class="min-h-screen p-8 bg-[#f8f9fa]">
        @yield('content')
    </main>
</body>
</html>
