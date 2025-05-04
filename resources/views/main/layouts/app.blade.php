<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuntasin</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <main class="min-h-screen p-8 bg-[#f5f9ff]">
        @yield('content')
    </main>
</body>
</html>
