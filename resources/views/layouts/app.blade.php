<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'TuntasIN') }}</title>
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @stack('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui/material-ui.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .colored-toast.swal2-icon-success {
            background-color: #2563eb !important;
        }
        .colored-toast .swal2-title,
        .colored-toast .swal2-html-container {
            color: white;
        }
        .swal2-popup {
            border-radius: 1rem;
            padding: 2rem;
        }
        .swal2-title {
            color: #1e293b;
            font-size: 1.5rem;
        }
        .swal2-html-container {
            color: #64748b;
        }
        .swal2-confirm {
            padding: 0.75rem 1.5rem !important;
            font-weight: 600 !important;
            border-radius: 0.75rem !important;
        }
        .swal2-cancel {
            padding: 0.75rem 1.5rem !important;
            font-weight: 600 !important;
            border-radius: 0.75rem !important;
        }
        .swal2-icon {
            border-width: 3px !important;
        }
        .swal2-timer-progress-bar {
            background: #2563eb;
        }
    </style>
</head>
@stack('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<body>
    @yield('content')
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('message') }}",
            showConfirmButton: true,
            confirmButtonColor: '#2563eb',
            timer: 3000,
            timerProgressBar: true,
            customClass: {
                popup: 'colored-toast'
            }
        }).then((result) => {
            // Optional: tambahkan logika setelah notifikasi ditutup
        });
    </script>
    @endif
</body>
</html>