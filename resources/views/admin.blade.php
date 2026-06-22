<x-sidebar-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    @php
        $user        = auth()->user();
        $isAdmin     = in_array($user->role, ['admin', 'superadmin']);
        $isCompany   = $user->role === 'company';
        $companyRole = $user->company_role ?? null; // 'destination' | 'restaurant' | 'hotel'

        $canDestination = $isAdmin || ($isCompany && $companyRole === 'destination');
        $canRestaurant  = $isAdmin || ($isCompany && $companyRole === 'restaurant');
        $canHotel       = $isAdmin || ($isCompany && $companyRole === 'hotel');
        $canArticle     = true; // semua role bisa lihat artikel
        $canUsers       = $isAdmin;
        $canCompanyReq  = $isAdmin;
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ══════════════════════════════════════════════════════════════
                 SECTION 1 — Summary Cards
                 Tiap card hanya muncul jika role punya akses
            ══════════════════════════════════════════════════════════════ --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">

                {{-- Total User — admin only --}}
                @if ($canUsers)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-blue-500 h-1.5 w-full"></div>
                        <div class="p-4">
                            <i class="bi bi-people-fill text-blue-500 text-2xl mb-1 block"></i>
                            <div class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_users']) }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">Total User</div>
                        </div>
                    </div>
                @endif

                {{-- Destinasi --}}
                @if ($canDestination)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-emerald-500 h-1.5 w-full"></div>
                        <div class="p-4">
                            <i class="bi bi-geo-alt-fill text-emerald-500 text-2xl mb-1 block"></i>
                            <div class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_destinations']) }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">Destinasi</div>
                        </div>
                    </div>
                @endif

                {{-- Hotel --}}
                @if ($canHotel)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-purple-500 h-1.5 w-full"></div>
                        <div class="p-4">
                            <i class="bi bi-building-fill text-purple-500 text-2xl mb-1 block"></i>
                            <div class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_hotels']) }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">Hotel</div>
                        </div>
                    </div>
                @endif

                {{-- Restoran --}}
                @if ($canRestaurant)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-orange-500 h-1.5 w-full"></div>
                        <div class="p-4">
                            <i class="bi bi-cup-hot-fill text-orange-500 text-2xl mb-1 block"></i>
                            <div class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_restaurants']) }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">Restoran</div>
                        </div>
                    </div>
                @endif

                {{-- Artikel — semua role --}}
                @if ($canArticle)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-rose-500 h-1.5 w-full"></div>
                        <div class="p-4">
                            <i class="bi bi-newspaper text-rose-500 text-2xl mb-1 block"></i>
                            <div class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_articles']) }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">Artikel</div>
                        </div>
                    </div>
                @endif

                {{-- Request Pending — admin only --}}
                @if ($canCompanyReq)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-yellow-500 h-1.5 w-full"></div>
                        <div class="p-4">
                            <i class="bi bi-hourglass-split text-yellow-500 text-2xl mb-1 block"></i>
                            <div class="text-2xl font-bold text-gray-800">{{ number_format($stats['pending_requests']) }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">Request Pending</div>
                        </div>
                    </div>
                @endif

            </div>

            {{-- ══════════════════════════════════════════════════════════════
                 SECTION 2 — Content Growth + User Growth
                 Content growth chart hanya tampil dataset yang relevan (diatur di JS)
                 User Growth hanya admin
            ══════════════════════════════════════════════════════════════ --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Content Growth Line — tampil ke semua, dataset disesuaikan role via JS flags --}}
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                        <i class="bi bi-graph-up-arrow text-blue-500"></i>
                        Pertumbuhan Konten (6 Bulan Terakhir)
                    </h3>
                    <div class="relative h-64">
                        <canvas id="contentGrowthChart"></canvas>
                    </div>
                </div>

                {{-- User Growth — admin only --}}
                @if ($canUsers)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                        <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                            <i class="bi bi-person-plus-fill text-blue-500"></i> Registrasi User Baru
                        </h3>
                        <div class="relative h-64">
                            <canvas id="userGrowthChart"></canvas>
                        </div>
                    </div>
                @else
                    {{-- Placeholder kosong biar layout tidak patah --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-center text-gray-300">
                        <div class="text-center">
                            <i class="bi bi-lock-fill text-4xl block mb-2"></i>
                            <p class="text-xs">Akses terbatas</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- ══════════════════════════════════════════════════════════════
                 SECTION 3 — Avg Ratings + Company Request (admin only)
            ══════════════════════════════════════════════════════════════ --}}

            {{-- Rata-rata Rating — hanya jika punya akses minimal 1 konten rated --}}
            @if ($canDestination || $canHotel || $canRestaurant)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                        <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                            <i class="bi bi-star-half text-amber-500"></i> Rata-rata Rating
                        </h3>
                        <div class="relative h-56">
                            <canvas id="avgRatingsChart"></canvas>
                        </div>
                    </div>

                    {{-- Company Request Status — admin only --}}
                    @if ($canCompanyReq)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                            <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                                <i class="bi bi-clipboard2-data-fill text-indigo-500"></i> Status Company Request
                            </h3>
                            <div class="relative h-56">
                                <canvas id="companyRequestChart"></canvas>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                            <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                                <i class="bi bi-pie-chart-fill text-orange-500"></i> Request per Bidang
                            </h3>
                            <div class="relative h-56">
                                <canvas id="companyFieldChart"></canvas>
                            </div>
                        </div>
                    @endif

                </div>
            @endif

            {{-- ══════════════════════════════════════════════════════════════
                 SECTION 4 — Top Rated Tables (per role)
            ══════════════════════════════════════════════════════════════ --}}
            @if ($canDestination || $canHotel || $canRestaurant)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    {{-- Top Destinasi --}}
                    @if ($canDestination)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                <i class="bi bi-geo-alt-fill text-emerald-500"></i> Top Destinasi
                            </h3>
                            <table class="w-full text-xs">
                                <thead>
                                    <tr class="text-gray-400 border-b">
                                        <th class="text-left pb-2 font-medium">Nama</th>
                                        <th class="text-right pb-2 font-medium">Rating</th>
                                        <th class="text-right pb-2 font-medium">Votes</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse ($topDestinations as $item)
                                        <tr>
                                            <td class="py-2 text-gray-700 truncate max-w-[120px]">{{ $item->title }}</td>
                                            <td class="py-2 text-right">
                                                <span class="inline-flex items-center gap-0.5 text-amber-500 font-semibold">
                                                    <i class="bi bi-star-fill"></i> {{ number_format($item->rating, 1) }}
                                                </span>
                                            </td>
                                            <td class="py-2 text-right text-gray-400">{{ $item->rating_count }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="py-4 text-center text-gray-400">Belum ada data</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif

                    {{-- Top Hotels --}}
                    @if ($canHotel)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                <i class="bi bi-building-fill text-purple-500"></i> Top Hotel
                            </h3>
                            <table class="w-full text-xs">
                                <thead>
                                    <tr class="text-gray-400 border-b">
                                        <th class="text-left pb-2 font-medium">Nama</th>
                                        <th class="text-right pb-2 font-medium">Rating</th>
                                        <th class="text-right pb-2 font-medium">Votes</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse ($topHotels as $item)
                                        <tr>
                                            <td class="py-2 text-gray-700 truncate max-w-[120px]">{{ $item->name }}</td>
                                            <td class="py-2 text-right">
                                                <span class="inline-flex items-center gap-0.5 text-amber-500 font-semibold">
                                                    <i class="bi bi-star-fill"></i> {{ number_format($item->rating, 1) }}
                                                </span>
                                            </td>
                                            <td class="py-2 text-right text-gray-400">{{ $item->rating_count }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="py-4 text-center text-gray-400">Belum ada data</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif

                    {{-- Top Restaurants --}}
                    @if ($canRestaurant)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                <i class="bi bi-cup-hot-fill text-orange-500"></i> Top Restoran
                            </h3>
                            <table class="w-full text-xs">
                                <thead>
                                    <tr class="text-gray-400 border-b">
                                        <th class="text-left pb-2 font-medium">Nama</th>
                                        <th class="text-right pb-2 font-medium">Rating</th>
                                        <th class="text-right pb-2 font-medium">Votes</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse ($topRestaurants as $item)
                                        <tr>
                                            <td class="py-2 text-gray-700 truncate max-w-[120px]">{{ $item->name }}</td>
                                            <td class="py-2 text-right">
                                                <span class="inline-flex items-center gap-0.5 text-amber-500 font-semibold">
                                                    <i class="bi bi-star-fill"></i> {{ number_format($item->rating, 1) }}
                                                </span>
                                            </td>
                                            <td class="py-2 text-right text-gray-400">{{ $item->rating_count }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="py-4 text-center text-gray-400">Belum ada data</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            @endif

            {{-- ══════════════════════════════════════════════════════════════
                 SECTION 5 — Banned Content (admin only)
            ══════════════════════════════════════════════════════════════ --}}
            @if ($isAdmin)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                        <i class="bi bi-slash-circle-fill text-red-500"></i> Konten yang Dibanned
                    </h3>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach ([
                            ['label' => 'Destinasi', 'value' => $bannedStats['destinations'], 'color' => 'text-emerald-600 bg-emerald-50', 'icon' => 'bi-geo-alt-fill'],
                            ['label' => 'Hotel',     'value' => $bannedStats['hotels'],       'color' => 'text-purple-600 bg-purple-50',  'icon' => 'bi-building-fill'],
                            ['label' => 'Restoran',  'value' => $bannedStats['restaurants'],  'color' => 'text-orange-600 bg-orange-50',  'icon' => 'bi-cup-hot-fill'],
                        ] as $b)
                            <div class="rounded-lg {{ $b['color'] }} px-4 py-3 flex items-center justify-between">
                                <span class="text-sm font-medium flex items-center gap-1.5">
                                    <i class="bi {{ $b['icon'] }}"></i> {{ $b['label'] }}
                                </span>
                                <span class="text-2xl font-bold">{{ $b['value'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ══════════════════════════════════════════════════════════════
                 Artikel-only notice — untuk role 'user' biasa
            ══════════════════════════════════════════════════════════════ --}}
            @if (!$isAdmin && !$isCompany)
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-5 flex items-start gap-3">
                    <i class="bi bi-info-circle-fill text-blue-400 text-xl mt-0.5"></i>
                    <div>
                        <p class="text-sm font-semibold text-blue-700">Dashboard terbatas</p>
                        <p class="text-xs text-blue-500 mt-0.5">
                            Anda login sebagai <strong>user</strong>. Hanya statistik artikel yang ditampilkan.
                            Daftar sebagai company untuk mengakses fitur penuh.
                        </p>
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- ─── Chart Data (JSON) + Role Flags untuk JS ──────────────────────── --}}
    <script>
        const contentGrowthData  = @json($contentGrowth);
        const avgRatingsData     = @json($avgRatings);
        const companyRequestData = @json($companyRequestChart);
        const companyFieldData   = @json($companyFieldChart);
        const userGrowthData     = @json($userGrowth);

        // Role flags — digunakan di admin-dashboard.js untuk filter dataset
        const roleFlags = {
            isAdmin:        {{ $isAdmin     ? 'true' : 'false' }},
            canDestination: {{ $canDestination ? 'true' : 'false' }},
            canHotel:       {{ $canHotel    ? 'true' : 'false' }},
            canRestaurant:  {{ $canRestaurant ? 'true' : 'false' }},
            canCompanyReq:  {{ $canCompanyReq ? 'true' : 'false' }},
        };
    </script>
</x-sidebar-app-layout>