<x-app-layout>
    <header style="position: relative; overflow: hidden;">
        <img 
            class="w-full block object-cover" 
            src="{{ asset('header-image-dashboard.png') }}" 
            alt="Header Image"
            style="display: block; width: 100%; height: 500px; object-fit: cover;"
        >
        
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.4);"></div>

        <div class="header-container"> 
            <div data-reveal="fade-up" class="header-text-content">
                <h1 class="font-extrabold" style="font-size: clamp(28px, 5vw, 48px); font-weight: bold; line-height: 1.2; margin-bottom: 16px; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                    Jelajahi Keindahan Ubud
                </h1>
                <p style="font-size: clamp(14px, 3vw, 16px); line-height: 1.6; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
                    Temukan pesona alam, budaya, dan ketenangan di jantung Bali. 
                </p>
                <p style="font-size: clamp(14px, 3vw, 16px); line-height: 1.6; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
                    Ubud menghadirkan pengalaman wisata yang tak hanya indah, tetapi juga berkesan.
                </p>
            </div>
        </div>
    </header>

    <section class="wrapper">
        {{-- Gambar dari kiri, teks dari kanan --}}
        <div class="flex flex-col md:flex-row items-center py-12 gap-8">  
            <div class="w-full md:w-5/12" data-reveal="fade-right">
                <img 
                    src="https://www.baliagatour.co.id/wp-content/uploads/2025/04/Hidden-Spot-di-Ubud-yang-Jarang-Diketahui-Wisatawan.jpg" 
                    alt="Ubud Hidden Spot" 
                    class="w-full h-80 object-cover rounded-2xl shadow-lg"
                >
            </div>

            <div class="w-full md:w-7/12 md:pl-14" data-reveal="fade-left" data-delay="200">
                <h2 style="font-size: clamp(28px, 5vw, 42px); font-weight: 800; line-height: 1.2;">
                    Berikan Pengalaman Terbaik dengan Layanan Kami
                </h2>
                <p class="text-gray-500 mt-4 text-[15px] leading-relaxed">
                    Temukan pengalaman wisata terbaik di Ubud bersama kami. Dari alam tersembunyi hingga budaya lokal yang kaya, kami siap menghadirkan perjalanan yang tak terlupakan untuk Anda.
                </p>
            </div>
        </div>

        {{-- Cards layanan: staggered fade-up --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pb-12">
            <div class="p-4 rounded-2xl border border-gray-400 h-full" data-reveal="fade-up" data-delay="100">
                <div class="bg-gray-100 rounded-full inline-flex items-center justify-center w-[54px] h-[54px] mb-3">
                    <i class="bi bi-airplane text-xl"></i>
                </div>
                <h5 class="font-bold text-base">Pemesanan Penerbangan</h5>
                <p class="text-gray-500 text-sm mt-1">Pesan tiket penerbangan dengan mudah dan harga terbaik ke Bali.</p>
            </div>

            <div class="p-4 rounded-2xl border border-gray-400 h-full" data-reveal="fade-up" data-delay="200">
                <div class="bg-gray-100 rounded-full inline-flex items-center justify-center w-[54px] h-[54px] mb-3">
                    <i class="bi bi-map text-xl"></i>
                </div>
                <h5 class="font-bold text-base">Pemesanan Tur</h5>
                <p class="text-gray-500 text-sm mt-1">Jelajahi destinasi terbaik Ubud dengan paket tur pilihan kami.</p>
            </div>

            <div class="p-4 rounded-2xl border border-gray-400 h-full" data-reveal="fade-up" data-delay="300">
                <div class="bg-gray-100 rounded-full inline-flex items-center justify-center w-[54px] h-[54px] mb-3">
                    <i class="bi bi-building text-xl"></i>
                </div>
                <h5 class="font-bold text-base">Pemesanan Hotel</h5>
                <p class="text-gray-500 text-sm mt-1">Temukan akomodasi terbaik dari villa nyaman hingga resort mewah.</p>
            </div>

            <div class="p-4 rounded-2xl border border-gray-400 h-full" data-reveal="fade-up" data-delay="400">
                <div class="bg-gray-100 rounded-full inline-flex items-center justify-center w-[54px] h-[54px] mb-3">
                    <i class="bi bi-car-front text-xl"></i>
                </div>
                <h5 class="font-bold text-base">Transportasi</h5>
                <p class="text-gray-500 text-sm mt-1">Layanan antar-jemput dan sewa kendaraan untuk perjalanan nyaman.</p>
            </div>
        </div>
    </section>

    <div class="relative bg-cover bg-center py-20"
        style="background-image: url({{ asset('mid-image-dashboard.png') }});">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="wrapper relative z-10">
            <div class="flex flex-col md:flex-row items-center gap-10">

                {{-- Teks kiri --}}
                <div class="w-full md:w-5/12 text-white" data-reveal="fade-right">
                    <h2 style="font-size: clamp(32px, 5vw, 48px); font-weight: 800; line-height: 1.2;">
                        Cara Terbaik Untuk Bepergian
                    </h2>
                    <p class="mt-4 text-[15px] leading-relaxed text-white/85">
                        Temukan cara terbaik menjelajahi keindahan Ubud. Kami hadir untuk membuat setiap langkah perjalanan Anda mudah, nyaman, dan berkesan.
                    </p>
                </div>

                {{-- Step cards --}}
                <div class="w-full md:w-7/12 flex flex-col gap-4">
                    <div class="flex items-start gap-4 bg-white rounded-2xl p-4 shadow-sm" data-reveal="fade-left" data-delay="100">
                        <div class="shrink-0 flex items-center justify-center rounded-full border-2 border-gray-300 w-12 h-12 text-sm font-bold text-gray-500">
                            1
                        </div>
                        <div>
                            <h6 class="font-bold mb-1">Pilih Tiket Anda</h6>
                            <p class="text-gray-500 text-sm mb-0">Pilih tiket perjalanan sesuai tujuan dan tanggal keberangkatan Anda dengan mudah.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 bg-white rounded-2xl p-4 shadow-sm" data-reveal="fade-left" data-delay="250">
                        <div class="shrink-0 flex items-center justify-center rounded-full border-2 border-gray-300 w-12 h-12 text-sm font-bold text-gray-500">
                            2
                        </div>
                        <div>
                            <h6 class="font-bold mb-1">Pemesanan Aman dan Terpercaya</h6>
                            <p class="text-gray-500 text-sm mb-0">Lakukan pemesanan dan pembayaran dengan aman melalui sistem kami yang terpercaya.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 bg-white rounded-2xl p-4 shadow-sm" data-reveal="fade-left" data-delay="400">
                        <div class="shrink-0 flex items-center justify-center rounded-full border-2 border-gray-300 w-12 h-12 text-sm font-bold text-gray-500">
                            3
                        </div>
                        <div>
                            <h6 class="font-bold mb-1">Nikmati Perjalanan Anda</h6>
                            <p class="text-gray-500 text-sm mb-0">Nikmati setiap momen perjalanan Anda di Ubud dengan tenang dan penuh kenangan indah.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <section class="wrapper">
        {{-- Heading section trending --}}
        <div class="text-center mb-10" data-reveal="fade-up">
            <h2 style="font-size: clamp(28px, 5vw, 42px); font-weight: 800;">Pilihan Destinasi Yang Sedang Trending</h2>
            <p class="text-gray-500 mx-auto mt-3 max-w-[480px] text-[15px] leading-relaxed">
                Temukan destinasi wisata paling populer pilihan para pelancong dari seluruh dunia yang wajib kamu kunjungi.
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ($topDestinations as $top)
                <div class="rounded-2xl overflow-hidden shadow-sm border border-gray-100" 
                    data-reveal="zoom-in" 
                    data-delay="{{ $loop->index * 100 + 100 }}">
                    <a class="no-underline text-gray-900 block" 
                    href="{{ route('destinations.detail', $top->id) }}">
                        <img 
                            class="w-full object-cover" 
                            style="height: 160px;"
                            src="{{ $top->image_cover ? asset('storage/' . $top->image_cover) : 'https://placehold.co/600x400?text=No+Image' }}"
                            alt="{{ $top->title }}"
                        >
                        <div class="p-3">
                            <h6 class="font-bold mb-1 text-sm">{{ $top->title }}</h6>
                            <p class="text-gray-500 mb-0 text-xs">
                                <i class="bi bi-geo-alt me-1"></i>{{ $top->location }}
                            </p>
                            <p class="text-yellow-500 text-xs mt-1 mb-0">
                                ★ {{ number_format($top->rating, 1) }}
                                <span class="text-gray-400">({{ $top->rating_count }})</span>
                            </p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <section class="wrapper">
        <div class="py-3">
            {{-- Heading --}}
            <h2 style="font-size: clamp(28px, 5vw, 48px); margin-bottom: 2rem;" data-reveal="fade-up">
                Amazing views of <span class="font-bold underline">Ubud</span>
            </h2>

            <div class="flex flex-col md:flex-row items-center gap-6">

                {{-- Grid foto: responsif --}}
                <div class="w-full md:w-7/12" data-reveal="fade-right">
                    <div class="grid grid-cols-3 gap-2 md:gap-3">
                        <img src="https://goldenmonkeybali.com/wp-content/uploads/2022/01/ubud.webp" alt="ubud-1"
                            class="rounded-xl object-cover bg-gray-200 w-full" style="height: clamp(90px, 20vw, 180px);">
                        <img src="https://jungleclububud.com/wp-content/uploads/2025/10/ubud-envato.jpg" alt="ubud-2"
                            class="rounded-xl object-cover bg-gray-200 w-full" style="height: clamp(90px, 20vw, 180px);">
                        <img src="https://akcdn.detik.net.id/visual/2025/05/14/foto-dok-ubudquadbikingcom-1747221720490_169.jpeg?w=700&q=90" alt="ubud-3"
                            class="rounded-xl object-cover bg-gray-200 w-full" style="height: clamp(90px, 20vw, 180px);">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/d/d8/Ubud_Palace_%282022%29.jpg" alt="ubud-4"
                            class="rounded-xl object-cover bg-gray-200 w-full" style="height: clamp(90px, 20vw, 180px);">
                        <img src="https://i0.wp.com/visitbalitour.com/wp-content/uploads/2016/09/ubud-art-market.jpg?fit=778%2C519&ssl=1" alt="ubud-5"
                            class="rounded-xl object-cover bg-gray-200 w-full" style="height: clamp(90px, 20vw, 180px);">
                        <img src="https://jungleclububud.com/wp-content/uploads/2025/09/ubud-art-market_sunshineseekercom-1024x683.jpg" alt="ubud-6"
                            class="rounded-xl object-cover bg-gray-200 w-full" style="height: clamp(90px, 20vw, 180px);">
                    </div>
                </div>

                {{-- Teks --}}
                <div class="w-full md:w-5/12 md:pl-4" data-reveal="fade-left" data-delay="200">
                    <p class="text-[16px] leading-loose mb-5">
                        Terletak di dataran tinggi tengah Bali yang rimbun, Ubud dikelilingi oleh keindahan alam yang menakjubkan.
                    </p>
                    <p class="text-[16px] leading-loose mb-8">
                        Kota ini terkenal dengan sawah teraseringnya yang indah, hutan yang rimbun, dan sungai yang tenang. Sawah Terasering Tegallalang, dengan sawah bertingkat berwarna hijau zamrud, menawarkan pemandangan panorama yang menakjubkan dan wawasan tentang pertanian padi tradisional.
                    </p>
                    <a href="/tugas-uts-pweb/pages/galeri.php"
                        class="inline-block border border-gray-900 text-gray-900 px-8 py-3 rounded-lg hover:bg-gray-900 hover:text-white transition-colors duration-200">
                        Lihat Galeri Lainnya
                    </a>
                </div>

            </div>
        </div>
    </section>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
</x-app-layout>