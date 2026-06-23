<x-sidebar-app-layout>

  <div class="max-w-7xl mx-auto px-4 py-10">
  
      <div class="mb-8">
          <div class="flex items-center justify-between mb-4">
              <div>
                  <h1 class="text-3xl font-bold text-gray-800">Kelola Artikel</h1>
                  <p class="text-gray-500 mt-1">
                      {{ request()->routeIs('articles.all') ? 'Daftar semua artikel yang telah dibuat oleh seluruh pengguna' : 'Daftar artikel yang Anda buat' }}
                  </p>
              </div>
          </div>
          <div class="flex items-center justify-between gap-4">
              {{-- Search --}}
              <form action="{{ url()->current() }}" method="GET" class="flex items-center gap-2 w-full max-w-sm">
                  <div class="relative w-full">
                      <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                          <i class="bi bi-search"></i>
                      </span>
                      <input type="text" name="search" value="{{ request('search') }}"
                             placeholder="Cari"
                             class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" />
                  </div>
              </form>
              {{-- Tombol Buat --}}
              <a href="{{ route('articles.create') }}"
                 class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition whitespace-nowrap">
                  + Buat Post
              </a>
          </div>
      </div>
  
      {{-- Alert --}}
      @if (session('success'))
          <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
              {{ session('success') }}
          </div>
      @endif

      {{-- Tab Navigasi --}}
      @if (in_array(auth()->user()->role, ['admin', 'superadmin']))
      <div class="flex items-center gap-2 mb-6">
          <a href="{{ route('articles.index') }}"
             class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors duration-150
                    {{ request()->routeIs('articles.index')
                        ? 'bg-indigo-600 text-white'
                        : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
              Artikel Saya
          </a>
          <a href="{{ route('articles.all') }}"
             class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors duration-150
                    {{ request()->routeIs('articles.all')
                        ? 'bg-indigo-600 text-white'
                        : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
              Semua Artikel
          </a>
      </div>
      @endif
  
      {{-- Card Tabel --}}
      <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
  
          {{-- Info --}}
          <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
              @if ($articles->total() > 0)
                  <span class="text-sm text-gray-500">
                      Menampilkan
                      <span class="font-semibold text-gray-700">{{ $articles->firstItem() }}</span>
                      –
                      <span class="font-semibold text-gray-700">{{ $articles->lastItem() }}</span>
                      dari
                      <span class="font-semibold text-gray-700">{{ $articles->total() }}</span>
                      article
                  </span>
                  <span class="text-sm text-gray-400">
                      Halaman {{ $articles->currentPage() }} / {{ $articles->lastPage() }}
                  </span>
              @else
                  <span class="text-sm text-gray-400">Belum ada article</span>
              @endif
          </div>
  
          {{-- Tabel --}}
          <div class="overflow-x-auto">
              <div class="min-w-full inline-block align-middle">
                  <table class="min-w-full divide-y divide-gray-200">
                      <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                          <tr>
                              <th class="px-6 py-4 font-medium w-14">No</th>
                              <th class="px-6 py-4 font-medium">Cover</th>
                              <th class="px-6 py-4 font-medium">Judul</th>
                              <th class="px-6 py-4 font-medium">Author</th>
                              <th class="px-6 py-4 font-medium">Tanggal Dibuat</th>
                              <th class="px-6 py-4 font-medium">Terakhir Update</th>
                              <th class="px-6 py-4 font-medium text-center">Aksi</th>
                          </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-100">
                      @forelse ($articles as $index => $article)
                          <tr class="hover:bg-gray-50 transition-colors duration-150">

                              <td class="px-6 py-4 text-gray-400 font-medium">
                                  {{ $articles->firstItem() + $index }}
                              </td>

                              <td class="px-6 py-4">
                                  @if ($article->image_cover)
                                      <img src="{{ Storage::url($article->image_cover) }}"
                                           alt="cover"
                                           class="w-16 h-12 object-cover rounded-lg border border-gray-100">
                                  @else
                                      <div class="w-16 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                          <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01"/>
                                          </svg>
                                      </div>
                                  @endif
                              </td>

                              {{-- Judul --}}
                              <td class="px-6 py-4">
                                  <p class="font-medium text-gray-800 line-clamp-1 max-w-xs">{{ $article->title }}</p>
                              </td>

                              {{-- Author --}}
                              <td class="px-6 py-4">
                                  <div class="flex items-center gap-2">
                                      <div class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-semibold uppercase flex-shrink-0">
                                          {{ substr($article->author->name ?? '?', 0, 1) }}
                                      </div>
                                      <span class="text-gray-600">{{ $article->author->name ?? '-' }}</span>
                                  </div>
                              </td>

                              {{-- Tanggal Dibuat --}}
                              <td class="px-6 py-4 text-gray-600">
                                  {{ \Carbon\Carbon::parse($article->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                              </td>

                              {{-- Terakhir Update --}}
                              <td class="px-6 py-4 text-gray-600">
                                  {{ \Carbon\Carbon::parse($article->updated_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                              </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        @if ($article->banned)
                                            @if ($article->id_author === auth()->id())
                                                <span class="px-2.5 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-lg">Konten Terbanned</span>
                                            @else
                                                @if (in_array(auth()->user()->role, ['admin', 'superadmin']))
                                                    <form action="{{ route('articles.unban', $article) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="button"
                                                            onclick="confirmAction(this.closest('form'), 'Unban Artikel?', 'Artikel ini akan aktif kembali.', 'question', 'Ya, Unban!')"
                                                            class="px-3 py-1.5 text-xs font-medium text-green-600 bg-green-50 hover:bg-green-100 rounded-lg transition">Unban</button>
                                                    </form>
                                                    <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline">
                                                        @csrf @method('DELETE')
                                                        <button type="button"
                                                            onclick="confirmDelete(this.closest('form'), 'Artikel ini akan dihapus permanen!')"
                                                            class="px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition">Hapus</button>
                                                    </form>
                                                @else
                                                    <span class="text-xs text-gray-400 italic">No Access</span>
                                                @endif
                                            @endif
                                        @else
                                        @if ($article->id_author === auth()->id())
                                                <a href="{{ route('articles.detail', $article) }}"
                                                class="px-3 py-1.5 text-xs font-medium text-emerald-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">Detail</a>
                                                <a href="{{ route('articles.edit', $article) }}"
                                                class="px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">Edit</a>
                                                <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="button"
                                                        onclick="confirmDelete(this.closest('form'), 'Artikel ini akan dihapus permanen!')"
                                                        class="px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition">Hapus</button>
                                                </form>
                                            @elseif (in_array(auth()->user()->role, ['admin', 'superadmin']))
                                                <form action="{{ route('articles.ban', $article) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="button"
                                                        onclick="confirmAction(this.closest('form'), 'Ban Artikel?', 'Artikel ini akan disembunyikan dari publik.', 'warning', 'Ya, Ban!')"
                                                        class="px-3 py-1.5 text-xs font-medium text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition">Ban</button>
                                                </form>
                                                <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="button"
                                                        onclick="confirmDelete(this.closest('form'), 'Artikel ini akan dihapus permanen!')"
                                                        class="px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition">Hapus</button>
                                                </form>
                                            @else
                                                <span class="text-xs text-gray-400 italic">No Access</span>
                                            @endif
                                        @endif
                                    </div>
                                </td>

                          </tr>
                      @empty
                          <tr>
                              <td colspan="7" class="px-6 py-16 text-center text-gray-400">
                                  <p class="text-sm">Belum ada article. 
                                    <a href="{{ route('articles.create') }}" class="text-indigo-500 hover:underline">Buat sekarang</a></p>
                              </td>
                          </tr>
                      @endforelse
                  </tbody>
              </table>
          </div>
  
          {{-- Pagination --}}
          @if ($articles->hasPages())
              <div class="px-6 py-4 border-t border-gray-100">
                  {{ $articles->links() }}
              </div>
          @endif
  
      </div>
  </div>
</x-sidebar-app-layout>