<x-app-layout>

<!-- HERO ABOUT -->
    <section class="w-full relative" style="height: 450px;">

    <!-- Background -->
    <img
        src="https://tse1.mm.bing.net/th/id/OIP.OdyKtISRGJ5tazllsigkGQHaEJ?cb=thfc1falcon2&w=714&h=400&rs=1&pid=ImgDetMain&o=7&rm=3"
        alt="Tentang Kami"
        class="absolute inset-0 w-full h-full object-cover">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/40"></div>

    <!-- Content -->
    <div class="relative z-10 flex items-center justify-center h-full">

        <div class="text-center text-white px-6">

            <h1 class="text-5xl font-bold mb-5">
                Ubud Travel
            </h1>

            <p class="max-w-3xl mx-auto text-lg leading-relaxed">
                Mengenal lebih dekat Ubud Travel sebagai partner terbaik
                untuk menjelajahi keindahan budaya, alam, kuliner,
                dan destinasi wisata di Bali.
            </p>

        </div>

    </div>

</section>

    <!-- PROFIL PERUSAHAAN -->
    <section class="max-w-7xl mx-auto px-6 py-24">

        <div class="grid md:grid-cols-2 gap-16 items-center">

            <!-- TEKS -->
            <div>

                <span class="text-gray-600 font-semibold uppercase">
                    Profil Perusahaan
                </span>

                <h2 class="text-4xl font-bold text-gray-800 mt-3 mb-6">
                    Menjelajahi Bali Bersama Ubud Travel
                </h2>

                <p class="text-gray-600 leading-relaxed mb-5">
                    Ubud Travel merupakan platform informasi wisata yang
                    membantu wisatawan menemukan destinasi terbaik,
                    restoran populer, hotel nyaman, serta berbagai
                    aktivitas menarik di Bali.
                </p>

                <p class="text-gray-600 leading-relaxed">
                    Kami hadir untuk memberikan informasi yang lengkap,
                    akurat, dan mudah diakses sehingga setiap perjalanan
                    menjadi pengalaman yang lebih menyenangkan dan berkesan.
                </p>

            </div>

            <!-- GAMBAR -->
            <div>
                <img
                    src="https://ik.imagekit.io/tvlk/blog/2021/05/WISATA-BALI.jpg"
                    alt="Ubud Travel"
                    class="w-full h-[450px] object-cover rounded-3xl shadow-xl">
            </div>

        </div>

    </section>

    <!-- VISI MISI -->
    <section class="bg-gray-50 py-24">

        <div class="max-w-7xl mx-auto px-6">

            <div class="grid md:grid-cols-2 gap-16 items-center">

                <!-- GAMBAR -->
                <div>
                    <img
                        src="https://yoexplore.co.id/wp-content/uploads/2019/04/fakta-unik-tentang-bali-yoexplore-ebalitour.jpg"
                        alt="Visi Misi"
                        class="w-full h-[450px] object-cover rounded-3xl shadow-xl">
                </div>

                <!-- TEKS -->
                <div>

                    <span class="text-gray-600 font-semibold uppercase">
                        Visi dan Misi
                    </span>

                    <h2 class="text-4xl font-bold text-gray-800 mt-3 mb-6">
                        Menjadi Panduan Wisata Terpercaya di Bali
                    </h2>

                    <div class="space-y-4 text-gray-600">

                        <p>
                            <strong>Visi:</strong>
                            Menjadi platform wisata terpercaya yang membantu
                            wisatawan menemukan pengalaman terbaik di Bali.
                        </p>

                        <p>
                            <strong>Misi:</strong>
                        </p>

                        <ul class="list-disc pl-5 space-y-2">
                            <li>Menyediakan informasi wisata yang lengkap.</li>
                            <li>Membantu wisatawan merencanakan perjalanan.</li>
                            <li>Mempromosikan budaya dan pariwisata Bali.</li>
                            <li>Memberikan pengalaman pengguna yang mudah dan nyaman.</li>
                        </ul>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- KEUNGGULAN & SEJARAH -->
    <section class="max-w-7xl mx-auto px-6 py-24">

        <div class="grid md:grid-cols-2 gap-10">

            <!-- KEUNGGULAN -->
            <div class="bg-white rounded-3xl shadow-lg p-8">

                <h3 class="text-3xl font-bold mb-6 text-gray-800">
                    Mengapa Memilih Kami
                </h3>

                <ul class="space-y-4 text-gray-600">

                    <li>✅ Informasi wisata terpercaya</li>

                    <li>✅ Destinasi populer dan terbaru</li>

                    <li>✅ Rekomendasi hotel dan restoran terbaik</li>

                    <li>✅ Tampilan website mudah digunakan</li>

                    <li>✅ Update informasi secara berkala</li>

                </ul>

            </div>

            <!-- SEJARAH -->
            <div class="bg-white rounded-3xl shadow-lg p-8">

                <h3 class="text-3xl font-bold mb-6 text-gray-800">
                    Sejarah Perusahaan
                </h3>

                <p class="text-gray-600 leading-relaxed">
                    Ubud Travel dibangun dengan tujuan membantu wisatawan
                    mendapatkan informasi lengkap mengenai Bali dalam
                    satu platform yang mudah digunakan.
                </p>

                <p class="text-gray-600 leading-relaxed mt-4">
                    Dengan berkembangnya industri pariwisata digital,
                    kami terus berinovasi untuk menghadirkan informasi
                    destinasi, hotel, restoran, dan galeri wisata yang
                    relevan bagi pengguna.
                </p>

            </div>

        </div>

    </section>

    <!-- TIM -->
    <section class="bg-gray-50 py-24">

        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-16">

                <h2 class="text-4xl font-bold text-gray-800 mb-4">
                    Tim Kami
                </h2>

                <p class="text-gray-600">
                    Orang-orang hebat di balik pengembangan Ubud Travel.
                </p>

            </div>

            <div class="grid md:grid-cols-4 gap-8">

                @for ($i = 1; $i <= 4; $i++)

                    <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

                        <img
                            src="https://placehold.co/400x400"
                            alt="Tim"
                            class="w-full">

                        <div class="p-5 text-center">

                            <h4 class="font-bold text-lg">
                                Nama Anggota
                            </h4>

                            <p class="text-gray-500">
                                Team Member
                            </p>

                        </div>

                    </div>

                @endfor

            </div>

        </div>

    </section>

    <!-- CTA -->
    <section class="py-24">

        <div class="max-w-5xl mx-auto px-6">

            <div class="bg-stone-100 rounded-3xl p-12 text-center text-gray-800 shadow-lg">

                <h2 class="text-4xl font-bold mb-4">
                    Siap Menjelajahi Bali Bersama Kami?
                </h2>

                <p class="text-lg mb-8">
                    Temukan destinasi wisata terbaik, hotel nyaman,
                    restoran favorit, dan pengalaman menarik lainnya.
                </p>

                <a href="#"
                    class="inline-block bg-white text-gray-600 font-semibold px-8 py-4 rounded-xl hover:bg-gray-100 transition">
                    Jelajahi Sekarang
                </a>

            </div>

        </div>

    </section>

</section>

</x-app-layout>