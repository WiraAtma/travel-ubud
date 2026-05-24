<x-sidebar-app-layout>

<div class="max-w-7xl mx-auto px-4 py-10">

    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Kelola Restoran</h1>
                <p class="text-gray-500 mt-1">
                    {{ request()->routeIs('restaurants.all') ? 'Daftar semua restoran dari seluruh pengguna' : 'Daftar restoran yang Anda kelola' }}
                </p>
            </div>
        </div>
        <div class="flex items-center justify-between gap-4">
            <form action="{{ url()->current() }}" method="GET" class="flex items-center gap-2 w-full max-w-sm">
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari restoran..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" />
                </div>
            </form>
            <a href="{{ route('restaurants.create') }}"
               class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition whitespace-nowrap">
                + Tambah Restoran
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if (in_array(auth()->user()->role, ['admin', 'superadmin']))
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('restaurants.index') }}"
           class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors duration-150
                  {{ request()->routeIs('restaurants.index') ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            Restoran Saya
        </a>
        <a href="{{ route('restaurants.all') }}"
           class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors duration-150
                  {{ request()->routeIs('restaurants.all') ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            Semua Restoran
        </a>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            @if ($restaurants->total() > 0)
                <span class="text-sm text-gray-500">
                    Menampilkan
                    <span class="font-semibold text-gray-700">{{ $restaurants->firstItem() }}</span>
                    –
                    <span class="font-semibold text-gray-700">{{ $restaurants->lastItem() }}</span>
                    dari
                    <span class="font-semibold text-gray-700">{{ $restaurants->total() }}</span>
                    restoran
                </span>
                <span class="text-sm text-gray-400">Halaman {{ $restaurants->currentPage() }} / {{ $restaurants->lastPage() }}</span>
            @else
                <span class="text-sm text-gray-400">Belum ada restoran</span>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-medium w-12">No</th>
                        <th class="px-6 py-4 font-medium">Cover</th>
                        <th class="px-6 py-4 font-medium">Nama Restoran</th>
                        <th class="px-6 py-4 font-medium">Kategori</th>
                        <th class="px-6 py-4 font-medium">Jam Buka</th>
                        <th class="px-6 py-4 font-medium">Harga Mulai</th>
                        <th class="px-6 py-4 font-medium">Rating</th>
                        <th class="px-6 py-4 font-medium">Author</th>
                        <th class="px-6 py-4 font-medium text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($restaurants as $index => $restaurant)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">

                            <td class="px-6 py-4 text-gray-400 font-medium">
                                {{ $restaurants->firstItem() + $index }}
                            </td>

                            {{-- Cover --}}
                            <td class="px-6 py-4">
                                @if ($restaurant->image_cover)
                                    <img src="{{ Storage::url($restaurant->image_cover) }}"
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

                            {{-- Nama --}}
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-800 line-clamp-1 max-w-[180px]">{{ $restaurant->name }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $restaurant->phone }}</p>
                            </td>

                            {{-- Kategori --}}
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs bg-orange-50 text-orange-600 rounded-full font-medium">
                                    {{ $restaurant->category }}
                                </span>
                            </td>

                            {{-- Jam Buka --}}
                            <td class="px-6 py-4 text-gray-600 text-xs whitespace-nowrap">
                                <div class="flex flex-col gap-0.5">
                                    <span><span class="text-green-600 font-medium">Buka</span> {{ \Carbon\Carbon::parse($restaurant->open_time)->format('H:i') }}</span>
                                    <span><span class="text-red-500 font-medium">Tutup</span> {{ \Carbon\Carbon::parse($restaurant->close_time)->format('H:i') }}</span>
                                </div>
                            </td>

                            {{-- Harga Mulai --}}
                            <td class="px-6 py-4 text-gray-700 font-medium whitespace-nowrap">
                                Rp {{ number_format($restaurant->start_price, 0, ',', '.') }}
                            </td>

                            {{-- Rating --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700">{{ number_format($restaurant->rating, 1) }}</span>
                                    <span class="text-xs text-gray-400">({{ $restaurant->rating_count }})</span>
                                </div>
                            </td>

                            {{-- Author --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-semibold uppercase flex-shrink-0">
                                        {{ substr($restaurant->author->name ?? '?', 0, 1) }}
                                    </div>
                                    <span class="text-gray-600 text-xs">{{ $restaurant->author->name ?? '-' }}</span>
                                </div>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    @if ($restaurant->banned)
                                        @if ($restaurant->id_author === auth()->id())
                                            <span class="px-2.5 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-lg">Terbanned</span>
                                        @else
                                            @if (in_array(auth()->user()->role, ['admin', 'superadmin']))
                                                <form action="{{ route('restaurants.unban', $restaurant) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1.5 text-xs font-medium text-green-600 bg-green-50 hover:bg-green-100 rounded-lg transition">Unban</button>
                                                </form>
                                                <form action="{{ route('restaurants.destroy', $restaurant) }}" method="POST"
                                                      onsubmit="return confirm('Yakin ingin menghapus restoran ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition">Hapus</button>
                                                </form>
                                            @else
                                                <span class="text-xs text-gray-400 italic">No Access</span>
                                            @endif
                                        @endif
                                    @else
                                        @if ($restaurant->id_author === auth()->id())
                                            <a href="{{ route('restaurants.edit', $restaurant) }}"
                                               class="px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                                                Edit
                                            </a>
                                            <form action="{{ route('restaurants.destroy', $restaurant) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus restoran ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition">Hapus</button>
                                            </form>
                                        @elseif (in_array(auth()->user()->role, ['admin', 'superadmin']))
                                            <form action="{{ route('restaurants.ban', $restaurant) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 text-xs font-medium text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition">Ban</button>
                                            </form>
                                            <form action="{{ route('restaurants.destroy', $restaurant) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus restoran ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition">Hapus</button>
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
                                <p class="text-sm">Belum ada restoran.
                                    <a href="{{ route('restaurants.create') }}" class="text-indigo-500 hover:underline">Tambah sekarang</a>
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($restaurants->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $restaurants->links() }}
            </div>
        @endif

    </div>
</div>

</x-sidebar-app-layout>