<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- CSS saja --}}
        @vite(['resources/css/app.css'])
        <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-lite.css') }}">

        {{-- jQuery SYNC di head — wajib sebelum Summernote --}}
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        {{-- Summernote setelah jQuery --}}
        <script src="{{ asset('vendor/summernote/summernote-lite.js') }}"></script>
    </head>
    <body class="font-sans antialiased">

        <div class="min-h-screen flex flex-col bg-gray-100">

            @include('layouts.navigation')

            <div class="flex flex-1">

                <aside id="default-sidebar" class="w-64 shrink-0 bg-neutral-primary-soft bg-white border-e-gray-500 border-default hidden sm:block min-h-screen">
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
                                        {{-- <span class="inline-flex items-center justify-center w-4.5 h-4.5 ms-2 text-xs font-medium text-fg-danger-strong bg-danger-soft border border-danger-subtle rounded-full">2</span> --}}
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
                                    <a href="/admin/list-user" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
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

                <!-- Content (kanan) -->
                <main class="flex-1 p-4">
                    {{ $slot }}
                </main>

            </div>

            <!-- Footer (full width di bawah) -->
            @include('layouts.footer')

        </div>
        @vite(['resources/js/app.js'])
        @stack('scripts')
    </body>
</html>