<x-sidebar-app-layout>

  <div class="max-w-7xl mx-auto px-4 py-10">

      <div class="mb-8">
          <div class="flex items-center justify-between mb-4">
              <div>
                  <h1 class="text-3xl font-bold text-gray-800">Kelola Destinasi</h1>
                  <p class="text-gray-500 mt-1">
                      {{ request()->routeIs('destinations.all') ? 'Daftar semua destinasi yang telah dibuat oleh seluruh pengguna' : 'Daftar destinasi yang Anda buat' }}
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
                             placeholder="Cari destinasi..."
                             class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" />
                  </div>
              </form>
              {{-- Tombol Buat --}}
              <a href="{{ route('destinations.create') }}"
                 class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition whitespace-nowrap">
                  + Buat Destinasi
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
          <a href="{{ route('destinations.index') }}"
             class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors duration-150
                    {{ request()->routeIs('destinations.index')
                        ? 'bg-indigo-600 text-white'
                        : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
              Destinasi Saya
          </a>
          <a href="{{ route('destinations.all') }}"
             class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors duration-150
                    {{ request()->routeIs('destinations.all')
                        ? 'bg-indigo-600 text-white'
                        : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
              Semua Destinasi
          </a>
      </div>
      @endif

      {{-- Card Tabel --}}
      <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

          {{-- Info --}}
          <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
              @if ($destinations->total() > 0)
                  <span class="text-sm text-gray-500">
                      Menampilkan
                      <span class="font-semibold text-gray-700">{{ $destinations->firstItem() }}</span>
                      –
                      <span class="font-semibold text-gray-700">{{ $destinations->lastItem() }}</span>
                      dari
                      <span class="font-semibold text-gray-700">{{ $destinations->total() }}</span>
                      destinasi
                  </span>
                  <span class="text-sm text-gray-400">
                      Halaman {{ $destinations->currentPage() }} / {{ $destinations->lastPage() }}
                  </span>
              @else
                  <span class="text-sm text-gray-400">Belum ada destinasi</span>
              @endif
          </div>

          {{-- Tabel --}}
          <div class="overflow-x-auto">
              <table class="w-full text-sm text-left">
                  <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                      <tr>
                          <th class="px-6 py-4 font-medium w-14">No</th>
                          <th class="px-6 py-4 font-medium">Cover</th>
                          <th class="px-6 py-4 font-medium">Judul</th>
                          <th class="px-6 py-4 font-medium">Lokasi</th>
                          <th class="px-6 py-4 font-medium">Kategori</th>
                          <th class="px-6 py-4 font-medium">Rating</th>
                          <th class="px-6 py-4 font-medium">Author</th>
                          <th class="px-6 py-4 font-medium">Tanggal Dibuat</th>
                          <th class="px-6 py-4 font-medium text-center">Aksi</th>
                      </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-100">
                      @forelse ($destinations as $index => $destination)
                          <tr class="hover:bg-gray-50 transition-colors duration-150">

                              <td class="px-6 py-4 text-gray-400 font-medium">
                                  {{ $destinations->firstItem() + $index }}
                              </td>

                              {{-- Cover --}}
                              <td class="px-6 py-4">
                                  @if ($destination->image_cover)
                                      <img src="{{ Storage::url($destination->image_cover) }}"
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
                                  <p class="font-medium text-gray-800 line-clamp-1 max-w-xs">{{ $destination->title }}</p>
                              </td>

                              {{-- Lokasi --}}
                              <td class="px-6 py-4 text-gray-600">
                                  <div class="flex items-center gap-1">
                                      <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                      </svg>
                                      <span class="text-xs line-clamp-1 max-w-[120px]">{{ $destination->location }}</span>
                                  </div>
                              </td>

                              {{-- Kategori --}}
                              <td class="px-6 py-4">
                                  <div class="flex flex-wrap gap-1 max-w-[160px]">
                                      @foreach ((array) $destination->categories as $cat)
                                          <span class="px-2 py-0.5 text-xs bg-indigo-50 text-indigo-600 rounded-full">{{ $cat }}</span>
                                      @endforeach
                                  </div>
                              </td>

                              {{-- Rating --}}
                              <td class="px-6 py-4">
                                  <div class="flex items-center gap-1">
                                      <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                      </svg>
                                      <span class="text-sm font-medium text-gray-700">{{ number_format($destination->rating, 1) }}</span>
                                      <span class="text-xs text-gray-400">({{ $destination->rating_count }})</span>
                                  </div>
                              </td>

                              {{-- Author --}}
                              <td class="px-6 py-4">
                                  <div class="flex items-center gap-2">
                                      <div class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-semibold uppercase flex-shrink-0">
                                          {{ substr($destination->author->name ?? '?', 0, 1) }}
                                      </div>
                                      <span class="text-gray-600">{{ $destination->author->name ?? '-' }}</span>
                                  </div>
                              </td>

                              {{-- Tanggal --}}
                              <td class="px-6 py-4 text-gray-600 text-xs">
                                  {{ \Carbon\Carbon::parse($destination->created_at)->locale('id')->isoFormat('D MMM YYYY') }}
                              </td>

                              {{-- Aksi --}}
                              <td class="px-6 py-4 text-center">
                                  <div class="flex items-center justify-center gap-2">
                                      @if ($destination->banned)
                                          @if ($destination->id_author === auth()->id())
                                              <span class="px-2.5 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-lg">
                                                  Konten Terbanned
                                              </span>
                                          @else
                                              @if (in_array(auth()->user()->role, ['admin', 'superadmin']))
                                                  <form action="{{ route('destinations.unban', $destination) }}" method="POST" class="inline">
                                                      @csrf
                                                      <button type="submit" class="px-3 py-1.5 text-xs font-medium text-green-600 bg-green-50 hover:bg-green-100 rounded-lg transition">
                                                          Unban
                                                      </button>
                                                  </form>
                                                  <form action="{{ route('destinations.destroy', $destination) }}" method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus destinasi ini?')">
                                                      @csrf
                                                      @method('DELETE')
                                                      <button type="submit" class="px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition">
                                                          Hapus
                                                      </button>
                                                  </form>
                                              @else
                                                  <span class="text-xs text-gray-400 italic">No Access</span>
                                              @endif
                                          @endif
                                      @else
                                          @if ($destination->id_author === auth()->id())
                                              <a href="{{ route('destinations.edit', $destination) }}"
                                                 class="px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                                                  Edit
                                              </a>
                                              <form action="{{ route('destinations.destroy', $destination) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus destinasi ini?')">
                                                  @csrf
                                                  @method('DELETE')
                                                  <button type="submit" class="px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition">
                                                      Hapus
                                                  </button>
                                              </form>
                                          @elseif (in_array(auth()->user()->role, ['admin', 'superadmin']))
                                              <form action="{{ route('destinations.ban', $destination) }}" method="POST" class="inline">
                                                  @csrf
                                                  <button type="submit" class="px-3 py-1.5 text-xs font-medium text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition">
                                                      Ban
                                                  </button>
                                              </form>
                                              <form action="{{ route('destinations.destroy', $destination) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus destinasi ini?')">
                                                  @csrf
                                                  @method('DELETE')
                                                  <button type="submit" class="px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition">
                                                      Hapus
                                                  </button>
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
                              <td colspan="9" class="px-6 py-16 text-center text-gray-400">
                                  <p class="text-sm">Belum ada destinasi.
                                      <a href="{{ route('destinations.create') }}" class="text-indigo-500 hover:underline">Buat sekarang</a>
                                  </p>
                              </td>
                          </tr>
                      @endforelse
                  </tbody>
              </table>
          </div>

          {{-- Pagination --}}
          @if ($destinations->hasPages())
              <div class="px-6 py-4 border-t border-gray-100">
                  {{ $destinations->links() }}
              </div>
          @endif

      </div>
  </div>

</x-sidebar-app-layout>