<x-app-layout>

    {{-- ===== HERO HEADER ===== --}}
    <section class="py-6 px-5 md:px-8">
        <div class="p-8 md:p-12 rounded-2xl border border-gray-200 bg-white"
             data-reveal="fade-up">
            <div class="w-14 h-1 bg-red-600 mb-3"></div>
            <p class="uppercase text-red-600 font-semibold text-xs tracking-widest mb-2"
               data-reveal="fade-up" data-delay="100">
                Galeri Foto
            </p>
            <h1 class="font-bold text-5xl mb-4 text-gray-900"
                data-reveal="fade-up" data-delay="200">
                Gambar / Foto
            </h1>
            <p class="text-gray-500 max-w-3xl leading-relaxed text-base"
               data-reveal="fade-up" data-delay="300">
                Seperti yang sering dikatakan, gambar dapat mewakili ribuan kata.
                Berikut adalah kumpulan foto keindahan Ubud yang menampilkan pesona alam, budaya,
                dan kehidupan masyarakatnya.
            </p>
        </div>
    </section>

    <div class="container mx-auto px-4 md:px-8 max-w-7xl">

        {{-- ===== SECTION: PESONA ALAM ===== --}}
        <div class="py-10">
            <h2 class="text-4xl md:text-5xl font-normal mb-8 text-gray-900"
                data-reveal="fade-up">
                Pesona Alam <span class="font-bold underline">Ubud</span>
            </h2>

            {{-- Grid baris pertama: 1 foto besar kiri + 2 foto kanan --}}
            <div class="grid grid-cols-2 gap-2.5 mb-2.5" style="grid-template-rows: 260px 260px;">
                <div class="row-span-2" data-reveal="fade-right" data-delay="100">
                    <img src="https://jungleclububud.com/wp-content/uploads/2025/08/water-ubud-palace.jpg"
                         alt="ubud-1"
                         class="rounded-xl w-full h-full object-cover">
                </div>
                <img src="https://nibble-images.b-cdn.net/nibble/original_images/ubud_tegallalang_21d29a18eb.jpg"
                     alt="ubud-2"
                     class="rounded-xl w-full h-full object-cover"
                     data-reveal="fade-left" data-delay="200">
                <img src="https://nibble-images.b-cdn.net/nibble/original_images/ubud_monkey_forest_f4aa662a35.jpg"
                     alt="ubud-3"
                     class="rounded-xl w-full h-full object-cover"
                     data-reveal="fade-left" data-delay="300">
            </div>

            {{-- Grid baris kedua: 1 foto lebar atas + 2 foto bawah --}}
            <div class="grid grid-cols-2 gap-2.5" style="grid-template-rows: 320px 300px;">
                <div class="col-span-2" data-reveal="zoom-in" data-delay="100">
                    <img src="https://jungleclububud.com/wp-content/uploads/2025/10/ubud-envato.jpg"
                         alt="ubud-lebar"
                         class="rounded-xl w-full h-full object-cover">
                </div>
                <img src="https://i.pinimg.com/736x/81/0c/57/810c57a0a3dd0b262a71141cfa05616b.jpg"
                     alt="ubud-4"
                     class="rounded-xl w-full object-cover"
                     style="height: 300px;"
                     data-reveal="fade-up" data-delay="200">
                <img src="https://akcdn.detik.net.id/visual/2025/05/14/foto-dok-ubudquadbikingcom-1747221720490_169.jpeg?w=700&q=90"
                     alt="ubud-5"
                     class="rounded-xl w-full object-cover"
                     style="height: 300px;"
                     data-reveal="fade-up" data-delay="300">
            </div>
        </div>

        {{-- ===== SECTION: BUDAYA ===== --}}
        <div class="py-10 mt-20">
            <h2 class="text-4xl md:text-5xl font-normal mb-8 text-gray-900"
                data-reveal="fade-up">
                Budaya <span class="font-bold underline">Ubud</span>
            </h2>

            {{-- Grid 3 kolom --}}
            <div class="grid gap-2.5 mb-2.5" style="grid-template-columns: 1.5fr 1fr 1fr; height: 320px;">
                <img src="https://awsimages.detik.net.id/community/media/visual/2026/03/18/antusiasme-para-turis-asing-menunggu-penampilan-ogoh-ogoh-saat-diguyur-hujan-di-catus-pata-ubud-jalan-suweta-ubud-gianyar-rabu-1773833671893_169.jpeg?w=620"
                     alt="ogoh-ogoh"
                     class="rounded-xl w-full h-full object-cover"
                     data-reveal="fade-right" data-delay="100">
                <img src="https://img.merahputih.com/media/52/38/94/523894e0a35dd4b35f857746a115c331.jpg"
                     alt="budaya-1"
                     class="rounded-xl w-full h-full object-cover"
                     data-reveal="fade-up" data-delay="200">
                <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/18/3d/b9/be/the-balinesse-preparing.jpg?w=1400&h=800&s=1"
                     alt="budaya-2"
                     class="rounded-xl w-full h-full object-cover"
                     data-reveal="fade-left" data-delay="300">
            </div>

            {{-- Grid 2 kolom: 2 foto kiri + 1 foto besar kanan --}}
            <div class="grid grid-cols-2 gap-2.5" style="grid-template-rows: 250px 250px;">
                <img src="https://thumbs.dreamstime.com/b/balinese-galungan-festival-ubud-photo-village-mode-92301559.jpg"
                     alt="galungan"
                     class="rounded-xl w-full h-full object-cover"
                     data-reveal="fade-right" data-delay="100">
                <div class="row-span-2" data-reveal="fade-left" data-delay="100">
                    <img src="https://thumbs.dreamstime.com/b/melasti-ceremony-temple-banjar-bunutan-kedewatan-ubud-bali-indonesia-ubud-bali-melasti-ceremony-banjar-bunutan-242682179.jpg?w=992"
                         alt="melasti"
                         class="rounded-xl w-full h-full object-cover">
                </div>
                <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/14/72/06/ea/pura-dalem-puri-peliatan.jpg?w=1100&h=1100&s=1"
                     alt="pura"
                     class="rounded-xl w-full h-full object-cover"
                     data-reveal="fade-right" data-delay="200">
            </div>
        </div>

        {{-- ===== SECTION: KERAJINAN DAN SENI ===== --}}
        <div class="py-10">
            <h2 class="text-4xl md:text-5xl font-normal mb-8 text-gray-900"
                data-reveal="fade-up">
                Kerajinan dan Seni <span class="font-bold underline">Ubud</span>
            </h2>

            {{-- Grid: 1 foto besar kiri + 2 foto kanan --}}
            <div class="grid grid-cols-2 gap-2.5 mb-2.5" style="grid-template-rows: 250px 250px;">
                <div class="row-span-2" data-reveal="fade-right" data-delay="100">
                    <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/28/18/19/97/caption.jpg?w=1400&h=800&s=1"
                         alt="seni-1"
                         class="rounded-xl w-full h-full object-cover">
                </div>
                <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/19/b9/60/05/20190927-105909-01-largejpg.jpg?w=1200&h=-1&s=1"
                     alt="seni-2"
                     class="rounded-xl w-full h-full object-cover"
                     data-reveal="fade-left" data-delay="200">
                <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/19/b9/60/03/20190927-110511-01-largejpg.jpg?w=1200&h=-1&s=1"
                     alt="seni-3"
                     class="rounded-xl w-full h-full object-cover"
                     data-reveal="fade-left" data-delay="300">
            </div>

            {{-- Grid 2 kolom bawah --}}
            <div class="grid grid-cols-2 gap-2.5">
                <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/19/25/fa/3b/20190825085047-img-2347.jpg?w=1400&h=800&s=1"
                     alt="seni-4"
                     class="rounded-xl w-full object-cover"
                     style="height: 250px;"
                     data-reveal="fade-up" data-delay="100">
                <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/14/6d/f5/1e/ubud-traditional-art.jpg?w=1400&h=800&s=1"
                     alt="seni-5"
                     class="rounded-xl w-full object-cover"
                     style="height: 250px;"
                     data-reveal="fade-up" data-delay="200">
            </div>
        </div>

    </div>

    {{-- ===== CTA SECTION ===== --}}
    <div class="bg-[#f8f8f6] py-20 text-center mt-10">
        <div class="container mx-auto px-4 max-w-2xl">
            <h2 class="text-4xl font-extrabold mb-4 text-gray-900"
                data-reveal="fade-up">
                Masih Ingin Jelajahi Ubud?
            </h2>
            <p class="text-base text-gray-600 max-w-sm mx-auto leading-relaxed mb-10"
               data-reveal="fade-up" data-delay="100">
                Temukan destinasi wisata, penginapan terbaik, dan galeri pemandangan Ubud yang menakjubkan.
            </p>
            <div class="flex flex-wrap justify-center gap-3"
                 data-reveal="fade-up" data-delay="200">
                <a href="{{ route('home') }}"
                   class="border border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white transition-colors rounded-full px-10 py-3 text-sm font-medium">
                    Lihat Destinasi
                </a>
                <a href="{{ route('hotel') }}"
                   class="border border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white transition-colors rounded-full px-10 py-3 text-sm font-medium">
                    Cari Hotel
                </a>
            </div>
        </div>
    </div>

    {{-- ===== REVEAL SCROLL SCRIPT ===== --}}
    @push('scripts')
    <script>
        (function () {
            const reveals = document.querySelectorAll('[data-reveal]');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        observer.unobserve(entry.target); // animasi sekali saja
                    }
                });
            }, {
                threshold: 0.12,
                rootMargin: '0px 0px -40px 0px'
            });

            reveals.forEach(el => observer.observe(el));
        })();
    </script>
    @endpush

</x-app-layout>