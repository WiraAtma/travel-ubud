@php
    $initials   = collect(explode(' ', trim($comment->user->name)))
                    ->take(2)->map(fn($w) => strtoupper(mb_substr($w,0,1)))->join('');
    $colors     = ['bg-indigo-500','bg-pink-500','bg-emerald-500','bg-amber-500','bg-cyan-500','bg-violet-500','bg-rose-500'];
    $avatarColor = $colors[crc32($comment->user->name) % count($colors)];
    $isOwner    = auth()->check() && auth()->id() === $comment->user_id;
    $isAdmin    = auth()->check() && in_array(auth()->user()->role, ['admin','superadmin']);
@endphp

<div class="flex gap-3 {{ $depth > 0 ? 'ml-10 mt-4' : '' }}">

    {{-- Avatar --}}
    <div class="flex-shrink-0 w-9 h-9 rounded-full {{ $avatarColor }} flex items-center justify-center text-white text-xs font-bold select-none">
        {{ $initials }}
    </div>

    <div class="flex-1 min-w-0">

        {{-- Nama + waktu --}}
        <div class="flex items-center gap-2 mb-1 flex-wrap">
            <span class="text-sm font-semibold text-gray-900">{{ $comment->user->name }}</span>
            <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
            @if ($comment->updated_at->gt($comment->created_at->addSeconds(5)))
                <span class="text-xs text-gray-300 italic">(diedit)</span>
            @endif
        </div>

        {{-- Isi --}}
        <div class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">
            {{ $comment->body }}
        </div>

        {{-- Aksi --}}
        <div class="flex items-center gap-3 mt-2 flex-wrap">
            @auth
                @if ($depth === 0)
                    <button type="button" onclick="toggleForm('reply-form-{{ $comment->id }}')"
                            class="text-xs text-indigo-600 hover:text-indigo-800 font-medium transition">
                        Balas
                    </button>
                @endif

                @if ($isOwner)
                    <button type="button" onclick="toggleForm('edit-form-{{ $comment->id }}')"
                            class="text-xs text-gray-500 hover:text-gray-800 transition">
                        Edit
                    </button>
                @endif

                @if ($isOwner || $isAdmin)
                    <button type="button"
                            onclick="confirmDelete('{{ route('restaurant.comments.destroy', $comment->id) }}')"
                            class="text-xs text-red-400 hover:text-red-600 transition">
                        Hapus
                    </button>
                @endif
            @endauth
        </div>

        {{-- Form Edit --}}
        @if ($isOwner)
            <div id="edit-form-{{ $comment->id }}" class="hidden mt-3">
                <form method="POST" action="{{ route('restaurant.comments.update', $comment->id) }}">
                    @csrf @method('PUT')
                    <textarea name="body" rows="3" maxlength="2000"
                              class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700
                                     focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none transition">{{ $comment->body }}</textarea>
                    <div class="flex gap-2 mt-2">
                        <button type="submit"
                                class="bg-black text-white text-xs font-semibold px-4 py-1.5 rounded-lg hover:opacity-80 transition">
                            Simpan
                        </button>
                        <button type="button" onclick="toggleForm('edit-form-{{ $comment->id }}')"
                                class="text-xs text-gray-400 hover:text-gray-700 transition px-2">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        @endif

        {{-- Form Reply --}}
        @auth
            @if ($depth === 0)
                <div id="reply-form-{{ $comment->id }}" class="hidden mt-3">
                    <form method="POST" action="{{ route('restaurant.comments.store', $restaurant->id) }}">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <textarea name="body" rows="2" maxlength="2000" required
                                  placeholder="Tulis balasan..."
                                  class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700
                                         focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none transition"></textarea>
                        <div class="flex gap-2 mt-2">
                            <button type="submit"
                                    class="bg-black text-white text-xs font-semibold px-4 py-1.5 rounded-lg hover:opacity-80 transition">
                                Kirim Balasan
                            </button>
                            <button type="button" onclick="toggleForm('reply-form-{{ $comment->id }}')"
                                    class="text-xs text-gray-400 hover:text-gray-700 transition px-2">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        @endauth

        {{-- Replies --}}
        @if ($depth === 0 && $comment->replies->isNotEmpty())
            <div class="mt-4 flex flex-col gap-4 border-l-2 border-gray-100 pl-4">
                @foreach ($comment->replies as $reply)
                    @include('features.detail.restaurant._comment-item', [
                        'comment'    => $reply,
                        'restaurant' => $restaurant,
                        'depth'      => 1,
                    ])
                @endforeach
            </div>
        @endif

    </div>
</div>