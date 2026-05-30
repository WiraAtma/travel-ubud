<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-lite.css') }}">
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/summernote/summernote-lite.js') }}"></script>

        <style>
            /* Sidebar mobile drawer */
            #default-sidebar {
                transition: transform 0.3s ease;
            }

            /* Mobile: posisi fixed sebagai drawer dari kiri */
            @media (max-width: 639px) {
                #default-sidebar {
                    display: block !important;
                    position: fixed;
                    top: 0;
                    left: 0;
                    height: 100%;
                    z-index: 40;
                    transform: translateX(-100%);
                    box-shadow: 4px 0 24px rgba(0,0,0,0.13);
                }

                #default-sidebar.open {
                    transform: translateX(0);
                }
            }

            /* Overlay backdrop */
            #sidebar-backdrop {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.4);
                z-index: 39;
            }

            #sidebar-backdrop.open {
                display: block;
            }

            /* FAB button */
            #sidebar-fab {
                position: fixed;
                bottom: 24px;
                right: 24px;
                z-index: 50;
                width: 52px;
                height: 52px;
                border-radius: 50%;
                background-color: #1f2937;
                color: white;
                border: none;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 22px;
                box-shadow: 0 4px 16px rgba(0,0,0,0.25);
                transition: background-color 0.2s, transform 0.2s;
            }

            #sidebar-fab:active {
                transform: scale(0.93);
            }

            /* Sembunyikan FAB di sm ke atas */
            @media (min-width: 640px) {
                #sidebar-fab {
                    display: none;
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased">

        <div class="min-h-screen flex flex-col bg-gray-100">

            @include('layouts.navigation')

            {{-- Backdrop overlay untuk mobile --}}
            <div id="sidebar-backdrop"></div>

            <div class="flex flex-1">

                <aside id="default-sidebar" class="w-64 shrink-0 bg-white border-e border-gray-200 min-h-screen">
                    <div class="h-full px-3 py-4 overflow-y-auto">
                        <ul class="space-y-5 text-gray-600 font-medium">
                            @auth
                              @if(auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin')
                                <li>
                                    <a href="/admin" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                                        <i class="bi bi-speedometer"></i>
                                        <span class="ms-3">Dashboard</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/admin/request-company" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                                        <i class="bi bi-building-fill-check"></i>
                                        <span class="flex-1 ms-3 whitespace-nowrap">Verified Company</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/admin/list-user" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                                        <i class="bi bi-people-fill"></i>
                                        <span class="flex-1 ms-3 whitespace-nowrap">Kelola Users</span>
                                    </a>
                                </li>
                                @endif
                                @endauth
                                <li>
                                    <a href="/admin/article" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                                        <i class="bi bi-file-earmark-text-fill"></i>
                                        <span class="flex-1 ms-3 whitespace-nowrap">Kelola Artikel</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/admin/destination" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                                        <i class="bi bi-backpack2-fill"></i>
                                        <span class="flex-1 ms-3 whitespace-nowrap">Kelola Destinasi</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/admin/restaurant" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                                        <i class="bi bi-fork-knife"></i>
                                        <span class="flex-1 ms-3 whitespace-nowrap">Kelola Restoran</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/admin/hotel" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                                        <i class="bi bi-buildings-fill"></i>
                                        <span class="flex-1 ms-3 whitespace-nowrap">Kelola Hotel</span>
                                    </a>
                                </li>
                        </ul>
                    </div>
                </aside>

                <main class="flex-1 p-4">
                    {{ $slot }}
                </main>
            </div>

            @include('layouts.footer')
        </div>

        {{-- FAB Toggle Sidebar — hanya muncul di mobile --}}
        <button id="sidebar-fab" aria-label="Buka menu">
            <i class="bi bi-layout-sidebar" id="fab-icon"></i>
        </button>

        <script>
            const fab         = document.getElementById('sidebar-fab');
            const sidebar     = document.getElementById('default-sidebar');
            const backdrop    = document.getElementById('sidebar-backdrop');
            const fabIcon     = document.getElementById('fab-icon');

            function openSidebar() {
                sidebar.classList.add('open');
                backdrop.classList.add('open');
                fabIcon.className = 'bi bi-x-lg';
            }

            function closeSidebar() {
                sidebar.classList.remove('open');
                backdrop.classList.remove('open');
                fabIcon.className = 'bi bi-layout-sidebar';
            }

            fab.addEventListener('click', function () {
                sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
            });

            backdrop.addEventListener('click', closeSidebar);

            // Tutup sidebar saat klik link di dalamnya (mobile UX)
            sidebar.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', function () {
                    if (window.innerWidth < 640) closeSidebar();
                });
            });
        </script>

        <script>
        function confirmDelete(form, subtitle) {
            subtitle = subtitle || 'Data tidak bisa dikembalikan!';
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
            }).then(function(result) {
                if (result.isConfirmed) form.submit();
            });
        }

        function confirmAction(form, title, text, icon, confirmText) {
            icon        = icon        || 'question';
            confirmText = confirmText || 'Ya, Lanjutkan!';
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
            }).then(function(result) {
                if (result.isConfirmed) form.submit();
            });
        }
        </script>

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

        @stack('scripts')

    </body>
</html>
