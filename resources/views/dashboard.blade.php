<x-app-layout>
    <header style="position: relative; overflow: hidden;">
        <img 
            class="w-full block object-cover h-125" 
            src="{{ asset('header-image-dashboard.png') }}" 
            alt="Header Image"
            style="display: block; width: 100%; height: 500px; object-fit: cover;"
        >
        
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.4);"></div>
        
        <div style="position: absolute; top: 50%; left: 0; transform: translateY(-50%); color: white; padding-left: 60px; max-width: 50%; z-index: 10;">
            <h1 class="font-extrabold" style="font-size: 48px; font-weight: bold; line-height: 1.2; margin-bottom: 20px; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                Jelajahi Keindahan Ubud
            </h1>
            <p style="font-size: 16px; line-height: 1.6; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
                Temukan pesona alam, budaya, dan ketenangan di jantung Bali. 
                Ubud menghadirkan pengalaman wisata yang tak hanya indah, tetapi juga berkesan.
            </p>
        </div>
    </header>
    <section class="wrapper">
        <div class="flex flex-col md:flex-row items-center py-12 gap-8 md:gap-0">  
            <div class="w-full md:w-5/12">
                <img 
                src="https://www.baliagatour.co.id/wp-content/uploads/2025/04/Hidden-Spot-di-Ubud-yang-Jarang-Diketahui-Wisatawan.jpg" 
                alt="Ubud Hidden Spot" 
                class="w-full h-80 object-cover rounded-2xl shadow-lg"
                >
            </div>

            <div class="w-full md:w-7/12 md:pl-14">
                <h2 class="text-[42px] font-extrabold leading-tight">
                Berikan Pengalaman Terbaik<br> dengan Layanan Kami
                </h2>
                <p class="text-gray-500 mt-4 text-[15px] leading-relaxed">
                Temukan pengalaman wisata terbaik di Ubud bersama kami. Dari alam tersembunyi hingga budaya lokal yang kaya, kami siap menghadirkan perjalanan yang tak terlupakan untuk Anda.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 pb-12">
            <div class="p-4 rounded-2xl border border-gray-400 h-full">
                <div class="bg-gray-100 rounded-full inline-flex items-center justify-center w-[54px] h-[54px] mb-3">
                <i class="bi bi-airplane text-xl"></i>
                </div>
                <h5 class="font-bold text-base">Pemesanan Penerbangan</h5>
                <p class="text-gray-500 text-sm mt-1">Pesan tiket penerbangan dengan mudah dan harga terbaik ke Bali.</p>
            </div>

            <div class="p-4 rounded-2xl border border-gray-400 h-full">
                <div class="bg-gray-100 rounded-full inline-flex items-center justify-center w-[54px] h-[54px] mb-3">
                <i class="bi bi-map text-xl"></i>
                </div>
                <h5 class="font-bold text-base">Pemesanan Tur</h5>
                <p class="text-gray-500 text-sm mt-1">Jelajahi destinasi terbaik Ubud dengan paket tur pilihan kami.</p>
            </div>

            <div class="p-4 rounded-2xl border border-gray-400 h-full">
                <div class="bg-gray-100 rounded-full inline-flex items-center justify-center w-[54px] h-[54px] mb-3">
                <i class="bi bi-building text-xl"></i>
                </div>
                <h5 class="font-bold text-base">Pemesanan Hotel</h5>
                <p class="text-gray-500 text-sm mt-1">Temukan akomodasi terbaik dari villa nyaman hingga resort mewah.</p>
            </div>

            <div class="p-4 rounded-2xl border border-gray-400 h-full">
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
            <div class="w-full md:w-5/12 text-white">
                <h2 class="text-5xl font-extrabold leading-tight">Cara Terbaik<br> Untuk Bepergian</h2>
                <p class="mt-4 text-[15px] leading-relaxed text-white/85">
                Temukan cara terbaik menjelajahi keindahan Ubud. Kami hadir untuk membuat setiap langkah perjalanan Anda mudah, nyaman, dan berkesan.
                </p>
            </div>
            <div class="w-full md:w-7/12 flex flex-col gap-4">
                <div class="flex items-start gap-4 bg-white rounded-2xl p-4 shadow-sm">
                <div class="shrink-0 flex items-center justify-center rounded-full border-2 border-gray-300 w-12 h-12 text-sm font-bold text-gray-500">
                    1
                </div>
                <div>
                    <h6 class="font-bold mb-1">Pilih Tiket Anda</h6>
                    <p class="text-gray-500 text-sm mb-0">Pilih tiket perjalanan sesuai tujuan dan tanggal keberangkatan Anda dengan mudah.</p>
                </div>
                </div>
                <div class="flex items-start gap-4 bg-white rounded-2xl p-4 shadow-sm">
                <div class="shrink-0 flex items-center justify-center rounded-full border-2 border-gray-300 w-12 h-12 text-sm font-bold text-gray-500">
                    2
                </div>
                <div>
                    <h6 class="font-bold mb-1">Pemesanan Aman dan Terpercaya</h6>
                    <p class="text-gray-500 text-sm mb-0">Lakukan pemesanan dan pembayaran dengan aman melalui sistem kami yang terpercaya.</p>
                </div>
                </div>
                <div class="flex items-start gap-4 bg-white rounded-2xl p-4 shadow-sm">
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
        <!-- Header -->
        <div class="text-center mb-10">
        <h2 class="text-[42px] font-extrabold">Pilihan Destinasi Yang Sedang Trending</h2>
        <p class="text-gray-500 mx-auto mt-3 max-w-[480px] text-[15px] leading-relaxed">
            Temukan destinasi wisata paling populer pilihan para pelancong dari seluruh dunia yang wajib kamu kunjungi.
        </p>
        </div>

        <!-- Cards -->
        <div class="flex justify-between gap-3">

        <!-- Monkey Forest -->
        <div class="rounded-2xl overflow-hidden shadow-sm border-0 shrink-0 w-72">
            <a class="no-underline text-gray-900 block" href="../tugas-uts-pweb/pages/information-monkey-forest.php">
            <img 
                class="w-full h-[200px] object-cover" 
                src="https://ubudtourism.com/wp-content/uploads/elementor/thumbs/Sacred-monkey-forest-sanctuary-ubud-bali-15-qpr03cilrefvjb4s945fxfkwzykhvheh78tzbein0g.jpg" 
                alt="monkey-forest-ubud"
            >
            <div class="p-4 flex justify-between items-start">
                <div>
                <h6 class="font-bold mb-1">Monkey Forest</h6>
                <p class="text-gray-500 mb-0 text-[13px]">
                    <i class="bi bi-geo-alt me-1"></i>Ubud, Bali
                </p>
                </div>
            </div>
            </a>
        </div>

        <!-- Art Market -->
        <div class="rounded-2xl overflow-hidden shadow-sm border-0 shrink-0 w-72">
            <a class="no-underline text-gray-900 block" href="../tugas-uts-pweb/pages/information-art-market.php">
            <img 
                class="w-full h-[200px] object-cover" 
                src="https://ubudtourism.com/wp-content/uploads/elementor/thumbs/Ubud-bali-art-market-qprxt4hwyq0do21xn9z96n1vz20kgz0hqvuvtgu680.jpg" 
                alt="art-market"
            >
            <div class="p-4 flex justify-between items-start">
                <div>
                <h6 class="font-bold mb-1">Art Market Ubud</h6>
                <p class="text-gray-500 mb-0 text-[13px]">
                    <i class="bi bi-geo-alt me-1"></i>Ubud, Bali
                </p>
                </div>
            </div>
            </a>
        </div>

        <!-- Ubud Palace -->
        <div class="rounded-2xl overflow-hidden shadow-sm border-0 shrink-0 w-72">
            <a class="no-underline text-gray-900 block" href="../tugas-uts-pweb/pages/information-ubud-palace.php">
            <img 
                class="w-full h-[200px] object-cover" 
                src="https://ubudtourism.com/wp-content/uploads/elementor/thumbs/water-palace-ubud-bali-qpry8y440bo53r2j94765nb7yk101jttx774n5dlhc.jpg" 
                alt="ubud-palace"
            >
            <div class="p-4 flex justify-between items-start">
                <div>
                <h6 class="font-bold mb-1">Ubud Palace</h6>
                <p class="text-gray-500 mb-0 text-[13px]">
                    <i class="bi bi-geo-alt me-1"></i>Ubud, Bali
                </p>
                </div>
            </div>
            </a>
        </div>

        <!-- Tirta Empul -->
        <div class="rounded-2xl overflow-hidden shadow-sm border-0 shrink-0 w-72">
            <a class="no-underline text-gray-900 block" href="../tugas-uts-pweb/pages/information-tirta-empul-temple.php">
            <img 
                class="w-full h-[200px] object-cover" 
                src="https://ubudtourism.com/wp-content/uploads/elementor/thumbs/Tirta-Empul-Temple-ubud-bali-guide-qps18vwwtffibqa6yruvheqrpg0dyac6rg4el1c2yo.jpg" 
                alt="tirta-empul"
            >
            <div class="p-4 flex justify-between items-start">
                <div>
                <h6 class="font-bold mb-1">Tirta Empul Temple</h6>
                <p class="text-gray-500 mb-0 text-[13px]">
                    <i class="bi bi-geo-alt me-1"></i>Ubud, Bali
                </p>
                </div>
            </div>
            </a>
        </div>
        </div>
    </section>
    <section class="wrapper">
        <div class="py-12">
        <h2 class="text-[48px] mb-10">
            Amazing views of <span class="font-bold underline">Ubud</span>
        </h2>

        <div class="flex flex-col md:flex-row items-center gap-6">

            <!-- Grid Foto -->
            <div class="w-full md:w-7/12">
            <div class="grid grid-cols-3 gap-3">
                <img src="https://goldenmonkeybali.com/wp-content/uploads/2022/01/ubud.webp" alt="ubud-1"
                class="rounded-xl h-[180px] w-full object-cover bg-gray-200">
                <img src="https://jungleclububud.com/wp-content/uploads/2025/10/ubud-envato.jpg" alt="ubud-2"
                class="rounded-xl h-[180px] w-full object-cover bg-gray-200">
                <img src="https://akcdn.detik.net.id/visual/2025/05/14/foto-dok-ubudquadbikingcom-1747221720490_169.jpeg?w=700&q=90" alt="ubud-3"
                class="rounded-xl h-[180px] w-full object-cover bg-gray-200">
                <img src="https://upload.wikimedia.org/wikipedia/commons/d/d8/Ubud_Palace_%282022%29.jpg" alt="ubud-4"
                class="rounded-xl h-[180px] w-full object-cover bg-gray-200">
                <img src="https://i0.wp.com/visitbalitour.com/wp-content/uploads/2016/09/ubud-art-market.jpg?fit=778%2C519&ssl=1" alt="ubud-5"
                class="rounded-xl h-[180px] w-full object-cover bg-gray-200">
                <img src="https://jungleclububud.com/wp-content/uploads/2025/09/ubud-art-market_sunshineseekercom-1024x683.jpg" alt="ubud-6"
                class="rounded-xl h-[180px] w-full object-cover bg-gray-200">
            </div>
            </div>

            <!-- Text -->
            <div class="w-full md:w-5/12 md:pl-4">
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
