<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TuntasINAPP_NAME=Laravel
        APP_ENV=local
        APP_KEY=base64:etI5WqWIT1+ZHDDAzJcDa7vo015rirGXlxaFPd9l71I=
        APP_DEBUG=true
        APP_URL=http://localhost:8000
        
        APP_LOCALE=en
        APP_FALLBACK_LOCALE=en
        APP_FAKER_LOCALE=en_US
        
        APP_MAINTENANCE_DRIVER=file
        # APP_MAINTENANCE_STORE=database
        
        PHP_CLI_SERVER_WORKERS=4
        
        BCRYPT_ROUNDS=12
        
        LOG_CHANNEL=stack
        LOG_STACK=single
        LOG_DEPRECATIONS_CHANNEL=null
        LOG_LEVEL=debug
        
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=tuntasin
        DB_USERNAME=root
        DB_PASSWORD=
        
        SESSION_DRIVER=database
        SESSION_LIFETIME=120
        SESSION_ENCRYPT=false
        SESSION_PATH=/
        SESSION_DOMAIN=null
        
        BROADCAST_CONNECTION=log
        FILESYSTEM_DISK=public
        QUEUE_CONNECTION=database
        
        CACHE_STORE=database
        # CACHE_PREFIX=
        
        MEMCACHED_HOST=127.0.0.1
        
        REDIS_CLIENT=phpredis
        REDIS_HOST=127.0.0.1
        REDIS_PASSWORD=null
        REDIS_PORT=6379
        
        MAIL_MAILER=log
        MAIL_SCHEME=null
        MAIL_HOST=127.0.0.1
        MAIL_PORT=2525
        MAIL_USERNAME=null
        MAIL_PASSWORD=null
        MAIL_FROM_ADDRESS="hello@example.com"
        MAIL_FROM_NAME="${APP_NAME}"
        
        AWS_ACCESS_KEY_ID=
        AWS_SECRET_ACCESS_KEY=
        AWS_DEFAULT_REGION=us-east-1
        AWS_BUCKET=
        AWS_USE_PATH_STYLE_ENDPOINT=false
        
        VITE_APP_NAME="${APP_NAME}" - Satu Tempat, Semua Beres</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<body>
    @yield('content')
</body>
</html>