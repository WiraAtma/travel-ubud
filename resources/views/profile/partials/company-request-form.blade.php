<form action="{{ route('company-request.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="space-y-5">

        {{-- Nama Perusahaan --}}
        <div>
            <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">
                Nama Perusahaan
            </label>
            <input type="text"
                   name="company_name"
                   id="company_name"
                   value="{{ old('company_name', auth()->user()->name) }}"
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                   placeholder="Nama perusahaan Anda">
            @error('company_name')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Bidang --}}
        <div>
            <label for="field" class="block text-sm font-medium text-gray-700 mb-2">
                Bidang yang Ditekuni
            </label>
            <select name="field"
                    id="field"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white">
                <option value="" disabled selected>Pilih bidang...</option>
                <option value="restaurant" {{ old('field') === 'restaurant' ? 'selected' : '' }}>Restoran</option>
                <option value="destination" {{ old('field') === 'destination' ? 'selected' : '' }}>Destinasi</option>
                <option value="hotel" {{ old('field') === 'hotel' ? 'selected' : '' }}>Hotel</option>
            </select>
            @error('field')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Alasan --}}
        <div>
            <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                Alasan Pengajuan
            </label>
            <textarea name="reason"
                      id="reason"
                      rows="4"
                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition resize-none"
                      placeholder="Jelaskan alasan Anda mengajukan sebagai akun perusahaan (min. 20 karakter)...">{{ old('reason') }}</textarea>
            @error('reason')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- File Bukti Dokumen --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Bukti Dokumen
            </label>

            {{-- Preview Box --}}
            <div id="proof-preview-wrapper" class="mb-3 hidden">
                <div id="proof-preview-img-wrap" class="hidden">
                    <img id="proof-preview-img"
                         src="#"
                         alt="Preview"
                         class="w-full max-h-48 object-cover rounded-xl border border-gray-200">
                </div>
                <div id="proof-preview-file"
                     class="hidden flex items-center gap-3 px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                    <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <div>
                        <p id="proof-file-name" class="text-sm font-medium text-gray-700"></p>
                        <p id="proof-file-size" class="text-xs text-gray-400"></p>
                    </div>
                </div>
            </div>

            <label for="proof_file"
                   class="flex items-center gap-3 px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-indigo-400 hover:bg-indigo-50 transition group">
                <svg class="w-6 h-6 text-gray-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                </svg>
                <div>
                    <p class="text-sm font-medium text-gray-600 group-hover:text-indigo-600">
                        Klik untuk pilih file bukti
                    </p>
                    <p class="text-xs text-gray-400">JPG, PNG, PDF, DOC, DOCX — maks. 5MB</p>
                </div>
            </label>
            <input type="file"
                   name="proof_file"
                   id="proof_file"
                   accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                   class="hidden">
            @error('proof_file')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

    </div>

    <div class="mt-6 flex justify-end">
        <button type="submit"
                class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition shadow-sm">
            Ajukan Sekarang
        </button>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const proofInput       = document.getElementById('proof_file');
    const previewWrapper   = document.getElementById('proof-preview-wrapper');
    const previewImgWrap   = document.getElementById('proof-preview-img-wrap');
    const previewImg       = document.getElementById('proof-preview-img');
    const previewFileWrap  = document.getElementById('proof-preview-file');
    const previewFileName  = document.getElementById('proof-file-name');
    const previewFileSize  = document.getElementById('proof-file-size');

    if (proofInput) {
        proofInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            previewWrapper.classList.remove('hidden');
            const isImage = file.type.startsWith('image/');
            const sizeMB  = (file.size / 1024 / 1024).toFixed(2);

            if (isImage) {
                previewFileWrap.classList.add('hidden');
                previewImgWrap.classList.remove('hidden');
                const reader = new FileReader();
                reader.onload = e => { previewImg.src = e.target.result; };
                reader.readAsDataURL(file);
            } else {
                previewImgWrap.classList.add('hidden');
                previewFileWrap.classList.remove('hidden');
                previewFileName.textContent = file.name;
                previewFileSize.textContent = sizeMB + ' MB';
            }
        });
    }
});
</script>
@endpush
