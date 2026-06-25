<x-app-layout>

{{-- HERO --}}
<section class="relative overflow-hidden" style="height: 460px;">
    <img src="https://static.mybalitrips.com/media/44391/332.jpg"
         alt="Ubud" class="w-full h-full object-cover block">
    <div class="absolute inset-0 bg-black/40"></div>
    <div class="header-container header-text-content">
        <p class="text-xs tracking-[0.2em] uppercase font-semibold text-gray-300 mb-3" data-reveal="fade-up">Tentang Kami</p>
        <h1 class="font-black text-white leading-tight mb-4" style="font-size: clamp(32px, 5vw, 56px);" data-reveal="fade-up" data-delay="100">
            Mengenal Ubud<br>Lebih Dalam
        </h1>
        <p class="text-white/85 max-w-lg leading-relaxed" style="font-size: clamp(14px, 2vw, 16px);" data-reveal="fade-up" data-delay="200">
            Panduan digital terlengkap untuk wisatawan yang ingin menjelajahi restoran, destinasi, hotel, dan budaya Ubud.
        </p>
    </div>
</section>

{{-- MISI --}}
<section class="wrapper bg-white">
    <div class="flex flex-col md:flex-row gap-10 items-center">
        <div class="w-full md:w-1/2" data-reveal="fade-right">
            <p class="text-xs tracking-widest uppercase font-semibold text-gray-400 mb-2">Misi Kami</p>
            <h2 class="font-extrabold leading-tight mb-4 text-gray-900" style="font-size: clamp(24px, 4vw, 36px);">
                Satu Tujuan: Membawa Anda Lebih Dekat dengan Ubud
            </h2>
            <p class="text-gray-500 text-[15px] leading-relaxed mb-3">
                Ubud Travel lahir dari kecintaan mendalam terhadap Ubud bukan sekadar destinasi wisata, melainkan pengalaman budaya yang hidup. Kami percaya setiap wisatawan berhak mendapat informasi yang jujur dan mudah diakses.
            </p>
            <p class="text-gray-500 text-[15px] leading-relaxed">
                Direktori restoran, peta destinasi, tipe kamar hotel, hingga artikel budaya semuanya dalam satu platform.
            </p>
            <div class="flex gap-8 mt-6 flex-wrap">
                <div data-reveal="fade-up" data-delay="100">
                    <p class="font-black text-gray-900 text-3xl leading-none">200+</p>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mt-1">Destinasi</p>
                </div>
                <div data-reveal="fade-up" data-delay="200">
                    <p class="font-black text-gray-900 text-3xl leading-none">150+</p>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mt-1">Restoran</p>
                </div>
                <div data-reveal="fade-up" data-delay="300">
                    <p class="font-black text-gray-900 text-3xl leading-none">80+</p>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mt-1">Hotel & Villa</p>
                </div>
            </div>
        </div>
        <div class="w-full md:w-1/2" data-reveal="fade-left" data-delay="150">
            <div class="relative" style="height: 340px;">
                <img src="https://akcdn.detik.net.id/visual/2020/10/14/ayunan-zen-hideaway-ubud_169.jpeg?w=1200"
                     alt="Ubud Temple" class="absolute top-0 right-0 rounded-2xl object-cover shadow-lg"
                     style="width: 72%; height: 78%;">
                <img src="https://www.civitatis.com/f/indonesia/bali/guia/ubud-m.jpg"
                     alt="Ubud Rice" class="absolute bottom-0 left-0 rounded-2xl object-cover shadow-lg border-4 border-white"
                     style="width: 60%; height: 65%;">
            </div>
        </div>
    </div>
</section>

{{-- APA YANG KAMI SEDIAKAN gambar + blur sebagai bg --}}
<section class="relative overflow-hidden">
    <img src="https://a.loveholidays.com/media-library/~production/d323ed0bb7e305eda8cba2f0d0a52ca405ac8e7d-3863x1300.jpg?auto=avif%2Cwebp&quality=80&dpr=1.5&optimize=high&fit=crop&width=1280&height=380"
         alt="" class="absolute inset-0 w-full h-full object-cover" aria-hidden="true">
    <div class="absolute inset-0 bg-black/10 backdrop-blur-sm"></div>
    <div class="wrapper relative">
        <div class="text-center mb-8" data-reveal="fade-up">
            <p class="text-xs tracking-widest uppercase font-semibold text-white mb-2">Platform Kami</p>
            <h2 class="font-extrabold text-white" style="font-size: clamp(22px, 4vw, 34px);">Informasi Lengkap, Satu Tempat</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:-translate-y-1 transition-transform duration-300" data-reveal="fade-up" data-delay="100">
                <i class="bi bi-cup-hot text-2xl text-gray-500 mb-3 block"></i>
                <h3 class="font-bold text-gray-900 text-sm mb-1">Restoran & Kafe</h3>
                <p class="text-gray-400 text-xs leading-relaxed">Menu, harga, jam buka, dan lokasi lengkap.</p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:-translate-y-1 transition-transform duration-300" data-reveal="fade-up" data-delay="200">
                <i class="bi bi-compass text-2xl text-gray-500 mb-3 block"></i>
                <h3 class="font-bold text-gray-900 text-sm mb-1">Destinasi Wisata</h3>
                <p class="text-gray-400 text-xs leading-relaxed">Peta lokasi, tiket, dan panduan singkat.</p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:-translate-y-1 transition-transform duration-300" data-reveal="fade-up" data-delay="300">
                <i class="bi bi-building text-2xl text-gray-500 mb-3 block"></i>
                <h3 class="font-bold text-gray-900 text-sm mb-1">Hotel & Villa</h3>
                <p class="text-gray-400 text-xs leading-relaxed">Tipe kamar, tarif per malam, dan fasilitas.</p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:-translate-y-1 transition-transform duration-300" data-reveal="fade-up" data-delay="400">
                <i class="bi bi-journal-richtext text-2xl text-gray-500 mb-3 block"></i>
                <h3 class="font-bold text-gray-900 text-sm mb-1">Artikel Ubud</h3>
                <p class="text-gray-400 text-xs leading-relaxed">Budaya, tips perjalanan, dan info terkini.</p>
            </div>
        </div>
    </div>
</section>

{{-- NILAI KAMI --}}
<section class="wrapper bg-white">
    <div class="text-center mb-8" data-reveal="fade-up">
        <p class="text-xs tracking-widest uppercase font-semibold text-gray-400 mb-2">Nilai Kami</p>
        <h2 class="font-extrabold text-gray-900" style="font-size: clamp(22px, 4vw, 34px);">Prinsip yang Memandu Kami</h2>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="text-center p-5" data-reveal="zoom-in" data-delay="100">
            <div class="w-12 h-12 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center text-xl text-gray-500 mx-auto mb-3">
                <i class="bi bi-patch-check"></i>
            </div>
            <h4 class="font-bold text-gray-900 text-sm mb-1">Informasi Akurat</h4>
            <p class="text-gray-400 text-xs leading-relaxed">Data diverifikasi langsung dari lapangan.</p>
        </div>
        <div class="text-center p-5" data-reveal="zoom-in" data-delay="200">
            <div class="w-12 h-12 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center text-xl text-gray-500 mx-auto mb-3">
                <i class="bi bi-people"></i>
            </div>
            <h4 class="font-bold text-gray-900 text-sm mb-1">Ramah Wisatawan</h4>
            <p class="text-gray-400 text-xs leading-relaxed">Mudah dipahami siapa saja, dari manapun.</p>
        </div>
        <div class="text-center p-5" data-reveal="zoom-in" data-delay="300">
            <div class="w-12 h-12 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center text-xl text-gray-500 mx-auto mb-3">
                <i class="bi bi-heart"></i>
            </div>
            <h4 class="font-bold text-gray-900 text-sm mb-1">Cinta Budaya Lokal</h4>
            <p class="text-gray-400 text-xs leading-relaxed">Jembatan antara wisatawan dan budaya Ubud.</p>
        </div>
        <div class="text-center p-5" data-reveal="zoom-in" data-delay="400">
            <div class="w-12 h-12 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center text-xl text-gray-500 mx-auto mb-3">
                <i class="bi bi-shield-check"></i>
            </div>
            <h4 class="font-bold text-gray-900 text-sm mb-1">Terpercaya</h4>
            <p class="text-gray-400 text-xs leading-relaxed">Referensi utama wisatawan ke Ubud.</p>
        </div>
    </div>
</section>

<section class="relative overflow-hidden" data-reveal="fade-up">
    <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1600&q=80"
         alt="" class="absolute inset-0 w-full h-full object-cover" aria-hidden="true">
    <div class="absolute inset-0 bg-white/75 backdrop-blur-sm"></div>
    <div class="wrapper relative flex flex-col md:flex-row items-center justify-between gap-6 flex-wrap">
        <div>
            <h2 class="font-extrabold text-gray-900 mb-2" style="font-size: clamp(20px, 3vw, 30px);">Siap Menjelajahi Ubud?</h2>
            <p class="text-gray-500 text-[15px]">Restoran, destinasi, villa semua informasi ada di sini.</p>
        </div>
        <div class="flex gap-3 flex-wrap">
            <a href="{{ route('destinations.index') }}"
               class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white px-6 py-3 rounded-xl text-sm font-semibold no-underline transition-colors duration-200">
                <i class="bi bi-compass"></i> Jelajahi Destinasi
            </a>
            <a href="{{ route('galeri') }}"
               class="inline-flex items-center gap-2 border border-gray-300 text-gray-700 hover:bg-gray-100 px-6 py-3 rounded-xl text-sm font-semibold no-underline transition-colors duration-200">
                <i class="bi bi-images"></i> Lihat Galeri
            </a>
        </div>
    </div>
</section>
 
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Tentang Kami') }}</h2>
</x-slot>
 
</x-app-layout>