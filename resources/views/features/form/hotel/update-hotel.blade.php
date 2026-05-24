<x-sidebar-app-layout>

<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Edit Hotel</h1>
            <p class="text-gray-500 mt-1">Perbarui informasi hotel</p>
        </div>
        <a href="{{ route('hotels.index') }}"
           class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
            ← Kembali
        </a>
    </div>

    <form action="{{ route('hotels.update', $hotel) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- ========== INFORMASI UTAMA ========== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-700">Informasi Hotel</h2>
            </div>
            <div class="p-6 space-y-5">

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Hotel</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $hotel->name) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $hotel->address) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $hotel->phone) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="start_price" class="block text-sm font-medium text-gray-700 mb-2">Harga Mulai (Rp)</label>
                        <input type="number" name="start_price" id="start_price" value="{{ old('start_price', $hotel->start_price) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" min="0">
                        @error('start_price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="checkin_time" class="block text-sm font-medium text-gray-700 mb-2">Jam Check-in</label>
                        <input type="time" name="checkin_time" id="checkin_time" value="{{ old('checkin_time', \Carbon\Carbon::parse($hotel->checkin_time)->format('H:i')) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        @error('checkin_time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="checkout_time" class="block text-sm font-medium text-gray-700 mb-2">Jam Check-out</label>
                        <input type="time" name="checkout_time" id="checkout_time" value="{{ old('checkout_time', \Carbon\Carbon::parse($hotel->checkout_time)->format('H:i')) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        @error('checkout_time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Fasilitas Hotel --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Fasilitas Hotel
                        <span class="text-gray-400 font-normal">(tekan Enter atau koma untuk menambah)</span>
                    </label>
                    <div id="facilities-wrapper"
                         class="min-h-[46px] flex flex-wrap gap-2 px-3 py-2 border border-gray-300 rounded-lg cursor-text focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition">
                        @foreach (old('facilities', $hotel->facilities ?? []) as $fac)
                            <span class="facility-tag flex items-center gap-1 px-2.5 py-1 bg-indigo-100 text-indigo-700 text-sm rounded-full">
                                {{ $fac }}
                                <input type="hidden" name="facilities[]" value="{{ $fac }}">
                                <button type="button" onclick="removeTag(this)" class="text-indigo-400 hover:text-indigo-700 leading-none">&times;</button>
                            </span>
                        @endforeach
                        <input type="text" id="facility-input"
                               class="flex-1 min-w-[150px] outline-none text-sm bg-transparent"
                               placeholder="Tambah fasilitas...">
                    </div>
                    @error('facilities') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Cover Hotel --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Sampul Hotel</label>
                    <div id="hotel-cover-preview-wrapper" class="{{ $hotel->image_cover ? '' : 'hidden' }} mb-3">
                        <img id="hotel-cover-preview"
                             src="{{ $hotel->image_cover ? Storage::url($hotel->image_cover) : '#' }}"
                             alt="Preview" class="w-full max-h-64 object-cover rounded-xl border border-gray-200">
                    </div>
                    <label for="image_cover"
                           class="flex items-center gap-3 px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-indigo-400 hover:bg-indigo-50 transition group">
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-gray-600 group-hover:text-indigo-600">
                                {{ $hotel->image_cover ? 'Ganti gambar sampul' : 'Pilih gambar sampul' }}
                            </p>
                            <p class="text-xs text-gray-400">JPG, JPEG, PNG, WEBP — maks. 2MB</p>
                        </div>
                    </label>
                    <input type="file" name="image_cover" id="image_cover" accept="image/*" class="hidden">
                    @error('image_cover') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Deskripsi Hotel (Summernote) --}}
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Hotel
                    </label>
                    <textarea name="description" id="content">{{ old('description', $hotel->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Catatan --}}
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <textarea name="notes" id="notes" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition resize-none">{{ old('notes', $hotel->notes) }}</textarea>
                    @error('notes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

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

            <div id="rooms-container" class="divide-y divide-gray-100">

                {{-- Render kamar existing dari DB --}}
                @foreach ($hotel->rooms as $room)
                <div class="p-6 relative" data-room-idx="existing-{{ $room->id }}">
                    <input type="hidden" name="rooms[existing-{{ $room->id }}][id]" value="{{ $room->id }}">

                    <button type="button" onclick="removeRoom(this)"
                            class="absolute top-4 right-5 text-gray-300 hover:text-red-500 transition text-lg font-bold leading-none">&times;</button>

                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Kamar #<span class="room-number"></span></h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-4">

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Nama Kamar</label>
                            <input type="text" name="rooms[existing-{{ $room->id }}][name]"
                                   value="{{ old("rooms.existing-{$room->id}.name", $room->name) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Maks. Tamu</label>
                            <input type="number" name="rooms[existing-{{ $room->id }}][max_guests]"
                                   value="{{ old("rooms.existing-{$room->id}.max_guests", $room->max_guests) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" min="1" required>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Harga / Malam (Rp)</label>
                            <input type="number" name="rooms[existing-{{ $room->id }}][price]"
                                   value="{{ old("rooms.existing-{$room->id}.price", $room->price) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" min="0" required>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Gambar Kamar</label>
                            <div id="room-cover-preview-wrapper-existing-{{ $room->id }}" class="{{ $room->image_cover ? '' : 'hidden' }} mb-2">
                                <img id="room-cover-preview-existing-{{ $room->id }}"
                                     src="{{ $room->image_cover ? Storage::url($room->image_cover) : '#' }}"
                                     class="w-full max-h-32 object-cover rounded-lg border border-gray-200">
                            </div>
                            <label for="room-cover-input-existing-{{ $room->id }}"
                                   class="flex items-center gap-2 px-3 py-2 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-indigo-400 hover:bg-indigo-50 transition text-xs text-gray-500 hover:text-indigo-600">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01"/>
                                </svg>
                                {{ $room->image_cover ? 'Ganti gambar' : 'Pilih gambar kamar' }}
                            </label>
                            <input type="file" id="room-cover-input-existing-{{ $room->id }}"
                                   name="rooms[existing-{{ $room->id }}][image_cover]"
                                   accept="image/*" class="hidden"
                                   onchange="previewRoomCover(this, 'existing-{{ $room->id }}')">
                        </div>
                    </div>

                    {{-- Fasilitas Kamar --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">
                            Fasilitas Kamar <span class="text-gray-400">(tekan Enter atau koma)</span>
                        </label>
                        <div id="room-fac-wrapper-existing-{{ $room->id }}"
                             class="min-h-[42px] flex flex-wrap gap-2 px-3 py-2 border border-gray-300 rounded-lg cursor-text focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition"
                             onclick="document.getElementById('room-fac-input-existing-{{ $room->id }}').focus()">
                            @foreach (old("rooms.existing-{$room->id}.facilities", $room->facilities ?? []) as $fac)
                                <span class="facility-tag flex items-center gap-1 px-2.5 py-1 bg-indigo-100 text-indigo-700 text-sm rounded-full">
                                    {{ $fac }}
                                    <input type="hidden" name="rooms[existing-{{ $room->id }}][facilities][]" value="{{ $fac }}">
                                    <button type="button" onclick="removeTag(this)" class="text-indigo-400 hover:text-indigo-700 leading-none">&times;</button>
                                </span>
                            @endforeach
                            <input type="text" id="room-fac-input-existing-{{ $room->id }}"
                                   class="flex-1 min-w-[140px] outline-none text-sm bg-transparent"
                                   placeholder="Tambah fasilitas..."
                                   onkeydown="handleRoomFacKey(event, 'existing-{{ $room->id }}')">
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

            @if ($hotel->rooms->isEmpty())
            <div id="rooms-empty" class="px-6 py-10 text-center text-gray-400 text-sm">
                Belum ada kamar. Klik <strong>+ Tambah Kamar</strong> untuk menambahkan.
            </div>
            @else
            <div id="rooms-empty" class="hidden"></div>
            @endif
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('hotels.index') }}"
               class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 rounded-lg transition">
                Batal
            </a>
            <button type="submit"
                    class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition">
                Update Hotel
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Summernote ───────────────────────────────────────────────
    $('#content').summernote({
      height: 400,
      minHeight: 300,
      followingToolbar: false,
      dialogsInBody: true,
      placeholder: 'Tulis deskripsi lengkap hotel di sini...',
      toolbar: [
        ['style',    ['style']],
        ['font',     ['bold', 'underline', 'italic', 'strikethrough', 'clear']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['color',    ['color']],
        ['para',     ['ul', 'ol', 'paragraph']],
        ['table',    ['table']],
        ['insert',   ['link', 'picture', 'video', 'hr']],
        ['view',     ['fullscreen', 'codeview', 'undo', 'redo', 'help']],
      ],
      fontNames: ['Arial','Comic Sans MS','Courier New','Georgia','Tahoma','Times New Roman','Verdana','Inter','Poppins'],
      fontSizes: ['10','11','12','13','14','15','16','18','20','22','24','28','32','36','48'],
      styleTags: [
        'p',
        { title: 'Heading 1', tag: 'h1', className: '', value: 'h1' },
        { title: 'Heading 2', tag: 'h2', className: '', value: 'h2' },
        { title: 'Heading 3', tag: 'h3', className: '', value: 'h3' },
        'blockquote', 'pre',
      ],
      callbacks: {
        onImageUpload: function (files) {
          const editor = this;
          Array.from(files).forEach(file => {
            const formData = new FormData();
            formData.append('file', file);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            fetch('/admin/hotel/upload-image', { method: 'POST', body: formData })
              .then(r => r.json())
              .then(data => { if (data.url) $(editor).summernote('insertImage', data.url); })
              .catch(() => alert('Gagal upload gambar.'));
          });
        },
      },
    });

    let editorScrollTop = 0;
    $(document).on('mousedown', '.note-toolbar, .note-dropdown-menu, .note-popover', function () {
      const editable = $('.note-editable');
      if (editable.length) editorScrollTop = editable.scrollTop();
    });
    $(document).on('click', '.note-toolbar, .note-dropdown-menu, .note-popover', function () {
      const editable = $('.note-editable');
      if (editable.length) {
        const cached = editorScrollTop;
        setTimeout(() => editable.scrollTop(cached), 10);
      }
    });

    // ── Cover Hotel preview ──────────────────────────────────────
    document.getElementById('image_cover').addEventListener('change', function () {
        previewImage(this, 'hotel-cover-preview', 'hotel-cover-preview-wrapper');
    });

    // ── Facilities Hotel tag input ───────────────────────────────
    const facilityInput   = document.getElementById('facility-input');
    const facilityWrapper = document.getElementById('facilities-wrapper');

    facilityWrapper.addEventListener('click', () => facilityInput.focus());
    facilityInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            addFacilityTag(this.value.trim(), facilityWrapper, 'facilities[]');
            this.value = '';
        }
        if (e.key === 'Backspace' && this.value === '') {
            const tags = facilityWrapper.querySelectorAll('.facility-tag');
            if (tags.length) tags[tags.length - 1].remove();
        }
    });

    // ── Rooms ────────────────────────────────────────────────────
    let newRoomCounter = 0;
    const roomsContainer = document.getElementById('rooms-container');
    const roomsEmpty     = document.getElementById('rooms-empty');

    document.getElementById('add-room-btn').addEventListener('click', () => {
        const idx = 'new-' + (newRoomCounter++);
        addRoomBlock(idx);
        roomsEmpty.classList.add('hidden');
        renumberRooms();
    });

    renumberRooms(); // number existing rooms on load

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

    function addFacilityTag(value, wrapper, nameAttr) {
        if (!value) return;
        const input = wrapper.querySelector('input[type=text]');
        const span  = document.createElement('span');
        span.className = 'facility-tag flex items-center gap-1 px-2.5 py-1 bg-indigo-100 text-indigo-700 text-sm rounded-full';
        span.innerHTML = `
            ${value}
            <input type="hidden" name="${nameAttr}" value="${value}">
            <button type="button" onclick="removeTag(this)" class="text-indigo-400 hover:text-indigo-700 leading-none">&times;</button>
        `;
        wrapper.insertBefore(span, input);
    }

    function addRoomBlock(idx) {
        const block = document.createElement('div');
        block.className = 'p-6 relative border-t border-gray-100';
        block.dataset.roomIdx = idx;

        block.innerHTML = `
            <button type="button" onclick="removeRoom(this)"
                    class="absolute top-4 right-5 text-gray-300 hover:text-red-500 transition text-lg font-bold leading-none">&times;</button>

            <h3 class="text-sm font-semibold text-gray-700 mb-4">Kamar #<span class="room-number"></span></h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Nama Kamar</label>
                    <input type="text" name="rooms[${idx}][name]"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Maks. Tamu</label>
                    <input type="number" name="rooms[${idx}][max_guests]" min="1"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Harga / Malam (Rp)</label>
                    <input type="number" name="rooms[${idx}][price]" min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Gambar Kamar</label>
                    <div id="room-cover-preview-wrapper-${idx}" class="mb-2 hidden">
                        <img id="room-cover-preview-${idx}" src="#"
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
                           onchange="previewRoomCover(this, '${idx}')">
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
                           placeholder="Contoh: AC, TV..."
                           onkeydown="handleRoomFacKey(event, '${idx}')">
                </div>
            </div>
        `;

        roomsContainer.appendChild(block);
    }

    // Expose globally
    window.removeTag = function (btn) {
        btn.closest('.facility-tag').remove();
    };

    window.removeRoom = function (btn) {
        btn.closest('[data-room-idx]').remove();
        renumberRooms();
        if (!roomsContainer.querySelector('[data-room-idx]')) {
            roomsEmpty.classList.remove('hidden');
        }
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
            const value = input.value.trim();
            if (!value) return;
            const span = document.createElement('span');
            span.className = 'facility-tag flex items-center gap-1 px-2.5 py-1 bg-indigo-100 text-indigo-700 text-sm rounded-full';
            span.innerHTML = `
                ${value}
                <input type="hidden" name="rooms[${idx}][facilities][]" value="${value}">
                <button type="button" onclick="removeTag(this)" class="text-indigo-400 hover:text-indigo-700 leading-none">&times;</button>
            `;
            wrapper.insertBefore(span, input);
            input.value = '';
        }
        if (e.key === 'Backspace' && input.value === '') {
            const tags = wrapper.querySelectorAll('.facility-tag');
            if (tags.length) tags[tags.length - 1].remove();
        }
    };

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