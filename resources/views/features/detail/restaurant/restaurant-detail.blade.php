<x-app-layout>

    {{-- ══ HERO COVER ══ --}}
    <header style="position: relative; overflow: hidden;">
        <img
            src="{{ $restaurant->image_cover ? asset('storage/' . $restaurant->image_cover) : 'https://placehold.co/1200x500?text=No+Image' }}"
            alt="{{ $restaurant->name }}"
            style="display: block; width: 100%; height: 480px; object-fit: cover;"
        >
        <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.65));"></div>

        {{-- Breadcrumb --}}
        <div style="position: absolute; top: 24px; left: 0; width: 100%; padding: 0 24px;">
            <div class="max-w-5xl mx-auto">
                <a href="{{ route('restoran') }}" class="text-white text-sm opacity-80 hover:opacity-100 transition no-underline">
                    ← Kembali ke Restoran
                </a>
            </div>
        </div>

        {{-- Title overlay --}}
        <div style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 32px 24px;">
            <div class="max-w-5xl mx-auto">
                <div class="flex flex-wrap gap-2 mb-3">
                    <span class="text-xs font-semibold px-3 py-1 rounded-full"
                          style="background: rgba(255,255,255,0.2); color:#fff; backdrop-filter:blur(4px); border:1px solid rgba(255,255,255,0.3);">
                        {{ $restaurant->category }}
                    </span>
                </div>

                <h1 class="font-extrabold text-white mb-2"
                    style="font-size: clamp(26px,5vw,44px); line-height:1.2; text-shadow:2px 2px 8px rgba(0,0,0,0.5);">
                    {{ $restaurant->name }}
                </h1>

                <div class="flex flex-wrap items-center gap-4 text-white text-sm" style="opacity:.9;">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0L6.343 16.657a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $restaurant->address }}
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="text-yellow-400">★</span>
                        {{ number_format($restaurant->rating, 1) }}
                        <span style="opacity:.7;">({{ $restaurant->rating_count }} ulasan)</span>
                    </span>
                    @if ($restaurant->author)
                        <span style="opacity:.7;">Oleh {{ $restaurant->author->name }}</span>
                    @endif
                </div>
            </div>
        </div>
    </header>

    {{-- ══ MAIN CONTENT + SIDEBAR ══ --}}
    <section class="wrapper">
        <div class="max-w-5xl mx-auto px-6 py-12">
            <div class="flex flex-col lg:flex-row gap-10">

                {{-- Main --}}
                <div class="flex-1 min-w-0">

                    <div class="bg-white rounded-2xl shadow-sm p-8 mb-8 summernote-content">
                        {!! $restaurant->description !!}
                    </div>
                    {{-- ══ DAFTAR MENU ══ --}}
@if ($restaurant->menus->isNotEmpty())
    <div class="bg-white rounded-2xl shadow-sm p-8 mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-5">
            Daftar Menu
            <span class="text-base font-normal text-gray-400 ml-1">({{ $restaurant->menus->count() }})</span>
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach ($restaurant->menus as $menu)
                <div class="flex gap-4 p-4 rounded-xl border border-gray-100 {{ !$menu->is_available ? 'opacity-50' : '' }}">

                    <div class="w-20 h-20 rounded-lg flex-shrink-0 overflow-hidden bg-gray-100">
                        @if ($menu->image)
                            <img src="{{ asset('storage/' . $menu->image) }}"
                                 alt="{{ $menu->name }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M3 7h18M3 12h18M3 17h18"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <p class="font-semibold text-gray-900 text-sm truncate">{{ $menu->name }}</p>
                            @if (!$menu->is_available)
                                <span class="text-[10px] font-medium text-red-500 bg-red-50 px-2 py-0.5 rounded-full flex-shrink-0">
                                    Habis
                                </span>
                            @endif
                        </div>

                        <span class="inline-block text-[10px] bg-indigo-50 text-indigo-700 font-medium px-2 py-0.5 rounded-full mt-1">
                            {{ $menu->category }}
                        </span>

                        @if ($menu->description)
                            <p class="text-xs text-gray-500 mt-1.5 line-clamp-2">{{ $menu->description }}</p>
                        @endif

                        <p class="text-sm font-bold text-gray-900 mt-2">
                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                        </p>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
@endif

{{-- ══ TAUTAN & REFERENSI ══ --}}
@if ($restaurant->links->isNotEmpty())
    <div class="bg-white rounded-2xl shadow-sm p-8 mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-5">Referensi & Tautan</h2>
        <div class="flex flex-col gap-4">
            @foreach ($restaurant->links as $link)
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

                    @if ($restaurant->notes)
                        <div class="bg-white rounded-2xl shadow-sm p-8">
                            <h2 class="text-xl font-bold text-gray-900 mb-3">Catatan Tambahan</h2>
                            <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $restaurant->notes }}</p>
                        </div>
                    @endif

                </div>

                {{-- Sidebar --}}
                <aside class="w-full lg:w-72 flex-shrink-0">
                    <div class="sticky top-6 flex flex-col gap-5">

                        <div class="bg-white rounded-2xl shadow-sm p-6">
                            <h3 class="font-bold text-gray-900 mb-4 text-base">Informasi</h3>
                            <ul class="flex flex-col gap-3 text-sm">

                                <li class="flex items-start gap-3">
                                    <span class="mt-0.5 flex-shrink-0">
                                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0L6.343 16.657a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-gray-400 text-xs mb-0.5">Alamat</p>
                                        <p class="text-gray-800 font-medium">{{ $restaurant->address }}</p>
                                    </div>
                                </li>

                                <li class="flex items-start gap-3">
                                    <span class="mt-0.5 flex-shrink-0">
                                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-gray-400 text-xs mb-0.5">Telepon</p>
                                        <p class="text-gray-800 font-medium">{{ $restaurant->phone }}</p>
                                    </div>
                                </li>

                                <li class="flex items-start gap-3">
                                    <span class="mt-0.5 flex-shrink-0">
                                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-gray-400 text-xs mb-0.5">Jam Buka</p>
                                        <p class="text-gray-800 font-medium">
                                            {{ \Carbon\Carbon::parse($restaurant->open_time)->format('H:i') }}
                                            –
                                            {{ \Carbon\Carbon::parse($restaurant->close_time)->format('H:i') }}
                                        </p>
                                    </div>
                                </li>

                                <li class="flex items-start gap-3">
                                    <span class="mt-0.5 flex-shrink-0">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 10v2"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-gray-400 text-xs mb-0.5">Harga Mulai Dari</p>
                                        <p class="text-gray-800 font-medium">
                                            Rp {{ number_format($restaurant->start_price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </li>

                                <li class="flex items-start gap-3">
                                    <span class="mt-0.5 flex-shrink-0">
                                        <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-gray-400 text-xs mb-0.5">Rating</p>
                                        <p class="text-gray-800 font-medium">
                                            {{ number_format($restaurant->rating, 1) }}
                                            <span class="text-gray-400 font-normal">({{ $restaurant->rating_count }} ulasan)</span>
                                        </p>
                                    </div>
                                </li>

                                <li class="flex items-start gap-3">
                                    <span class="mt-0.5 flex-shrink-0">
                                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-gray-400 text-xs mb-0.5">Kategori</p>
                                        <span class="text-xs bg-indigo-50 text-indigo-700 font-medium px-2.5 py-0.5 rounded-full inline-block mt-0.5">
                                            {{ $restaurant->category }}
                                        </span>
                                    </div>
                                </li>

                                @if ($restaurant->author)
                                    <li class="flex items-start gap-3">
                                        <span class="mt-0.5 flex-shrink-0">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </span>
                                        <div>
                                            <p class="text-gray-400 text-xs mb-0.5">Kontributor</p>
                                            <p class="text-gray-800 font-medium">{{ $restaurant->author->name }}</p>
                                        </div>
                                    </li>
                                @endif

                            </ul>
                        </div>

                        <a href="{{ route('restoran') }}"
                           class="block text-center bg-black text-white rounded-xl py-3 text-sm font-semibold hover:opacity-80 transition no-underline">
                            ← Kembali ke Semua Restoran
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

                <form method="POST" action="{{ route('restaurant.rating.store', $restaurant->id) }}">
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
                <form method="POST" action="{{ route('restaurant.comments.store', $restaurant->id) }}" class="mb-8">
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
                            @include('features.detail.restaurant._comment-item', [
                                'comment'    => $comment,
                                'restaurant' => $restaurant,
                                'depth'      => 0,
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
                <p class="text-gray-400 text-sm mb-5">Bergabunglah dan bagikan pengalamanmu di restoran ini.</p>
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

        // ── SweetAlert flash ──
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

        // ── Star rating hover ──
        const labels = document.querySelectorAll('#star-rating .star-label');
        labels.forEach((label, idx) => {
            label.addEventListener('mouseenter', () => {
                labels.forEach((l, i) => {
                    l.querySelector('.star-icon').classList.toggle('text-yellow-400', i <= idx);
                    l.querySelector('.star-icon').classList.toggle('text-gray-200',   i > idx);
                });
            });
            label.addEventListener('mouseleave', () => {
                const checked   = document.querySelector('#star-rating input[type=radio]:checked');
                const checkedVal = checked ? parseInt(checked.value) : 0;
                labels.forEach((l, i) => {
                    l.querySelector('.star-icon').classList.toggle('text-yellow-400', i < checkedVal);
                    l.querySelector('.star-icon').classList.toggle('text-gray-200',   i >= checkedVal);
                });
            });
            label.addEventListener('click', () => label.querySelector('input').checked = true);
        });

    });

    // ── Toggle reply/edit form ──
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

    {{-- ══ SUMMERNOTE CSS ══ --}}
    <style>
        .summernote-content {
            font-family: Arial, sans-serif;
            font-size: 15px; line-height: 1.75; color: #374151;
        }
        .summernote-content h1,
        .summernote-content h2,
        .summernote-content h3,
        .summernote-content h4 {
            font-weight: 700; color: #111827;
            margin-top: 1.5em; margin-bottom: 0.5em; line-height: 1.3;
        }
        .summernote-content span {
            font-family: Arial, sans-serif !important;
            white-space: normal !important;
        }
        .summernote-content h1 { font-size: 1.75rem; }
        .summernote-content h2 { font-size: 1.375rem; }
        .summernote-content h3 { font-size: 1.125rem; }
        .summernote-content p  { margin-bottom: 1em; white-space: normal !important; }
        .summernote-content img  { max-width:100% !important; height:auto !important; border-radius:12px; margin:16px auto; display:block; }
        .summernote-content ul,
        .summernote-content ol  { padding-left: 1.5rem; margin-bottom: 1em; }
        .summernote-content ul  { list-style-type: disc; }
        .summernote-content ol  { list-style-type: decimal; }
        .summernote-content li  { margin-bottom: 0.4em; color: #374151; }
        .summernote-content [style*="text-align: center"] { text-align: center; }
        .summernote-content [style*="text-align: right"]  { text-align: right; }
        .summernote-content [style*="text-align: left"]   { text-align: left; }
        .summernote-content b,
        .summernote-content strong { font-weight: 700; color: #111827; }
        .summernote-content em     { font-style: italic; }
        .summernote-content blockquote {
            border-left: 4px solid #e5e7eb; padding: 8px 16px;
            margin: 16px 0; color: #6b7280; font-style: italic;
        }
        .summernote-content table { width:100%; border-collapse:collapse; margin-bottom:1em; font-size:14px; }
        .summernote-content th,
        .summernote-content td   { border:1px solid #e5e7eb; padding:8px 12px; text-align:left; }
        .summernote-content th   { background:#f9fafb; font-weight:600; }
        @media (min-width: 1024px) { aside .sticky { top: 24px; } }
    </style>

</x-app-layout>