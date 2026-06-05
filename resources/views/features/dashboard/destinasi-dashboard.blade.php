<x-app-layout>
    <header style="position: relative; overflow: hidden;">
        <img
            class="w-full block object-cover"
            src="https://cdn.masterdiskon.com/masterdiskon/blog/post/ubud.jpg"
            alt="Header Image"
            style="display: block; width: 100%; height: 500px; object-fit: cover;"
        >
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.4);"></div>
        <div class="header-container">
            <div data-reveal="fade-up" class="header-text-content">
                <h1 class="font-extrabold" style="font-size: clamp(28px, 5vw, 48px); line-height: 1.2; margin-bottom: 16px; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                    Jelajahi Destinasi Terbaik di Ubud
                </h1>
                <p style="font-size: clamp(14px, 3vw, 16px); line-height: 1.6; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
                    Nikmati keindahan alam, budaya khas Bali, dan berbagai tempat wisata populer
                    yang siap memberikan pengalaman liburan tak terlupakan di Ubud.
                </p>
            </div>
        </div>
    </header>

    <section class="wrapper">
        <section class="max-w-7xl mx-auto px-6 py-16">
            <div class="mb-12">
                <p class="text-gray-500 mb-2">Top Pilihan</p>
                <h1 class="text-5xl font-semibold text-gray-900 leading-tight mb-4">
                    5 Wisata Terbaik di Ubud
                </h1>
                <p class="text-gray-500 max-w-xl">
                    Destinasi pilihan dengan rating tertinggi dari seluruh wisatawan.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach ($topDestinations as $top)
                {{-- <a href="{{ route('destinations.show', $top->id) }}" class="no-underline text-gray-900 block bg-white rounded-[28px] overflow-hidden hover:shadow-xl transition duration-300"> --}}
                <a href="" class="no-underline text-gray-900 block bg-white rounded-[28px] overflow-hidden hover:shadow-xl transition duration-300">
                    <img
                        src="{{ $top->image_cover ? asset('storage/' . $top->image_cover) : 'https://placehold.co/600x400?text=No+Image' }}"
                        alt="{{ $top->title }}"
                        class="w-full object-cover"
                        style="height: 260px;"
                    >
                    <div class="p-3">
                        <h6 class="font-bold mb-1 text-sm">{{ $top->title }}</h6>
                        <p class="text-gray-500 mb-1 text-xs">
                            <svg class="inline w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0L6.343 16.657a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $top->location }}
                        </p>
                        <p class="text-yellow-500 text-xs mb-0">
                            ★ {{ number_format($top->rating, 1) }}
                            <span class="text-gray-400">({{ $top->rating_count }} ulasan)</span>
                        </p>
                    </div>
                </a>
                @endforeach
            </div>
        </section>

        <section id="list-destinasi" class="max-w-7xl mx-auto px-6 pb-20">
            <div class="mb-10">
                <p class="text-gray-500 mb-2">Semua Destinasi</p>
                <h1 class="text-5xl font-semibold text-gray-900 mb-6">
                    Jelajahi Semua Tempat di Ubud
                </h1>

                <form method="GET" action="{{ route('destinasi') }}#list-destinasi" class="flex gap-3 max-w-lg">
                    <div class="relative w-full">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari destinasi..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" />
                    </div>
                    <button type="submit" class="bg-black text-white px-6 py-2 rounded-xl text-sm hover:opacity-80 transition">
                        Cari
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse ($destinations as $destination)
                <a href="" class="text-inherit no-underline" style="text-decoration: none; color: inherit;">
                {{-- <a href="{{ route('destinations.show', $destination->id) }}" class="text-inherit no-underline" style="text-decoration: none; color: inherit;"> --}}
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition duration-300 flex flex-row" style="height: 160px;">
                        <img
                            src="{{ $destination->image_cover ? asset('storage/' . $destination->image_cover) : 'https://placehold.co/220x160?text=No+Image' }}"
                            alt="{{ $destination->title }}"
                            style="width: 220px; object-fit: cover; flex-shrink: 0;"
                        >
                        <div class="flex flex-col justify-center px-5 py-4 overflow-hidden">
                            <h5 class="font-bold text-gray-900 mb-1 text-base truncate">
                                {{ $destination->title }}
                            </h5>
                            <p class="text-gray-400 text-xs mb-2">
                                <svg class="inline w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0L6.343 16.657a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $destination->location }}
                            </p>
                            <p class="text-gray-500 text-sm leading-relaxed line-clamp-2">
                                {{ strip_tags($destination->content) }}
                            </p>
                            <p class="text-yellow-500 text-xs mt-2">
                                ★ {{ number_format($destination->rating, 1) }}
                                <span class="text-gray-400">({{ $destination->rating_count }} ulasan)</span>
                            </p>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-2 text-center py-20 text-gray-400">
                    <p class="text-lg">Tidak ada destinasi ditemukan.</p>
                </div>
                @endforelse
            </div>

            @if ($destinations->hasPages())
            <div class="mt-10 flex justify-center">
                {{ $destinations->links() }}
            </div>
            @endif

        </section>

    </section>

</x-app-layout>