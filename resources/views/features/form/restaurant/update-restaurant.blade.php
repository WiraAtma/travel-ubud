<x-sidebar-app-layout>

<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Edit Restoran</h1>
            <p class="text-gray-500 mt-1">Perbarui informasi restoran</p>
        </div>
        <a href="{{ route('restaurants.index') }}"
           class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
            ← Kembali
        </a>
    </div>

    <form action="{{ route('restaurants.update', $restaurant) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- ========== INFORMASI UTAMA ========== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-700">Informasi Restoran</h2>
            </div>
            <div class="p-6 space-y-5">

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Restoran</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $restaurant->name) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $restaurant->address) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $restaurant->phone) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori Masakan</label>
                        <select name="category" id="category"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category', $restaurant->category) === $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                        @error('category') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label for="start_price" class="block text-sm font-medium text-gray-700 mb-2">Harga Mulai (Rp)</label>
                        <input type="number" name="start_price" id="start_price"
                               value="{{ old('start_price', $restaurant->start_price) }}" min="0"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        @error('start_price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="open_time" class="block text-sm font-medium text-gray-700 mb-2">Jam Buka</label>
                        <input type="time" name="open_time" id="open_time"
                               value="{{ old('open_time', \Carbon\Carbon::parse($restaurant->open_time)->format('H:i')) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        @error('open_time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="close_time" class="block text-sm font-medium text-gray-700 mb-2">Jam Tutup</label>
                        <input type="time" name="close_time" id="close_time"
                               value="{{ old('close_time', \Carbon\Carbon::parse($restaurant->close_time)->format('H:i')) }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        @error('close_time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Cover --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Sampul Restoran</label>
                    <div id="cover-preview-wrapper" class="{{ $restaurant->image_cover ? '' : 'hidden' }} mb-3">
                        <img id="cover-preview"
                             src="{{ $restaurant->image_cover ? Storage::url($restaurant->image_cover) : '#' }}"
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
                                {{ $restaurant->image_cover ? 'Ganti gambar sampul' : 'Pilih gambar sampul' }}
                            </p>
                            <p class="text-xs text-gray-400">JPG, JPEG, PNG, WEBP — maks. 2MB</p>
                        </div>
                    </label>
                    <input type="file" name="image_cover" id="image_cover" accept="image/*" class="hidden">
                    @error('image_cover') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Deskripsi (Summernote) --}}
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Restoran</label>
                    <textarea name="description" id="content">{{ old('description', $restaurant->description) }}</textarea>
                    @error('description') <p class="mt-1 text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>

                {{-- Catatan --}}
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <textarea name="notes" id="notes" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition resize-none">{{ old('notes', $restaurant->notes) }}</textarea>
                    @error('notes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

            </div>
        </div>

        {{-- ========== MENU ========== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-base font-semibold text-gray-700">Daftar Menu</h2>
                <button type="button" id="add-menu-btn"
                        class="px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                    + Tambah Menu
                </button>
            </div>

            <div id="menus-container" class="divide-y divide-gray-100">

                {{-- Menu existing dari DB --}}
                @foreach ($restaurant->menus as $menu)
                <div class="p-6 relative" data-menu-idx="existing-{{ $menu->id }}">
                    <input type="hidden" name="menus[existing-{{ $menu->id }}][id]" value="{{ $menu->id }}">

                    <button type="button" onclick="removeMenu(this)"
                            class="absolute top-4 right-5 text-gray-300 hover:text-red-500 transition text-lg font-bold leading-none">&times;</button>

                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Menu #<span class="menu-number"></span></h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Nama Menu</label>
                            <input type="text" name="menus[existing-{{ $menu->id }}][name]"
                                   value="{{ old("menus.existing-{$menu->id}.name", $menu->name) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 transition" required>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Kategori Menu</label>
                            <select name="menus[existing-{{ $menu->id }}][category]"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 transition bg-white" required>
                                @foreach ($menuCategories as $mc)
                                    <option value="{{ $mc }}"
                                        {{ old("menus.existing-{$menu->id}.category", $menu->category) === $mc ? 'selected' : '' }}>
                                        {{ $mc }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Harga (Rp)</label>
                            <input type="number" name="menus[existing-{{ $menu->id }}][price]" min="0"
                                   value="{{ old("menus.existing-{$menu->id}.price", $menu->price) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 transition" required>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Foto Menu</label>
                            <div id="menu-img-wrapper-existing-{{ $menu->id }}" class="{{ $menu->image ? '' : 'hidden' }} mb-2">
                                <img id="menu-img-preview-existing-{{ $menu->id }}"
                                     src="{{ $menu->image ? Storage::url($menu->image) : '#' }}"
                                     class="w-full max-h-28 object-cover rounded-lg border border-gray-200">
                            </div>
                            <label for="menu-img-input-existing-{{ $menu->id }}"
                                   class="flex items-center gap-2 px-3 py-2 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-indigo-400 hover:bg-indigo-50 transition text-xs text-gray-500 hover:text-indigo-600">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01"/>
                                </svg>
                                {{ $menu->image ? 'Ganti foto' : 'Pilih foto menu' }}
                            </label>
                            <input type="file" id="menu-img-input-existing-{{ $menu->id }}"
                                   name="menus[existing-{{ $menu->id }}][image]"
                                   accept="image/*" class="hidden"
                                   onchange="previewMenuImg(this, 'existing-{{ $menu->id }}')">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Deskripsi Menu <span class="text-gray-400">(opsional)</span>
                            </label>
                            <textarea name="menus[existing-{{ $menu->id }}][description]" rows="2"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 transition resize-none">{{ old("menus.existing-{$menu->id}.description", $menu->description) }}</textarea>
                        </div>

                        <div class="md:col-span-2 flex items-center gap-2">
                            <input type="checkbox"
                                   name="menus[existing-{{ $menu->id }}][is_available]"
                                   id="avail-existing-{{ $menu->id }}"
                                   value="1"
                                   {{ old("menus.existing-{$menu->id}.is_available", $menu->is_available) ? 'checked' : '' }}
                                   class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="avail-existing-{{ $menu->id }}" class="text-sm text-gray-600 cursor-pointer">Menu tersedia</label>
                        </div>

                    </div>
                </div>
                @endforeach

            </div>

            @if ($restaurant->menus->isEmpty())
            <div id="menus-empty" class="px-6 py-10 text-center text-gray-400 text-sm">
                Belum ada menu. Klik <strong>+ Tambah Menu</strong> untuk menambahkan.
            </div>
            @else
            <div id="menus-empty" class="hidden"></div>
            @endif
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('restaurants.index') }}"
               class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 rounded-lg transition">
                Batal
            </a>
            <button type="submit"
                    class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition">
                Update Restoran
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Summernote ────────────────────────────────────────────────
    $('#content').summernote({
        height: 400,
        minHeight: 300,
        followingToolbar: false,
        dialogsInBody: true,
        placeholder: 'Tulis deskripsi lengkap restoran di sini...',
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
                    fetch('{{ route('restaurants.upload-image') }}', { method: 'POST', body: formData })
                        .then(r => r.json())
                        .then(data => { if (data.url) $(editor).summernote('insertImage', data.url); })
                        .catch(() => alert('Gagal upload gambar.'));
                });
            },
        },
    });

    let editorScrollTop = 0;
    $(document).on('mousedown', '.note-toolbar, .note-dropdown-menu, .note-popover', function () {
        const ed = $('.note-editable'); if (ed.length) editorScrollTop = ed.scrollTop();
    });
    $(document).on('click', '.note-toolbar, .note-dropdown-menu, .note-popover', function () {
        const ed = $('.note-editable');
        if (ed.length) { const c = editorScrollTop; setTimeout(() => ed.scrollTop(c), 10); }
    });

    // ── Cover preview ─────────────────────────────────────────────
    document.getElementById('image_cover').addEventListener('change', function () {
        const file = this.files[0]; if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('cover-preview').src = e.target.result;
            document.getElementById('cover-preview-wrapper').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    });

    // ── Menu ──────────────────────────────────────────────────────
    const menuCategories = @json($menuCategories);
    let newMenuCounter = 0;
    const menusContainer = document.getElementById('menus-container');
    const menusEmpty     = document.getElementById('menus-empty');

    renumberMenus(); // nomori menu existing saat load

    document.getElementById('add-menu-btn').addEventListener('click', () => {
        const idx = 'new-' + (newMenuCounter++);
        addMenuBlock(idx);
        menusEmpty.classList.add('hidden');
        renumberMenus();
    });

    function addMenuBlock(idx) {
        const categoryOptions = menuCategories
            .map(c => `<option value="${c}">${c}</option>`)
            .join('');

        const block = document.createElement('div');
        block.className = 'p-6 relative border-t border-gray-100';
        block.dataset.menuIdx = idx;
        block.innerHTML = `
            <button type="button" onclick="removeMenu(this)"
                    class="absolute top-4 right-5 text-gray-300 hover:text-red-500 transition text-lg font-bold leading-none">&times;</button>

            <h3 class="text-sm font-semibold text-gray-700 mb-4">Menu #<span class="menu-number"></span></h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Nama Menu</label>
                    <input type="text" name="menus[${idx}][name]"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 transition"
                           placeholder="Contoh: Nasi Goreng Bali" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Kategori Menu</label>
                    <select name="menus[${idx}][category]"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 transition bg-white" required>
                        <option value="">-- Pilih --</option>
                        ${categoryOptions}
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Harga (Rp)</label>
                    <input type="number" name="menus[${idx}][price]" min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 transition"
                           placeholder="Contoh: 45000" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Foto Menu</label>
                    <div id="menu-img-wrapper-${idx}" class="mb-2 hidden">
                        <img id="menu-img-preview-${idx}" src="#"
                             class="w-full max-h-28 object-cover rounded-lg border border-gray-200">
                    </div>
                    <label for="menu-img-input-${idx}"
                           class="flex items-center gap-2 px-3 py-2 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-indigo-400 hover:bg-indigo-50 transition text-xs text-gray-500 hover:text-indigo-600">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01"/>
                        </svg>
                        Pilih foto menu (maks. 2MB)
                    </label>
                    <input type="file" id="menu-img-input-${idx}" name="menus[${idx}][image]"
                           accept="image/*" class="hidden"
                           onchange="previewMenuImg(this, '${idx}')">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi Menu <span class="text-gray-400">(opsional)</span></label>
                    <textarea name="menus[${idx}][description]" rows="2"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 transition resize-none"
                              placeholder="Bahan, rasa, atau informasi singkat menu..."></textarea>
                </div>
                <div class="md:col-span-2 flex items-center gap-2">
                    <input type="checkbox" name="menus[${idx}][is_available]" id="avail-${idx}"
                           value="1" checked class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <label for="avail-${idx}" class="text-sm text-gray-600 cursor-pointer">Menu tersedia</label>
                </div>
            </div>
        `;

        menusContainer.appendChild(block);
    }

    window.removeMenu = function (btn) {
        btn.closest('[data-menu-idx]').remove();
        renumberMenus();
        if (!menusContainer.querySelector('[data-menu-idx]')) {
            menusEmpty.classList.remove('hidden');
        }
    };

    window.previewMenuImg = function (input, idx) {
        const file = input.files[0]; if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById(`menu-img-preview-${idx}`).src = e.target.result;
            document.getElementById(`menu-img-wrapper-${idx}`).classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    };

    function renumberMenus() {
        menusContainer.querySelectorAll('[data-menu-idx]').forEach((block, i) => {
            const num = block.querySelector('.menu-number');
            if (num) num.textContent = i + 1;
        });
    }

});
</script>
@endpush

</x-sidebar-app-layout>