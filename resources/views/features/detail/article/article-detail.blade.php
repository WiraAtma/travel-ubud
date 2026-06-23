<x-app-layout>

    {{-- ══ HERO COVER ══ --}}
    <header style="position: relative; overflow: hidden;">
        <img
            src="{{ $article->image_cover ? asset('storage/' . $article->image_cover) : 'https://placehold.co/1200x500?text=No+Image' }}"
            alt="{{ $article->title }}"
            style="display: block; width: 100%; height: 480px; object-fit: cover;"
        >
        <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.65));"></div>

        {{-- Breadcrumb --}}
        <div style="position: absolute; top: 24px; left: 0; width: 100%; padding: 0 24px;">
            <div class="max-w-5xl mx-auto">
                <a href="{{ route('article') }}" class="text-white text-sm opacity-80 hover:opacity-100 transition no-underline">
                    ← Kembali ke Artikel
                </a>
            </div>
        </div>

        {{-- Title overlay --}}
        <div style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 32px 24px;">
            <div class="max-w-5xl mx-auto">
                <h1 class="font-extrabold text-white mb-2"
                    style="font-size: clamp(26px,5vw,44px); line-height:1.2; text-shadow:2px 2px 8px rgba(0,0,0,0.5);">
                    {{ $article->title }}
                </h1>

                <div class="flex flex-wrap items-center gap-4 text-white text-sm" style="opacity:.9;">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $article->created_at->translatedFormat('d F Y') }}
                    </span>
                    @if ($article->author)
                        <span style="opacity:.7;">Oleh {{ $article->author->name }}</span>
                    @endif
                </div>
            </div>
        </div>
    </header>

    {{-- ══ MAIN CONTENT ══ --}}
    <section class="wrapper">
        <div class="max-w-5xl mx-auto px-6 py-12">

            <div class="bg-white rounded-2xl shadow-sm p-8 mb-8 summernote-content">
                {!! $article->content !!}
            </div>

        </div>
    </section>

    {{-- ══ KOMENTAR ══ --}}
    <section id="comments-section" class="max-w-5xl mx-auto px-6 pb-16">

        @auth

            {{-- Komentar --}}
            <div class="bg-white rounded-2xl shadow-sm p-8 mb-6" id="comments">
                <h2 class="text-xl font-bold text-gray-900 mb-5">
                    Komentar
                    <span class="text-base font-normal text-gray-400 ml-1">({{ $comments->count() }})</span>
                </h2>

                {{-- Form tulis komentar --}}
                <form method="POST" action="{{ route('article.comments.store', $article->id) }}" class="mb-8">
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
                            @include('features.detail.article._comment-item', [
                                'comment' => $comment,
                                'article' => $article,
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
                <p class="text-gray-700 font-semibold text-base mb-1">Login untuk Memberikan Komentar</p>
                <p class="text-gray-400 text-sm mb-5">Bergabunglah dan bagikan pendapatmu tentang artikel ini.</p>
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
    </style>

</x-app-layout>