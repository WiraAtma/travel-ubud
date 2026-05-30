<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            {{-- <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset --}}

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            @include('layouts.footer')
        </div>
        @stack('scripts')
        @if (session('swal'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const options = @json(session('swal'));

                Swal.fire({
                    icon: options.icon || 'info',
                    title: options.title || '',
                    text: options.text || '',
                    timer: options.toast ? 2500 : undefined,
                    timerProgressBar: !!options.toast,
                    showConfirmButton: !options.toast,
                    toast: !!options.toast,
                    position: options.toast ? 'top-end' : 'center',
                    confirmButtonColor: '#4f46e5',
                });
            });
        </script>
        @elseif (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('success')),
                    timer: 2500,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end',
                });
            });
        </script>
        @elseif (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: @json(session('error')),
                    confirmButtonColor: '#4f46e5',
                });
            });
        </script>
        @endif

        @push('scripts')
        <script>
        function confirmDelete(form, subtitle = 'Data tidak bisa dikembalikan!') {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: subtitle,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        }

        function confirmAction(form, title, text, icon = 'question', confirmText = 'Ya, Lanjutkan!') {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#6b7280',
                confirmButtonText: confirmText,
                cancelButtonText: 'Batal',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        }
        </script>
        @endpush
    </body>
</html>
