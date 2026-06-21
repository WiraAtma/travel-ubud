@php
    $colors      = ['bg-indigo-500','bg-pink-500','bg-emerald-500','bg-amber-500','bg-cyan-500','bg-violet-500','bg-rose-500'];
    $avatarColor = $colors[crc32($comment->user->name) % count($colors)];
    $isOwner     = auth()->check() && auth()->id() === $comment->user_id;
    $isAdmin     = auth()->check() && in_array(auth()->user()->role, ['admin','superadmin']);
@endphp

<div class="flex gap-3 {{ $depth > 0 ? 'mt-4' : '' }}">

    {{-- Avatar --}}
    <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $avatarColor }} flex items-center justify-center text-white text-xs font-bold select-none">
        {{ $comment->initials }}
    </div>

    <div class="flex-1 min-w-0">

        {{-- Bubble --}}
        <div class="bg-gray-50 rounded-2xl rounded-tl-sm px-4 py-3">
            <div class="flex items-center justify-between gap-2 mb-1">
                <span class="text-sm font-semibold text-gray-900">{{ $comment->user->name }}</span>
                <span class="text-xs text-gray-400 whitespace-nowrap">{{ $comment->created_at->diffForHumans() }}</span>
            </div>

            {{-- Normal view --}}
            <div id="body-{{ $comment->id }}">
                <p class="text-sm text-gray-700 leading-relaxed break-words">{{ $comment->body }}</p>
            </div>

            {{-- Edit form (hidden) --}}
            @if ($isOwner)
                <div id="edit-form-{{ $comment->id }}" class="hidden mt-2">
                    <form method="POST" action="{{ route('hotel.comments.update', $comment->id) }}">
                        @csrf
                        @method('PUT')
                        <textarea name="body" rows="2" required maxlength="2000"
                                  class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700
                                         focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none transition">{{ $comment->body }}</textarea>
                        <div class="flex gap-2 mt-1.5">
                            <button type="submit"
                                    class="text-xs bg-black text-white px-4 py-1.5 rounded-lg hover:opacity-80 transition">
                                Simpan
                            </button>
                            <button type="button" onclick="toggleForm('edit-form-{{ $comment->id }}')"
                                    class="text-xs bg-gray-100 text-gray-600 px-4 py-1.5 rounded-lg hover:bg-gray-200 transition">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3 mt-1.5 px-1">

            {{-- Reply --}}
            @auth
                @if ($depth < 2)
                    <button onclick="toggleForm('reply-form-{{ $comment->id }}')"
                            class="text-xs text-gray-400 hover:text-indigo-600 transition font-medium">
                        Balas
                    </button>
                @endif
            @endauth

            {{-- Edit --}}
            @if ($isOwner)
                <button onclick="toggleForm('edit-form-{{ $comment->id }}')"
                        class="text-xs text-gray-400 hover:text-indigo-600 transition font-medium">
                    Edit
                </button>
            @endif

            {{-- Delete --}}
            @if ($isOwner || $isAdmin)
                <button onclick="confirmDelete('{{ route('hotel.comments.destroy', $comment->id) }}')"
                        class="text-xs text-gray-400 hover:text-red-500 transition font-medium">
                    Hapus
                </button>
            @endif

        </div>

        {{-- Reply form --}}
        @auth
            @if ($depth < 2)
                <div id="reply-form-{{ $comment->id }}" class="hidden mt-3">
                    <form method="POST" action="{{ route('hotel.comments.store', $hotel->id) }}">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <div class="flex gap-2">
                            <div class="flex-shrink-0 w-7 h-7 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xs font-bold select-none">
                                {{ collect(explode(' ', trim(auth()->user()->name)))->take(2)->map(fn($w) => strtoupper(mb_substr($w,0,1)))->join('') }}
                            </div>
                            <div class="flex-1">
                                <textarea name="body" rows="2" required maxlength="2000"
                                          placeholder="Tulis balasan..."
                                          class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700
                                                 focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none transition"></textarea>
                                <div class="flex gap-2 mt-1.5">
                                    <button type="submit"
                                            class="text-xs bg-black text-white px-4 py-1.5 rounded-lg hover:opacity-80 transition">
                                        Kirim
                                    </button>
                                    <button type="button" onclick="toggleForm('reply-form-{{ $comment->id }}')"
                                            class="text-xs bg-gray-100 text-gray-600 px-4 py-1.5 rounded-lg hover:bg-gray-200 transition">
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        @endauth

        {{-- Replies --}}
        @if ($comment->replies->isNotEmpty())
            <div class="mt-4 pl-4 border-l-2 border-gray-100 flex flex-col gap-4">
                @foreach ($comment->replies as $reply)
                    <div id="comment-{{ $reply->id }}">
                        @include('features.detail.hotel._comment-item', [
                            'comment' => $reply,
                            'hotel'   => $hotel,
                            'depth'   => $depth + 1,
                        ])
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>