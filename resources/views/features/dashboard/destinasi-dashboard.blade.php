<x-app-layout>

    {{-- ── HERO HEADER ── --}}
    <header style="position: relative; overflow: hidden;">
        <img
            class="w-full block object-cover"
            src="https://cdn.masterdiskon.com/masterdiskon/blog/post/ubud.jpg"
            alt="Header Image"
            style="display: block; width: 100%; height: clamp(260px, 50vw, 500px); object-fit: cover;"
        >
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.45);"></div>
        <div class="header-container">
            <div data-reveal="fade-up" class="header-text-content">
                <h1 class="font-extrabold" style="font-size: clamp(22px, 5vw, 48px); line-height: 1.2; margin-bottom: 12px; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                    Jelajahi Destinasi Terbaik di Ubud
                </h1>
                <p style="font-size: clamp(13px, 3vw, 16px); line-height: 1.6; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
                    Nikmati keindahan alam, budaya khas Bali, dan berbagai tempat wisata populer
                    yang siap memberikan pengalaman liburan tak terlupakan di Ubud.
                </p>
            </div>
        </div>
    </header>

    <section class="wrapper">

        {{-- ── TOP DESTINATIONS ── --}}
        <section class="max-w-7xl mx-auto px-4 sm:px-6 py-10 sm:py-16">
            <div class="mb-8 sm:mb-12" data-reveal="fade-up">
                <p class="text-gray-500 mb-1 text-sm">Top Pilihan</p>
                <h2 class="text-3xl sm:text-5xl font-semibold text-gray-900 leading-tight mb-2 sm:mb-4">
                    5 Wisata Terbaik di Ubud
                </h2>
                <p class="text-gray-500 text-sm sm:text-base max-w-xl">
                    Destinasi pilihan dengan rating tertinggi dari seluruh wisatawan.
                </p>
            </div>

            {{-- Mobile: semua 5 tampil 1 row scroll | Desktop: grid --}}
            <div class="top-dest-scroll sm:grid sm:grid-cols-3 lg:grid-cols-5 sm:gap-6">
                @foreach ($topDestinations as $top)
                    <a href="{{ route('destinations.detail', $top->id) }}"
                       class="top-dest-item no-underline text-gray-900
                              bg-white rounded-2xl overflow-hidden hover:shadow-xl
                              active:scale-[0.98] transition duration-300"
                       data-reveal="zoom-in"
                       data-delay="{{ ($loop->index % 5) * 100 + 100 }}">
                        <div class="top-dest-img-wrap">
                            <img
                                src="{{ $top->image_cover ? Storage::disk('supabase')->url( $top->image_cover) : 'https://placehold.co/600x400?text=No+Image' }}"
                                alt="{{ $top->title }}"
                                class="w-full h-full object-cover"
                            >
                        </div>
                        <div class="p-2.5 sm:p-3">
                            <h6 class="font-bold mb-1 text-xs leading-snug line-clamp-2">{{ $top->title }}</h6>
                            <p class="text-gray-500 mb-1 text-xs flex items-start gap-0.5">
                                <svg class="w-3 h-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0L6.343 16.657a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="truncate">{{ $top->location }}</span>
                            </p>
                            <p class="text-yellow-500 text-xs mb-0">
                                ★ {{ number_format($top->rating, 1) }}
                                <span class="text-gray-400">({{ $top->rating_count }})</span>
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        {{-- ── ALL DESTINATIONS ── --}}
        <section id="list-destinasi" class="max-w-7xl mx-auto px-4 sm:px-6 pb-16 sm:pb-20">
            <div class="mb-7 sm:mb-10" data-reveal="fade-up">
                <p class="text-gray-500 mb-1 text-sm">Semua Destinasi</p>
                <h2 class="text-3xl sm:text-5xl font-semibold text-gray-900 mb-5 sm:mb-6">
                    Jelajahi Semua Tempat di Ubud
                </h2>

                <form method="GET" action="{{ route('destinasi') }}#list-destinasi" class="flex gap-2 sm:gap-3 max-w-lg">
                    <div class="relative w-full">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="bi bi-search text-sm"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari destinasi..."
                            class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" />
                    </div>
                    <button type="submit"
                            class="bg-black text-white px-4 sm:px-6 py-2.5 rounded-xl text-sm font-medium hover:opacity-80 active:scale-95 transition flex-shrink-0">
                        Cari
                    </button>
                </form>
            </div>

            {{-- Destination Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-6">
                @forelse ($destinations as $destination)
                    <a href="{{ route('destinations.detail', $destination->id) }}"
                       class="text-inherit no-underline active:scale-[0.99] transition"
                       style="text-decoration: none; color: inherit;"
                       data-reveal="fade-up"
                       data-delay="{{ ($loop->index % 2) * 100 + 100 }}">

                        <div class="bg-white rounded-xl sm:rounded-2xl overflow-hidden shadow-sm hover:shadow-md
                                    transition duration-300 flex flex-row dest-card">

                            <div class="dest-thumb flex-shrink-0">
                                <img
                                    src="{{ $destination->image_cover ? Storage::disk('supabase')->url( $destination->image_cover) : 'https://placehold.co/220x160?text=No+Image' }}"
                                    alt="{{ $destination->title }}"
                                    class="w-full h-full object-cover"
                                >
                            </div>

                            <div class="flex flex-col justify-center px-3 sm:px-5 py-4 overflow-hidden flex-1 min-w-0">
                                <h5 class="font-bold text-gray-900 mb-1 text-sm sm:text-base truncate">
                                    {{ $destination->title }}
                                </h5>
                                <p class="text-gray-400 text-xs mb-1.5 flex items-start gap-0.5">
                                    <svg class="w-3 h-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0L6.343 16.657a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="truncate">{{ $destination->location }}</span>
                                </p>
                                <p class="text-gray-500 text-xs sm:text-sm leading-relaxed line-clamp-2">
                                    {{ Str::limit(strip_tags($destination->content), 80) }}
                                </p>
                                <p class="text-yellow-500 text-xs mt-2">
                                    ★ {{ number_format($destination->rating, 1) }}
                                    <span class="text-gray-400">({{ $destination->rating_count }} ulasan)</span>
                                </p>
                            </div>
                        </div>

                    </a>
                @empty
                    <div class="col-span-full text-center py-16 sm:py-20 text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-base font-medium text-gray-400">Tidak ada destinasi ditemukan.</p>
                        @if(request('search'))
                            <p class="text-sm text-gray-300 mt-1">Coba kata kunci lain.</p>
                        @endif
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($destinations->hasPages())
                <div class="mt-8 sm:mt-10 flex justify-center">
                    {{ $destinations->links() }}
                </div>
            @endif

            @auth
                @if(auth()->user()->role == 'company' && auth()->user()->company_role == 'destination')
                <a href="{{ url('/admin/destination/create') }}"
                   class="fixed bottom-6 right-6 z-50 flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300 no-underline hover:text-white">
                    <i class="bi bi-plus-lg text-xl"></i>
                    <span class="font-semibold">Buat Destinasi</span>
                </a>
                @endif
            @endauth

        </section>

    </section>

    <style>
        .top-dest-scroll {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            padding-bottom: 8px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        .top-dest-scroll::-webkit-scrollbar { display: none; }

        .top-dest-item {
            flex: 0 0 calc((100% - 48px) / 5);
            min-width: 130px;
        }

        .top-dest-img-wrap {
            height: 150px;
            overflow: hidden;
        }

        @media (min-width: 640px) {
            .top-dest-scroll {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 24px;
                overflow: visible;
                padding-bottom: 0;
            }
            .top-dest-item {
                flex: none;
                min-width: 0;
            }
            .top-dest-img-wrap {
                height: 220px;
            }
        }
        @media (min-width: 1024px) {
            .top-dest-scroll {
                grid-template-columns: repeat(5, 1fr);
            }
            .top-dest-img-wrap {
                height: 260px;
            }
        }

        .dest-card {
            min-height: 110px;
        }
        .dest-thumb {
            width: 110px;
            min-height: 110px;
        }

        @media (min-width: 640px) {
            .dest-card  { min-height: 140px; }
            .dest-thumb { width: 180px; min-height: 140px; }
        }
        @media (min-width: 768px) {
            .dest-card  { min-height: 160px; }
            .dest-thumb { width: 220px; min-height: 160px; }
        }
    </style>

</x-app-layout>