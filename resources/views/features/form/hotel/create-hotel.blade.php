<x-sidebar-app-layout>

<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Tambah Hotel Baru</h1>
        <p class="text-gray-500 mt-1">Lengkapi informasi hotel dan kamar yang tersedia</p>
    </div>

    <form action="{{ route('hotels.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- ========== INFORMASI UTAMA ========== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-700">Informasi Hotel</h2>
            </div>
            <div class="p-6 space-y-5">

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Hotel</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="Contoh: The Mulia Resort">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <input type="text" name="address" id="address" value="{{ old('address') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="Contoh: Jl. Raya Nusa Dua Selatan, Badung, Bali">
                    @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                               placeholder="Contoh: 0361-123456">
                        @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="start_price" class="block text-sm font-medium text-gray-700 mb-2">Harga Mulai (Rp)</label>
                        <input type="number" name="start_price" id="start_price" value="{{ old('start_price') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                               placeholder="Contoh: 500000" min="0">
                        @error('start_price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="checkin_time" class="block text-sm font-medium text-gray-700 mb-2">Jam Check-in</label>
                        <input type="time" name="checkin_time" id="checkin_time" value="{{ old('checkin_time', '14:00') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        @error('checkin_time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="checkout_time" class="block text-sm font-medium text-gray-700 mb-2">Jam Check-out</label>
                        <input type="time" name="checkout_time" id="checkout_time" value="{{ old('checkout_time', '12:00') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        @error('checkout_time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Fasilitas Hotel
                        <span class="text-gray-400 font-normal">(tekan Enter atau koma untuk menambah)</span>
                    </label>
                    <div id="facilities-wrapper"
                         class="min-h-[46px] flex flex-wrap gap-2 px-3 py-2 border border-gray-300 rounded-lg cursor-text focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition">
                        @foreach (old('facilities', []) as $fac)
                            <span class="facility-tag flex items-center gap-1 px-2.5 py-1 bg-indigo-100 text-indigo-700 text-sm rounded-full">
                                {{ $fac }}
                                <input type="hidden" name="facilities[]" value="{{ $fac }}">
                                <button type="button" onclick="removeTag(this)" class="text-indigo-400 hover:text-indigo-700 leading-none">&times;</button>
                            </span>
                        @endforeach
                        <input type="text" id="facility-input"
                               class="flex-1 min-w-[150px] outline-none text-sm bg-transparent"
                               placeholder="Contoh: WiFi, Pool, Spa...">
                    </div>
                    @error('facilities') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Sampul Hotel</label>
                    <div id="hotel-cover-preview-wrapper" class="mb-3 hidden">
                        <img id="hotel-cover-preview" src="#" alt="Preview"
                             class="w-full max-h-64 object-cover rounded-xl border border-gray-200">
                    </div>
                    <label for="image_cover"
                           class="flex items-center gap-3 px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-indigo-400 hover:bg-indigo-50 transition group">
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-gray-600 group-hover:text-indigo-600">Klik untuk pilih gambar sampul hotel</p>
                            <p class="text-xs text-gray-400">JPG, JPEG, PNG, WEBP — maks. 2MB</p>
                        </div>
                    </label>
                    <input type="file" name="image_cover" id="image_cover" accept="image/*" class="hidden">
                    @error('image_cover') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Hotel</label>
                    <textarea name="description" id="content">{{ old('description') }}</textarea>
                    @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <textarea name="notes" id="notes" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition resize-none"
                              placeholder="Informasi tambahan, kebijakan hotel, dll.">{{ old('notes') }}</textarea>
                    @error('notes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

            </div>
        </div>

        {{-- ========== LINKS (LINKTREE STYLE) ========== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-semibold text-gray-700">Tautan Hotel</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Tambahkan link penting (Booking, Instagram, Maps, dll.)</p>
                </div>
                <button type="button" id="add-link-btn"
                        class="px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                    + Tambah Tautan
                </button>
            </div>

            {{-- Preview linktree --}}
            <div id="links-preview-bar" class="hidden px-6 pt-4">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-3">Preview Tampilan</p>
                <div id="links-preview-list" class="flex flex-wrap gap-2 mb-4"></div>
                <hr class="border-gray-100">
            </div>

            <div id="links-container" class="divide-y divide-gray-100"></div>

            <div id="links-empty" class="px-6 py-10 text-center text-gray-400 text-sm">
                Belum ada tautan. Klik <strong>+ Tambah Tautan</strong> untuk menambahkan link hotel.
            </div>
        </div>

        {{-- ========== KAMAR ========== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-base font-semibold text-gray-700">Pilihan Kamar</h2>
                <button type="button" id="add-room-btn"
                        class="px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                    + Tambah Kamar
                </button>
            </div>
            <div id="rooms-container" class="divide-y divide-gray-100"></div>
            <div id="rooms-empty" class="px-6 py-10 text-center text-gray-400 text-sm">
                Belum ada kamar. Klik <strong>+ Tambah Kamar</strong> untuk menambahkan pilihan kamar.
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('hotels.index') }}"
               class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 rounded-lg transition">
                Batal
            </a>
            <button type="submit"
                    class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition">
                Simpan Hotel
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Summernote ───────────────────────────────────────────────
    $('#content').summernote({
      height: 400, minHeight: 300, followingToolbar: false, dialogsInBody: true,
      placeholder: 'Tulis deskripsi lengkap hotel di sini...',
      toolbar: [
        ['style', ['style']], ['font', ['bold','underline','italic','strikethrough','clear']],
        ['fontname', ['fontname']], ['fontsize', ['fontsize']], ['color', ['color']],
        ['para', ['ul','ol','paragraph']], ['table', ['table']],
        ['insert', ['link','picture','video','hr']], ['view', ['fullscreen','codeview','undo','redo','help']],
      ],
      callbacks: {
        onImageUpload: function (files) {
          const editor = this;
          Array.from(files).forEach(file => {
            const fd = new FormData();
            fd.append('file', file);
            fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            fetch('/admin/hotel/upload-image', { method: 'POST', body: fd })
              .then(r => r.json()).then(d => { if (d.url) $(editor).summernote('insertImage', d.url); })
              .catch(() => alert('Gagal upload gambar.'));
          });
        },
      },
    });

    // ── Cover Hotel preview ──────────────────────────────────────
    document.getElementById('image_cover').addEventListener('change', function () {
        previewImage(this, 'hotel-cover-preview', 'hotel-cover-preview-wrapper');
    });

    // ── Facilities tag input ─────────────────────────────────────
    const facilityInput   = document.getElementById('facility-input');
    const facilityWrapper = document.getElementById('facilities-wrapper');
    facilityWrapper.addEventListener('click', () => facilityInput.focus());
    facilityInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            addFacilityTag(this.value.trim(), facilityWrapper);
            this.value = '';
        }
        if (e.key === 'Backspace' && this.value === '') {
            const tags = facilityWrapper.querySelectorAll('.facility-tag');
            if (tags.length) tags[tags.length - 1].remove();
        }
    });

    // ── Links ─────────────────────────────────────────────────────
    let linkIndex = 0;
    const linksContainer  = document.getElementById('links-container');
    const linksEmpty      = document.getElementById('links-empty');
    const linksPreviewBar = document.getElementById('links-preview-bar');
    const linksPreviewList= document.getElementById('links-preview-list');

    document.getElementById('add-link-btn').addEventListener('click', () => {
        addLinkBlock(linkIndex++);
        linksEmpty.classList.add('hidden');
        linksPreviewBar.classList.remove('hidden');
    });

    // ── Rooms ────────────────────────────────────────────────────
    let roomIndex = 0;
    const roomsContainer = document.getElementById('rooms-container');
    const roomsEmpty     = document.getElementById('rooms-empty');
    document.getElementById('add-room-btn').addEventListener('click', () => {
        addRoomBlock(roomIndex++);
        roomsEmpty.classList.add('hidden');
    });

    // ── Helpers ──────────────────────────────────────────────────
    function previewImage(input, previewId, wrapperId) {
        const file = input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById(previewId).src = e.target.result;
            document.getElementById(wrapperId).classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }

    function addFacilityTag(value, wrapper, namePrefix = 'facilities[]') {
        if (!value) return;
        const span = document.createElement('span');
        span.className = 'facility-tag flex items-center gap-1 px-2.5 py-1 bg-indigo-100 text-indigo-700 text-sm rounded-full';
        span.innerHTML = `${value}<input type="hidden" name="${namePrefix}" value="${value}">
            <button type="button" onclick="removeTag(this)" class="text-indigo-400 hover:text-indigo-700 leading-none">&times;</button>`;
        wrapper.insertBefore(span, wrapper.querySelector('input[type=text]'));
    }

    // ── Link block ────────────────────────────────────────────────
    function addLinkBlock(idx) {
        const block = document.createElement('div');
        block.className = 'p-6 relative';
        block.dataset.linkIdx = idx;

        block.innerHTML = `
            <button type="button" onclick="removeLink(this)"
                    class="absolute top-4 right-5 text-gray-300 hover:text-red-500 transition text-lg font-bold leading-none" title="Hapus tautan">&times;</button>

            <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
                Tautan #<span class="link-number"></span>
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-4">

                {{-- Nama Label --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Nama Tautan</label>
                    <input type="text" name="links[${idx}][label]"
                           class="link-label-input w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="Contoh: Instagram, Booking.com, Google Maps"
                           oninput="updateLinkPreview(${idx})" required>
                </div>

                {{-- URL --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">URL Tautan</label>
                    <input type="url" name="links[${idx}][url]"
                           class="link-url-input w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="https://..."
                           oninput="updateLinkPreview(${idx})" required>
                </div>

                {{-- Cover Link --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Cover Tautan
                        <span class="text-gray-400 font-normal">(opsional — thumbnail/logo link)</span>
                    </label>
                    <div class="flex items-center gap-4">
                        {{-- Thumbnail preview bulat (linktree-style) --}}
                        <div id="link-thumb-wrapper-${idx}"
                             class="w-14 h-14 rounded-xl border-2 border-dashed border-gray-200 flex items-center justify-center bg-gray-50 overflow-hidden flex-shrink-0 transition">
                            <svg id="link-thumb-placeholder-${idx}" class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01"/>
                            </svg>
                            <img id="link-thumb-img-${idx}" src="#" alt="Cover" class="hidden w-full h-full object-cover">
                        </div>
                        <label for="link-cover-input-${idx}"
                               class="flex-1 flex items-center gap-2 px-3 py-2 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-indigo-400 hover:bg-indigo-50 transition text-xs text-gray-500 hover:text-indigo-600">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01"/>
                            </svg>
                            Pilih cover/logo tautan (maks. 2MB)
                        </label>
                        <input type="file" id="link-cover-input-${idx}" name="links[${idx}][image_cover]"
                               accept="image/*" class="hidden"
                               onchange="previewLinkCover(this, ${idx})">
                    </div>
                </div>
            </div>
        `;

        linksContainer.appendChild(block);
        renumberLinks();

        // Buat entry preview
        const preview = document.createElement('div');
        preview.id = `link-preview-chip-${idx}`;
        preview.className = 'flex items-center gap-2 px-3 py-1.5 bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs rounded-full max-w-[180px] truncate';
        preview.innerHTML = `
            <span id="link-preview-icon-${idx}" class="w-5 h-5 rounded-full bg-indigo-200 flex-shrink-0 overflow-hidden flex items-center justify-center">
                <svg class="w-3 h-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
            </span>
            <span id="link-preview-label-${idx}" class="truncate">Tautan #${idx + 1}</span>
        `;
        linksPreviewList.appendChild(preview);
    }

    // ── Room block ────────────────────────────────────────────────
    function addRoomBlock(idx) {
        const block = document.createElement('div');
        block.className = 'p-6 relative';
        block.dataset.roomIdx = idx;

        block.innerHTML = `
            <button type="button" onclick="removeRoom(this)"
                    class="absolute top-4 right-5 text-gray-300 hover:text-red-500 transition text-lg font-bold leading-none">&times;</button>
            <h3 class="text-sm font-semibold text-gray-700 mb-4">Kamar #<span class="room-number"></span></h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Nama Kamar</label>
                    <input type="text" name="rooms[${idx}][name]"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="Contoh: Deluxe Room" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Maks. Tamu</label>
                    <input type="number" name="rooms[${idx}][max_guests]" min="1"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="Contoh: 2" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Harga / Malam (Rp)</label>
                    <input type="number" name="rooms[${idx}][price]" min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="Contoh: 750000" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Gambar Kamar</label>
                    <div id="room-cover-preview-wrapper-${idx}" class="mb-2 hidden">
                        <img id="room-cover-preview-${idx}" src="#" alt="Preview Kamar"
                             class="w-full max-h-32 object-cover rounded-lg border border-gray-200">
                    </div>
                    <label for="room-cover-input-${idx}"
                           class="flex items-center gap-2 px-3 py-2 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-indigo-400 hover:bg-indigo-50 transition text-xs text-gray-500 hover:text-indigo-600">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01"/>
                        </svg>
                        Pilih gambar kamar (maks. 2MB)
                    </label>
                    <input type="file" id="room-cover-input-${idx}" name="rooms[${idx}][image_cover]"
                           accept="image/*" class="hidden"
                           onchange="previewRoomCover(this, ${idx})">
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">
                    Fasilitas Kamar <span class="text-gray-400">(tekan Enter atau koma)</span>
                </label>
                <div id="room-fac-wrapper-${idx}"
                     class="min-h-[42px] flex flex-wrap gap-2 px-3 py-2 border border-gray-300 rounded-lg cursor-text focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition"
                     onclick="document.getElementById('room-fac-input-${idx}').focus()">
                    <input type="text" id="room-fac-input-${idx}"
                           class="flex-1 min-w-[140px] outline-none text-sm bg-transparent"
                           placeholder="Contoh: AC, TV, Balcony..."
                           onkeydown="handleRoomFacKey(event, ${idx})">
                </div>
            </div>
        `;

        roomsContainer.appendChild(block);
        renumberRooms();
    }

    // ── Global handlers ───────────────────────────────────────────
    window.removeTag = (btn) => btn.closest('.facility-tag').remove();

    window.removeLink = function (btn) {
        const block = btn.closest('[data-link-idx]');
        const idx   = parseInt(block.dataset.linkIdx);
        block.remove();
        document.getElementById(`link-preview-chip-${idx}`)?.remove();
        renumberLinks();
        if (!linksContainer.querySelector('[data-link-idx]')) {
            linksEmpty.classList.remove('hidden');
            linksPreviewBar.classList.add('hidden');
        }
    };

    window.removeRoom = function (btn) {
        btn.closest('[data-room-idx]').remove();
        renumberRooms();
        if (!roomsContainer.querySelector('[data-room-idx]')) {
            roomsEmpty.classList.remove('hidden');
        }
    };

    window.updateLinkPreview = function (idx) {
        const block = linksContainer.querySelector(`[data-link-idx="${idx}"]`);
        if (!block) return;
        const label = block.querySelector('.link-label-input')?.value?.trim() || `Tautan #${idx + 1}`;
        const chip  = document.getElementById(`link-preview-chip-${idx}`);
        if (chip) {
            const labelEl = document.getElementById(`link-preview-label-${idx}`);
            if (labelEl) labelEl.textContent = label;
        }
    };

    window.previewLinkCover = function (input, idx) {
        const file = input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById(`link-thumb-img-${idx}`);
            const placeholder = document.getElementById(`link-thumb-placeholder-${idx}`);
            if (img && placeholder) {
                img.src = e.target.result;
                img.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            // Update preview chip icon
            const iconEl = document.getElementById(`link-preview-icon-${idx}`);
            if (iconEl) {
                iconEl.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover" alt="">`;
            }
        };
        reader.readAsDataURL(file);
    };

    window.previewRoomCover = function (input, idx) {
        const file = input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById(`room-cover-preview-${idx}`).src = e.target.result;
            document.getElementById(`room-cover-preview-wrapper-${idx}`).classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    };

    window.handleRoomFacKey = function (e, idx) {
        const input   = document.getElementById(`room-fac-input-${idx}`);
        const wrapper = document.getElementById(`room-fac-wrapper-${idx}`);
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            addFacilityTag(input.value.trim(), wrapper, `rooms[${idx}][facilities][]`);
            input.value = '';
        }
        if (e.key === 'Backspace' && input.value === '') {
            const tags = wrapper.querySelectorAll('.facility-tag');
            if (tags.length) tags[tags.length - 1].remove();
        }
    };

    function renumberLinks() {
        linksContainer.querySelectorAll('[data-link-idx]').forEach((block, i) => {
            const num = block.querySelector('.link-number');
            if (num) num.textContent = i + 1;
        });
    }

    function renumberRooms() {
        roomsContainer.querySelectorAll('[data-room-idx]').forEach((block, i) => {
            const num = block.querySelector('.room-number');
            if (num) num.textContent = i + 1;
        });
    }
});
</script>
@endpush

</x-sidebar-app-layout>