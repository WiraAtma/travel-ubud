@php
    $cr         = auth()->user()->latestCompanyRequest;
    $isPending  = $cr?->isPending();
    $isRejected = $cr?->isRejected();
    $isApproved = $cr?->isApproved();
@endphp

<section class="rounded-2xl shadow-sm overflow-hidden">

    <div class="px-6 py-5">
        <h2 class="text-lg font-semibold text-gray-800">Pengajuan Akun Perusahaan</h2>
        <p class="text-sm text-gray-500 mt-0.5">Ajukan akun Anda sebagai mitra perusahaan kami</p>
    </div>

    <div class="p-6">

        {{-- SUDAH DISETUJUI --}}
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

        {{-- DITOLAK — tampilkan alasan + form ulang --}}
        @elseif ($isRejected)
            <div class="mb-5 px-4 py-3 bg-red-50 border border-red-200 rounded-xl">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-red-700">Pengajuan Ditolak</p>
                        <p class="text-xs text-red-600 mt-0.5">{{ $cr->rejection_reason }}</p>
                    </div>
                </div>
            </div>

            {{-- Form Ajukan Ulang --}}
            @include('profile.partials.company-request-form')

        {{-- PENDING — tampilkan data read-only --}}
        @elseif ($isPending)
            <div class="mb-5 flex items-center gap-3 px-4 py-3 bg-yellow-50 border border-yellow-200 rounded-xl">
                <svg class="w-5 h-5 text-yellow-500 shrink-0 animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 14H11v-2h2v2zm0-4H11V7h2v5z"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-yellow-700">Pengajuan Sedang Diproses</p>
                    <p class="text-xs text-yellow-600 mt-0.5">Silakan tunggu konfirmasi dari admin kami.</p>
                </div>
            </div>

            {{-- Data read-only --}}
            <div class="space-y-4">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Nama Perusahaan</p>
                    <p class="text-sm text-gray-800 font-medium">{{ $cr->company_name }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Bidang</p>
                    <p class="text-sm text-gray-800 font-medium">{{ $cr->fieldLabel() }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Alasan</p>
                    <p class="text-sm text-gray-800">{{ $cr->reason }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">File Bukti</p>
                    <p class="text-sm text-gray-600 italic">File telah diunggah</p>
                </div>
            </div>

            {{-- Tombol Batalkan --}}
            <div class="mt-6 pt-4 border-t border-gray-100">
                <form action="{{ route('company-request.cancel') }}" method="POST"
                      onsubmit="return confirm('Yakin ingin membatalkan pengajuan?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-red-600 bg-red-50 border border-red-200 hover:bg-red-100 rounded-lg transition">
                        Batalkan Pengajuan
                    </button>
                </form>
            </div>

        {{-- BELUM PERNAH AJUKAN --}}
        @else
            @include('profile.partials.company-request-form')
        @endif

    </div>
</section>