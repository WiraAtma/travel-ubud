@php
    $profileUser = $user ?? auth()->user();
    $cr         = $profileUser->latestCompanyRequest;
    $isPending  = $cr?->isPending();
    $isRejected = $cr?->isRejected();
    $isApproved = $cr?->isApproved();
    
    // Melacak seluruh riwayat pengajuan milik user
    $allRequests = $profileUser->companyRequests ?? collect();
    $activeRequests = $isApproved
        ? collect()
        : $allRequests->reject(fn ($request) => $request->isApproved());
@endphp

<div class="space-y-8">
    
    {{-- CARD UTAMA STATUS PENGAJUAN --}}
    <section class="rounded-2xl border border-gray-200 overflow-hidden bg-white">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-lg font-semibold text-gray-800">Pengajuan Akun Perusahaan</h2>
            <p class="text-sm text-gray-500 mt-0.5">Ajukan akun Anda sebagai mitra perusahaan kami</p>
        </div>

        <div class="p-6">
            {{-- STATUS: DISETUJUI --}}
            @if ($isApproved)
                <div class="flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 rounded-xl">
                    <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-green-700">Pengajuan Disetujui</p>
                        <p class="text-xs text-green-600 mt-0.5">Akun Anda telah resmi terdaftar sebagai perusahaan.</p>
                    </div>
                </div>

            {{-- STATUS: DITOLAK (Menampilkan Banner Alert + Form Ajukan Ulang) --}}
            @elseif ($isRejected)
                <div class="mb-6 px-4 py-3 bg-red-50 border border-red-200 rounded-xl">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-red-700">Pengajuan Terakhir Ditolak</p>
                            <p class="text-xs text-red-600 mt-1">
                                Alasan Penolakan: <span class="font-bold text-red-800">{{ $cr->rejection_reason }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Container Form Ajukan Ulang --}}
                <div class="max-w-xl border-t border-gray-100 pt-6">
                    <p class="text-sm font-medium text-gray-700 mb-4">Silakan perbaiki dokumen/data Anda lalu ajukan kembali:</p>
                    <div id="wrapper-form-submit">
                        @include('profile.partials.company-request-form')
                    </div>
                </div>

            {{-- STATUS: PENDING (Read-only Detail) --}}
            @elseif ($isPending)
                <div class="mb-5 flex items-center gap-3 px-4 py-3 bg-yellow-50 border border-yellow-200 rounded-xl">
                    <svg class="w-5 h-5 text-yellow-500 shrink-0 animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 14H11v-2h2v2zm0-4H11V7h2v5z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-yellow-700">Pengajuan Sedang Diproses</p>
                        <p class="text-xs text-yellow-600 mt-0.5">Silakan tunggu konfirmasi peninjauan dari admin kami.</p>
                    </div>
                </div>

                <div class="space-y-4 max-w-xl bg-gray-50 p-4 rounded-xl border border-gray-150">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Nama Perusahaan</p>
                        <p class="text-sm text-gray-800 font-medium mt-0.5">{{ $cr->company_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Bidang Kategori</p>
                        <p class="text-sm text-gray-800 font-medium mt-0.5">{{ $cr->fieldLabel() }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Alasan Pengajuan</p>
                        <p class="text-sm text-gray-800 mt-0.5 leading-relaxed">{{ $cr->reason }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Berkas Bukti</p>
                        <p class="text-sm text-gray-600 italic mt-0.5 flex items-center gap-1.5 text-green-600">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span> Dokumen Berhasil Diunggah
                        </p>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100 max-w-xl">
                    {{-- Form Batalkan Pengajuan (onsubmit diganti pemicu SweetAlert) --}}
                    <form id="cancel-request-form" action="{{ route('company-request.cancel') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmCancelRequest()"
                                class="px-4 py-2 text-sm font-medium text-red-600 bg-red-50 border border-red-200 hover:bg-red-100 rounded-lg transition">
                            Batalkan Pengajuan
                        </button>
                    </form>
                </div>

            {{-- STATUS: BELUM PERNAH AJUKAN SAMA SEKALI --}}
            @else
                <div class="max-w-xl" id="wrapper-form-submit">
                    @include('profile.partials.company-request-form')
                </div>
            @endif
        </div>
    </section>

    {{-- TABEL LIST RIWAYAT PENGAJUAN (HISTORY LOG) --}}
    @if($allRequests && $allRequests->isNotEmpty())
        <section class="rounded-2xl border border-gray-200 overflow-hidden bg-white shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/70">
                <h3 class="text-sm font-semibold text-gray-800">Riwayat Pengajuan Rekam Jejak</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-150 bg-gray-50/30">
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Perusahaan</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Bidang</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($allRequests as $item)
                            <tr class="hover:bg-gray-50/40 transition">
                                <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                    {{ $item->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                    {{ $item->company_name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $item->fieldLabel() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item->isApproved())
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium text-green-700 bg-green-50 border border-green-200 rounded-lg">
                                            Disetujui
                                        </span>
                                    @elseif($item->isRejected())
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium text-red-700 bg-red-50 border border-red-200 rounded-lg cursor-help" 
                                              title="Alasan: {{ $item->rejection_reason ?: 'Tidak ada alasan penolakan.' }}">
                                            Ditolak
                                        </span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium text-yellow-700 bg-yellow-50 border border-yellow-200 rounded-lg">
                                            Menunggu
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    @endif

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Intersepsi Form Submit Pengajuan Mitra Baru / Ulang
        const formSubmitContainer = document.getElementById('wrapper-form-submit');
        if (formSubmitContainer) {
            const form = formSubmitContainer.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Tahan submit bawaan HTML
                    
                    Swal.fire({
                        title: 'Ajukan Akun Perusahaan?',
                        text: "Pastikan data dan dokumen yang Anda masukkan sudah benar.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#4f46e5', // Indigo Tailwind
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Ajukan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Teruskan submit jika user setuju
                        }
                    });
                });
            }
        }
    });

    // 2. Fungsi Konfirmasi Batalkan Pengajuan
    function confirmCancelRequest() {
        const cancelForm = document.getElementById('cancel-request-form');
        if (cancelForm) {
            Swal.fire({
                title: 'Batalkan Pengajuan?',
                text: "Apakah Anda yakin ingin membatalkan pengajuan akun perusahaan ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', // Merah Tailwind
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    cancelForm.submit();
                }
            });
        }
    }
</script>
@endpush