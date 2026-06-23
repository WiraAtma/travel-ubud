<x-app-layout>

    {{-- ══ HERO COVER ══ --}}
    <header style="position: relative; overflow: hidden;">
        <img
            src="{{ $hotel->image_cover ? asset('storage/' . $hotel->image_cover) : 'https://placehold.co/1200x500?text=No+Image' }}"
            alt="{{ $hotel->name }}"
            style="display: block; width: 100%; height: 480px; object-fit: cover;"
        >
        <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.65));"></div>

        {{-- Breadcrumb --}}
        <div style="position: absolute; top: 24px; left: 0; width: 100%; padding: 0 24px;">
            <div class="max-w-5xl mx-auto">
                <a href="{{ route('hotel') }}" class="text-white text-sm opacity-80 hover:opacity-100 transition no-underline">
                    ← Kembali ke Hotel
                </a>
            </div>
        </div>

        {{-- Title overlay --}}
        <div style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 32px 24px;">
            <div class="max-w-5xl mx-auto">
                <h1 class="font-extrabold text-white mb-2"
                    style="font-size: clamp(26px,5vw,44px); line-height:1.2; text-shadow:2px 2px 8px rgba(0,0,0,0.5);">
                    {{ $hotel->name }}
                </h1>
                <div class="flex flex-wrap items-center gap-4 text-white text-sm" style="opacity:.9;">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0L6.343 16.657a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $hotel->address }}
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="text-yellow-400">★</span>
                        {{ number_format($hotel->rating, 1) }}
                        <span style="opacity:.7;">({{ $hotel->rating_count }} ulasan)</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        {{ $hotel->phone }}
                    </span>
                    @if ($hotel->author)
                        <span style="opacity:.7;">Oleh {{ $hotel->author->name }}</span>
                    @endif
                </div>
            </div>
        </div>
    </header>

    {{-- ══ MAIN CONTENT + SIDEBAR ══ --}}
    <section class="wrapper">
        <div class="max-w-5xl mx-auto px-6 py-12">
            <div class="flex flex-col lg:flex-row gap-10">

                {{-- ── Main ── --}}
                <div class="flex-1 min-w-0">

                    {{-- Deskripsi --}}
                    <div class="bg-white rounded-2xl shadow-sm p-8 mb-8 summernote-content">
                        {!! $hotel->description !!}
                    </div>

                    {{-- Kamar / Rooms --}}
                    @if ($hotel->rooms->isNotEmpty())
                        <div class="bg-white rounded-2xl shadow-sm p-8 mb-8">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Tipe Kamar</h2>
                            <div class="flex flex-col gap-5">
                                @foreach ($hotel->rooms as $room)
                                    <div class="flex flex-col sm:flex-row gap-4 p-4 rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition">
                                        {{-- Room image --}}
                                        @if ($room->image_cover)
                                            <img src="{{ asset('storage/' . $room->image_cover) }}"
                                                 alt="{{ $room->name }}"
                                                 class="w-full sm:w-36 h-28 object-cover rounded-xl flex-shrink-0">
                                        @else
                                            <div class="w-full sm:w-36 h-28 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                          d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                                </svg>
                                            </div>
                                        @endif

                                        {{-- Room info --}}
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-wrap items-start justify-between gap-2 mb-2">
                                                <h3 class="font-bold text-gray-900 text-base">{{ $room->name }}</h3>
                                                <span class="text-indigo-600 font-bold text-sm whitespace-nowrap">
                                                    Rp {{ number_format($room->price, 0, ',', '.') }}<span class="font-normal text-gray-400">/malam</span>
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-500 mb-3 flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                Maks. {{ $room->max_guests }} tamu
                                            </p>
                                            @if (!empty($room->facilities))
                                                <div class="flex flex-wrap gap-1.5">
                                                    @foreach ($room->facilities as $fac)
                                                        <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-0.5 rounded-full">
                                                            {{ $fac }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Links / Booking --}}
                    @if ($hotel->links->isNotEmpty())
                        <div class="bg-white rounded-2xl shadow-sm p-8">
                            <h2 class="text-xl font-bold text-gray-900 mb-5">Pemesanan & Tautan</h2>
                            <div class="flex flex-col gap-4">
                                @foreach ($hotel->links as $link)
                                    <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer"
                                       class="flex items-center gap-4 p-4 rounded-xl border border-gray-100 hover:border-gray-300 hover:shadow-sm transition no-underline group">
                                        @if ($link->image_cover)
                                            <img src="{{ asset('storage/' . $link->image_cover) }}"
                                                 alt="{{ $link->label }}"
                                                 class="w-14 h-14 object-cover rounded-lg flex-shrink-0">
                                        @else
                                            <div class="w-14 h-14 rounded-lg flex-shrink-0 flex items-center justify-center bg-gray-100">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <p class="font-semibold text-gray-900 group-hover:text-indigo-600 transition text-sm">{{ $link->label }}</p>
                                            <p class="text-xs text-gray-400 truncate mt-0.5">{{ $link->url }}</p>
                                        </div>
                                        <svg class="w-4 h-4 text-gray-300 group-hover:text-indigo-400 flex-shrink-0 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>

                {{-- ── Sidebar ── --}}
                <aside class="w-full lg:w-72 flex-shrink-0">
                    <div class="sticky top-6 flex flex-col gap-5">

                        <div class="bg-white rounded-2xl shadow-sm p-6">
                            <h3 class="font-bold text-gray-900 mb-4 text-base">Informasi Hotel</h3>
                            <ul class="flex flex-col gap-4 text-sm">

                                {{-- Harga mulai --}}
                                <li class="flex items-start gap-3">
                                    <span class="mt-0.5 flex-shrink-0">
                                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-gray-400 text-xs mb-0.5">Harga Mulai</p>
                                        <p class="text-gray-800 font-semibold">Rp {{ number_format($hotel->start_price, 0, ',', '.') }}<span class="text-gray-400 font-normal">/malam</span></p>
                                    </div>
                                </li>

                                {{-- Rating --}}
                                <li class="flex items-start gap-3">
                                    <span class="mt-0.5 flex-shrink-0">
                                        <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-gray-400 text-xs mb-0.5">Rating</p>
                                        <p class="text-gray-800 font-medium">
                                            {{ number_format($hotel->rating, 1) }}
                                            <span class="text-gray-400 font-normal">({{ $hotel->rating_count }} ulasan)</span>
                                        </p>
                                    </div>
                                </li>

                                {{-- Check-in / Check-out --}}
                                <li class="flex items-start gap-3">
                                    <span class="mt-0.5 flex-shrink-0">
                                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-gray-400 text-xs mb-0.5">Check-in / Check-out</p>
                                        <p class="text-gray-800 font-medium">{{ $hotel->checkin_time }} — {{ $hotel->checkout_time }}</p>
                                    </div>
                                </li>

                                {{-- Alamat --}}
                                <li class="flex items-start gap-3">
                                    <span class="mt-0.5 flex-shrink-0">
                                        <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0L6.343 16.657a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-gray-400 text-xs mb-0.5">Alamat</p>
                                        <p class="text-gray-800 font-medium">{{ $hotel->address }}</p>
                                    </div>
                                </li>

                                {{-- Telepon --}}
                                <li class="flex items-start gap-3">
                                    <span class="mt-0.5 flex-shrink-0">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-gray-400 text-xs mb-0.5">Telepon</p>
                                        <p class="text-gray-800 font-medium">{{ $hotel->phone }}</p>
                                    </div>
                                </li>

                                {{-- Fasilitas Hotel --}}
                                @if (!empty($hotel->facilities))
                                    <li class="flex items-start gap-3">
                                        <span class="mt-0.5 flex-shrink-0">
                                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                            </svg>
                                        </span>
                                        <div>
                                            <p class="text-gray-400 text-xs mb-1.5">Fasilitas</p>
                                            <div class="flex flex-wrap gap-1.5">
                                                @foreach ($hotel->facilities as $fac)
                                                    <span class="text-xs bg-indigo-50 text-indigo-700 font-medium px-2.5 py-0.5 rounded-full">
                                                        {{ $fac }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </li>
                                @endif

                                {{-- Catatan --}}
                                @if ($hotel->notes)
                                    <li class="flex items-start gap-3">
                                        <span class="mt-0.5 flex-shrink-0">
                                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </span>
                                        <div>
                                            <p class="text-gray-400 text-xs mb-0.5">Catatan</p>
                                            <p class="text-gray-700 text-xs leading-relaxed">{{ $hotel->notes }}</p>
                                        </div>
                                    </li>
                                @endif

                                {{-- Kontributor --}}
                                @if ($hotel->author)
                                    <li class="flex items-start gap-3">
                                        <span class="mt-0.5 flex-shrink-0">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </span>
                                        <div>
                                            <p class="text-gray-400 text-xs mb-0.5">Kontributor</p>
                                            <p class="text-gray-800 font-medium">{{ $hotel->author->name }}</p>
                                        </div>
                                    </li>
                                @endif

                            </ul>
                        </div>

                        <a href="{{ route('hotel') }}"
                           class="block text-center bg-black text-white rounded-xl py-3 text-sm font-semibold hover:opacity-80 transition no-underline">
                            ← Kembali ke Semua Hotel
                        </a>

                    </div>
                </aside>

            </div>
        </div>
    </section>

    {{-- ══ RATING & KOMENTAR ══ --}}
    <section id="rating-section" class="max-w-5xl mx-auto px-6 pb-16">

        @auth

            {{-- Rating --}}
            <div class="bg-white rounded-2xl shadow-sm p-8 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-1">Beri Rating</h2>
                <p class="text-sm text-gray-400 mb-5">
                    Rating kamu saat ini:
                    <span class="font-semibold text-yellow-500">
                        {{ $userRating ? str_repeat('★', $userRating) . str_repeat('☆', 5 - $userRating) : '—' }}
                    </span>
                </p>

                <form method="POST" action="{{ route('hotel.rating.store', $hotel->id) }}">
                    @csrf
                    <div class="flex items-center gap-2 mb-5" id="star-rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer star-label" data-value="{{ $i }}">
                                <input type="radio" name="score" value="{{ $i }}" class="sr-only"
                                       {{ $userRating == $i ? 'checked' : '' }}>
                                <svg class="w-9 h-9 transition-colors star-icon {{ $userRating >= $i ? 'text-yellow-400' : 'text-gray-200' }}"
                                     fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </label>
                        @endfor
                    </div>
                    <button type="submit"
                            class="bg-black text-white text-sm font-semibold px-6 py-2.5 rounded-xl hover:opacity-80 transition">
                        Simpan Rating
                    </button>
                </form>
            </div>

            {{-- Komentar --}}
            <div class="bg-white rounded-2xl shadow-sm p-8 mb-6" id="comments">
                <h2 class="text-xl font-bold text-gray-900 mb-5">
                    Komentar
                    <span class="text-base font-normal text-gray-400 ml-1">({{ $comments->count() }})</span>
                </h2>

                {{-- Form tulis komentar --}}
                <form method="POST" action="{{ route('hotel.comments.store', $hotel->id) }}" class="mb-8">
                    @csrf
                    <div class="flex gap-3">
                        <div class="flex-shrink-0 w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xs font-bold select-none">
                            {{ collect(explode(' ', trim(Auth::user()->name)))->take(2)->map(fn($w) => strtoupper(mb_substr($w,0,1)))->join('') }}
                        </div>
                        <div class="flex-1">
                            <textarea name="body" rows="3" required maxlength="2000"
                                      placeholder="Tulis komentar..."
                                      class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700
                                             focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none transition">{{ old('body') }}</textarea>
                            @error('body')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                            <div class="flex justify-end mt-2">
                                <button type="submit"
                                        class="bg-black text-white text-xs font-semibold px-5 py-2 rounded-xl hover:opacity-80 transition">
                                    Kirim
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                {{-- Daftar komentar --}}
                <div class="flex flex-col gap-6">
                    @forelse ($comments as $comment)
                        <div id="comment-{{ $comment->id }}">
                            @include('features.detail.hotel._comment-item', [
                                'comment' => $comment,
                                'hotel'   => $hotel,
                                'depth'   => 0,
                            ])
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 text-center py-8">Belum ada komentar. Jadilah yang pertama!</p>
                    @endforelse
                </div>
            </div>

        @else
            {{-- Guest CTA --}}
            <div class="bg-white rounded-2xl shadow-sm p-10 mb-8 text-center" id="comments">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <p class="text-gray-700 font-semibold text-base mb-1">Login untuk Memberikan Rating dan Komentar</p>
                <p class="text-gray-400 text-sm mb-5">Bergabunglah dan bagikan pengalamanmu di hotel ini.</p>
                <a href="{{ route('login') }}"
                   class="inline-block bg-black text-white text-sm font-semibold px-8 py-3 rounded-xl hover:opacity-80 transition no-underline">
                    Login Sekarang
                </a>
            </div>
        @endauth

    </section>

    {{-- ══ SCRIPTS ══ --}}
    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
            });
        @endif

        if (window.location.hash) {
            setTimeout(() => {
                const el = document.querySelector(window.location.hash);
                if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);
        }

        // Star rating hover
        const labels = document.querySelectorAll('#star-rating .star-label');
        labels.forEach((label, idx) => {
            label.addEventListener('mouseenter', () => {
                labels.forEach((l, i) => {
                    l.querySelector('.star-icon').classList.toggle('text-yellow-400', i <= idx);
                    l.querySelector('.star-icon').classList.toggle('text-gray-200',   i > idx);
                });
            });
            label.addEventListener('mouseleave', () => {
                const checked    = document.querySelector('#star-rating input[type=radio]:checked');
                const checkedVal = checked ? parseInt(checked.value) : 0;
                labels.forEach((l, i) => {
                    l.querySelector('.star-icon').classList.toggle('text-yellow-400', i < checkedVal);
                    l.querySelector('.star-icon').classList.toggle('text-gray-200',   i >= checkedVal);
                });
            });
            label.addEventListener('click', () => label.querySelector('input').checked = true);
        });
    });

    function toggleForm(id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.toggle('hidden');
        if (!el.classList.contains('hidden')) el.querySelector('textarea')?.focus();
    }

    function confirmDelete(action) {
        Swal.fire({
            title: 'Hapus komentar?',
            text: 'Komentar yang dihapus tidak bisa dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#000',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = action;
                form.innerHTML = `
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    </script>
    @endpush

    <style>
        .summernote-content {
            font-family: Arial, sans-serif;
            font-size: 15px; line-height: 1.75; color: #374151;
        }
        .summernote-content h1,.summernote-content h2,.summernote-content h3,.summernote-content h4 {
            font-weight:700; color:#111827; margin-top:1.5em; margin-bottom:0.5em; line-height:1.3;
        }
        .summernote-content h1{font-size:1.75rem;}.summernote-content h2{font-size:1.375rem;}.summernote-content h3{font-size:1.125rem;}
        .summernote-content p{margin-bottom:1em;white-space:normal!important;}
        .summernote-content span {
            font-family: Arial, sans-serif !important;
            white-space: normal !important;
        }
        .summernote-content img{max-width:100%!important;height:auto!important;border-radius:12px;margin:16px auto;display:block;}
        .summernote-content ul,.summernote-content ol{padding-left:1.5rem;margin-bottom:1em;}
        .summernote-content ul{list-style-type:disc;}.summernote-content ol{list-style-type:decimal;}
        .summernote-content li{margin-bottom:0.4em;color:#374151;}
        .summernote-content b,.summernote-content strong{font-weight:700;color:#111827;}
        .summernote-content em{font-style:italic;}
        .summernote-content blockquote{border-left:4px solid #e5e7eb;padding:8px 16px;margin:16px 0;color:#6b7280;font-style:italic;}
        .summernote-content table{width:100%;border-collapse:collapse;margin-bottom:1em;font-size:14px;}
        .summernote-content th,.summernote-content td{border:1px solid #e5e7eb;padding:8px 12px;text-align:left;}
        .summernote-content th{background:#f9fafb;font-weight:600;}
    </style>

</x-app-layout>