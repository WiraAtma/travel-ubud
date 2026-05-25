<x-sidebar-app-layout>
<div class="max-w-7xl mx-auto px-4 py-10">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Pengajuan Akun Perusahaan</h1>
        <p class="text-gray-500 mt-1">Kelola semua pengajuan mitra perusahaan</p>
    </div>

    @if (session('success'))
        <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter Status --}}
    <div class="flex items-center gap-2 mb-5">
        @php
            $filters = [
                'all'      => 'Semua',
                'pending'  => 'Menunggu',
                'approved' => 'Disetujui',
                'rejected' => 'Ditolak',
            ];
        @endphp
        @foreach ($filters as $value => $label)
            <a href="{{ route('admin.request-company', ['status' => $value]) }}"
               class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors duration-150
                      {{ $status === $value
                          ? 'bg-indigo-600 text-white'
                          : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100">
            @if ($requests->total() > 0)
                <span class="text-sm text-gray-500">
                    Menampilkan
                    <span class="font-semibold text-gray-700">{{ $requests->firstItem() }}</span>
                    –
                    <span class="font-semibold text-gray-700">{{ $requests->lastItem() }}</span>
                    dari
                    <span class="font-semibold text-gray-700">{{ $requests->total() }}</span>
                    pengajuan
                </span>
            @else
                <span class="text-sm text-gray-400">Tidak ada data pengajuan</span>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-medium w-14">No</th>
                        <th class="px-6 py-4 font-medium">Pemohon</th>
                        <th class="px-6 py-4 font-medium">Perusahaan</th>
                        <th class="px-6 py-4 font-medium">Bidang</th>
                        <th class="px-6 py-4 font-medium">Alasan</th>
                        <th class="px-6 py-4 font-medium">Bukti</th>
                        <th class="px-6 py-4 font-medium">Status</th>
                        <th class="px-6 py-4 font-medium">Tanggal</th>
                        <th class="px-6 py-4 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($requests as $index => $req)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">

                            <td class="px-6 py-4 text-gray-400 font-medium">
                                {{ $requests->firstItem() + $index }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-semibold text-sm uppercase shrink-0">
                                        {{ substr($req->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $req->user->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $req->user->email }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-gray-700 font-medium">
                                {{ $req->company_name }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 capitalize">
                                    {{ $req->fieldLabel() }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-gray-600 max-w-xs">
                                <p class="truncate" title="{{ $req->reason }}">{{ $req->reason }}</p>
                            </td>

                            <td class="px-6 py-4">
                                <a href="{{ route('admin.request-company.proof', $req) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-lg transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                    Lihat File
                                </a>
                            </td>

                            <td class="px-6 py-4">
                                @php
                                    $statusClass = match($req->status) {
                                        'pending'  => 'bg-yellow-100 text-yellow-700',
                                        'approved' => 'bg-green-100 text-green-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                        default    => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                    {{ $req->statusLabel() }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($req->created_at)->locale('id')->isoFormat('D MMM YYYY') }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($req->isPending())
                                    <div class="flex items-center gap-2">

                                        {{-- Setujui --}}
                                        <form action="{{ route('admin.request-company.approve', $req) }}"
                                              method="POST"
                                              onsubmit="return confirm('Setujui pengajuan dari {{ $req->user->name }}?')">
                                            @csrf
                                            <button type="submit"
                                                    class="px-3 py-1.5 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition">
                                                Setujui
                                            </button>
                                        </form>

                                        {{-- Tolak --}}
                                        <button type="button"
                                                onclick="openRejectModal({{ $req->id }}, '{{ $req->user->name }}')"
                                                class="px-3 py-1.5 text-xs font-medium text-white bg-red-500 hover:bg-red-600 rounded-lg transition">
                                            Tolak
                                        </button>

                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">Sudah diproses</span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-16 text-center text-gray-400">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-sm">Tidak ada pengajuan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($requests->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $requests->links() }}
            </div>
        @endif

    </div>
</div>

{{-- Modal Tolak --}}
<div id="reject-modal"
     class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-1">Tolak Pengajuan</h3>
        <p id="reject-modal-subtitle" class="text-sm text-gray-500 mb-4"></p>

        <form id="reject-form" method="POST">
            @csrf
            <div class="mb-4">
                <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                    Alasan Penolakan
                </label>
                <textarea name="rejection_reason"
                          id="rejection_reason"
                          rows="4"
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition resize-none"
                          placeholder="Jelaskan alasan penolakan pengajuan ini..."></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button"
                        onclick="closeRejectModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 rounded-lg transition">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-500 hover:bg-red-600 rounded-lg transition">
                    Konfirmasi Tolak
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openRejectModal(id, name) {
        const baseUrl = "{{ url('admin/request-company') }}";
        document.getElementById('reject-form').action = baseUrl + '/' + id + '/reject';
        document.getElementById('reject-modal-subtitle').textContent = 'Pengajuan dari: ' + name;
        document.getElementById('rejection_reason').value = '';
        document.getElementById('reject-modal').classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('reject-modal').classList.add('hidden');
    }

    // Tutup modal klik backdrop
    document.getElementById('reject-modal').addEventListener('click', function (e) {
        if (e.target === this) closeRejectModal();
    });
</script>
@endpush

</x-sidebar-app-layout>