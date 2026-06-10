<x-sidebar-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-10">

        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Kelola Users</h1>
                    <p class="text-gray-500 mt-1">Daftar semua pengguna yang terdaftar</p>
                </div>
            </div>
            <div class="flex items-center justify-between gap-4">
                {{-- Search --}}
                <form action="{{ route('users.page') }}" method="GET" class="flex items-center gap-2 w-full max-w-sm">
                    @if(request('role') && request('role') !== 'all')
                        <input type="hidden" name="role" value="{{ request('role') }}" />
                    @endif
                    <div class="relative w-full">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari"
                               class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" />
                    </div>
                </form>
            </div>
        </div>

        <div class="flex items-center gap-2 mb-4">
            @php
                $filters = [
                    'all'     => 'All',
                    'admin'   => 'Admin',
                    'user'    => 'User',
                    'company' => 'Company',
                ];
            @endphp

            @foreach ($filters as $value => $label)
                <a href="{{ route('users.page', ['role' => $value]) }}"
                   class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors duration-150
                          {{ $role === $value
                              ? 'bg-indigo-600 text-white'
                              : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            @if ($users->total() > 0)
                <span class="text-sm text-gray-500">
                    Menampilkan
                    <span class="font-semibold text-gray-700">{{ $users->firstItem() }}</span>
                    –
                    <span class="font-semibold text-gray-700">{{ $users->lastItem() }}</span>
                    dari
                    <span class="font-semibold text-gray-700">{{ $users->total() }}</span>
                    pengguna
                </span>
                <span class="text-sm text-gray-400">
                    Halaman {{ $users->currentPage() }} / {{ $users->lastPage() }}
                </span>
            @else
                <span class="text-sm text-gray-400">Tidak ada data pengguna</span>
            @endif

        </div>

            <div class="overflow-x-auto">
                <div class="min-w-full inline-block align-middle">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-6 py-4 font-medium w-14">No</th>
                                <th class="px-6 py-4 font-medium">Nama</th>
                                <th class="px-6 py-4 font-medium">Email</th>
                                <th class="px-6 py-4 font-medium">Role</th>
                                <th class="px-6 py-4 font-medium">Tanggal Dibuat</th>
                                <th class="px-6 py-4 font-medium">Terakhir di Update</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @forelse ($users as $index => $user)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">

                                <td class="px-6 py-4 text-gray-400 font-medium">
                                    {{ $users->firstItem() + $index }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-semibold text-sm uppercase shrink-0">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <span class="font-medium text-gray-800">{{ $user->name }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $user->email }}
                                </td>

                                <td class="px-6 py-4">
                                    @php
                                        $roleClass = match(strtolower($user->role)) {
                                            'admin'     => 'bg-red-100 text-red-700',
                                            'moderator' => 'bg-yellow-100 text-yellow-700',
                                            default     => 'bg-green-100 text-green-700',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {{ $roleClass }}">
                                        {{ $user->role }} 
                                        @if ($user->company_role !== null)
                                            - {{ $user->company_role }}
                                        @endif
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ \Carbon\Carbon::parse($user->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ \Carbon\Carbon::parse($user->updated_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <p class="text-sm">Belum ada data pengguna</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $users->links() }}
                </div>
            @endif

        </div>
</x-sidebar-app-layout>
