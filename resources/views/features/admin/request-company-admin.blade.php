<x-sidebar-app-layout>
<div class="max-w-7xl mx-auto px-4 py-10">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Pengajuan Akun Perusahaan</h1>
        <p class="text-gray-500 mt-1">Kelola semua pengajuan mitra perusahaan</p>
    </div>

    {{-- Alert Flash Message menggunakan SweetAlert --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 2500
                });
            });
        </script>
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
            <div class="min-w-full inline-block align-middle">
                <table class="min-w-full divide-y divide-gray-200">
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

                                        {{-- Setujui (Sekarang pakai SweetAlert) --}}
                                        <form action="{{ route('admin.request-company.approve', $req) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="button"
                                                    onclick="confirmApprove(this.closest('form'), '{{ $req->user->name }}')"
                                                    class="px-3 py-1.5 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition">
                                                Setujui
                                            </button>
                                        </form>

                                        {{-- Tolak (Sekarang pakai SweetAlert Input tanpa modal HTML ribet) --}}
                                        <form id="reject-form-{{ $req->id }}" action="{{ route('admin.request-company.reject', $req) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="rejection_reason" id="reason-hidden-{{ $req->id }}">
                                            <button type="button"
                                                    onclick="confirmReject({{ $req->id }}, '{{ $req->user->name }}')"
                                                    class="px-3 py-1.5 text-xs font-medium text-white bg-red-500 hover:bg-red-600 rounded-lg transition">
                                                Tolak
                                            </button>
                                        </form>

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

@push('scripts')
{{-- CDN SweetAlert2 (jika belum dimasukkan di layout utama kamu) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Fungsi Konfirmasi Setuju
    function confirmApprove(form, name) {
        Swal.fire({
            title: 'Setujui Pengajuan?',
            text: `Apakah Anda yakin ingin menyetujui pengajuan akun dari ${name}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#16a34a', // Hijau Tailwind
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Setujui!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }

    // Fungsi Konfirmasi Tolak dengan Form Input dari SweetAlert langsung
    function confirmReject(id, name) {
        Swal.fire({
            title: 'Tolak Pengajuan',
            text: `Masukkan alasan penolakan untuk pengajuan dari: ${name}`,
            icon: 'warning',
            input: 'textarea',
            inputPlaceholder: 'Jelaskan alasan penolakan di sini...',
            inputAttributes: {
                'aria-label': 'Jelaskan alasan penolakan di sini'
            },
            showCancelButton: true,
            confirmButtonColor: '#ef4444', // Merah Tailwind
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Konfirmasi Tolak',
            cancelButtonText: 'Batal',
            inputValidator: (value) => {
                if (!value) {
                    return 'Alasan penolakan tidak boleh kosong!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Isi input hidden dengan alasan dari SweetAlert lalu submit form
                document.getElementById('reason-hidden-' + id).value = result.value;
                document.getElementById('reject-form-' + id).submit();
            }
        });
    }
</script>
@endpush

</x-sidebar-app-layout>