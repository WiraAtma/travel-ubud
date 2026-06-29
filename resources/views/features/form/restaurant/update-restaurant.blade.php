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

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Sampul Restoran</label>
                    <div id="cover-preview-wrapper" class="{{ $restaurant->image_cover ? '' : 'hidden' }} mb-3">
                        <img id="cover-preview"
                             src="{{ $restaurant->image_cover ? Storage::disk('supabase')->url($restaurant->image_cover) : '#' }}"
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

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Restoran</label>
                    <textarea name="description" id="content">{{ old('description', $restaurant->description) }}</textarea>
                    @error('description') <p class="mt-1 text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>

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

        {{-- ========== LINKS (LINKTREE STYLE) ========== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-semibold text-gray-700">Tautan Restoran</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Tambahkan link penting (Booking, Instagram, Maps, GoFood, dll.)</p>
                </div>
                <button type="button" id="add-link-btn"
                        class="px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                    + Tambah Tautan
                </button>
            </div>

            {{-- Preview linktree --}}
            <div id="links-preview-bar" class="{{ $restaurant->links->isNotEmpty() ? '' : 'hidden' }} px-6 pt-4">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-3">Preview Tampilan</p>
                <div id="links-preview-list" class="flex flex-wrap gap-2 mb-4">
                    @foreach ($restaurant->links as $link)
                    <div id="link-preview-chip-existing-{{ $link->id }}"
                         class="flex items-center gap-2 px-3 py-1.5 bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs rounded-full max-w-[180px] truncate">
                        <span class="w-5 h-5 rounded-full bg-indigo-200 flex-shrink-0 overflow-hidden flex items-center justify-center">
                            @if ($link->image_cover)
                                <img src="{{ Storage::disk('supabase')->url($link->image_cover) }}" class="w-full h-full object-cover" alt="">
                            @else
                                <svg class="w-3 h-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                            @endif
                        </span>
                        <span class="truncate">{{ $link->label }}</span>
                    </div>
                    @endforeach
                </div>
                <hr class="border-gray-100">
            </div>

            <div id="links-container" class="divide-y divide-gray-100">

                {{-- Links existing dari DB --}}
                @foreach ($restaurant->links as $link)
                <div class="p-6 relative" data-link-idx="existing-{{ $link->id }}">
                    <input type="hidden" name="links[existing-{{ $link->id }}][id]" value="{{ $link->id }}">

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
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Nama Tautan</label>
                            <input type="text" name="links[existing-{{ $link->id }}][label]"
                                   value="{{ old("links.existing-{$link->id}.label", $link->label) }}"
                                   class="link-label-input w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                   placeholder="Contoh: Instagram, GoFood, Google Maps"
                                   oninput="updateExistingLinkPreview('existing-{{ $link->id }}')" required>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">URL Tautan</label>
                            <input type="url" name="links[existing-{{ $link->id }}][url]"
                                   value="{{ old("links.existing-{$link->id}.url", $link->url) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                   placeholder="https://..." required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Cover Tautan
                                <span class="text-gray-400 font-normal">(opsional — thumbnail/logo link)</span>
                            </label>
                            <div class="flex items-center gap-4">
                                <div id="link-thumb-wrapper-existing-{{ $link->id }}"
                                     class="w-14 h-14 rounded-xl border-2 border-dashed border-gray-200 flex items-center justify-center bg-gray-50 overflow-hidden flex-shrink-0 transition">
                                    @if ($link->image_cover)
                                        <img id="link-thumb-img-existing-{{ $link->id }}"
                                             src="{{ Storage::disk('supabase')->url($link->image_cover) }}"
                                             alt="Cover" class="w-full h-full object-cover">
                                    @else
                                        <svg id="link-thumb-placeholder-existing-{{ $link->id }}" class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01"/>
                                        </svg>
                                        <img id="link-thumb-img-existing-{{ $link->id }}" src="#" alt="Cover" class="hidden w-full h-full object-cover">
                                    @endif
                                </div>
                                <label for="link-cover-input-existing-{{ $link->id }}"
                                       class="flex-1 flex items-center gap-2 px-3 py-2 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-indigo-400 hover:bg-indigo-50 transition text-xs text-gray-500 hover:text-indigo-600">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01"/>
                                    </svg>
                                    {{ $link->image_cover ? 'Ganti cover/logo' : 'Pilih cover/logo tautan (maks. 2MB)' }}
                                </label>
                                <input type="file" id="link-cover-input-existing-{{ $link->id }}"
                                       name="links[existing-{{ $link->id }}][image_cover]"
                                       accept="image/*" class="hidden"
                                       onchange="previewLinkCover(this, 'existing-{{ $link->id }}')">
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

            @if ($restaurant->links->isEmpty())
            <div id="links-empty" class="px-6 py-10 text-center text-gray-400 text-sm">
                Belum ada tautan. Klik <strong>+ Tambah Tautan</strong> untuk menambahkan link restoran.
            </div>
            @else
            <div id="links-empty" class="hidden"></div>
            @endif
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
                                     src="{{ $menu->image ? Storage::disk('supabase')->url($menu->image) : '#' }}"
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
            <button type="submit" id="submit-btn"
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
        height: 400, minHeight: 300, followingToolbar: false, dialogsInBody: true,
        placeholder: 'Tulis deskripsi lengkap restoran di sini...',
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
                    fetch('{{ route('restaurants.upload-image') }}', { method: 'POST', body: fd })
                        .then(r => r.json()).then(d => { if (d.url) $(editor).summernote('insertImage', d.url); })
                        .catch(() => alert('Gagal upload gambar.'));
                });
            },
        },
    });

    // ── Submit loading state ───────────────────────────────────────
    document.getElementById('submit-btn').addEventListener('click', function () {
        const btn = this;

        setTimeout(() => {
            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');
            btn.innerHTML = `
                <span class="flex items-center gap-2">
                    <svg aria-hidden="true" class="w-4 h-4 text-white/40 animate-spin fill-white" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    Mengupdate...
                </span>
            `;
        }, 50);
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

    // ── Links ─────────────────────────────────────────────────────
    let newLinkCounter = 0;
    const linksContainer   = document.getElementById('links-container');
    const linksEmpty       = document.getElementById('links-empty');
    const linksPreviewBar  = document.getElementById('links-preview-bar');
    const linksPreviewList = document.getElementById('links-preview-list');

    renumberLinks();

    document.getElementById('add-link-btn').addEventListener('click', () => {
        const idx = 'new-' + (newLinkCounter++);
        addLinkBlock(idx);
        linksEmpty.classList.add('hidden');
        linksPreviewBar.classList.remove('hidden');
        renumberLinks();
    });

    // ── Menus ─────────────────────────────────────────────────────
    const menuCategories = @json($menuCategories);
    let newMenuCounter = 0;
    const menusContainer = document.getElementById('menus-container');
    const menusEmpty     = document.getElementById('menus-empty');

    renumberMenus();

    document.getElementById('add-menu-btn').addEventListener('click', () => {
        const idx = 'new-' + (newMenuCounter++);
        addMenuBlock(idx);
        menusEmpty.classList.add('hidden');
        renumberMenus();
    });

    // ── Link block (new) ──────────────────────────────────────────
    function addLinkBlock(idx) {
        const block = document.createElement('div');
        block.className = 'p-6 relative border-t border-gray-100';
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
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Nama Tautan</label>
                    <input type="text" name="links[${idx}][label]"
                           class="link-label-input w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="Contoh: Instagram, GoFood, Google Maps"
                           oninput="updateNewLinkPreview('${idx}')" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">URL Tautan</label>
                    <input type="url" name="links[${idx}][url]"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="https://..." required>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Cover Tautan
                        <span class="text-gray-400 font-normal">(opsional — thumbnail/logo link)</span>
                    </label>
                    <div class="flex items-center gap-4">
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
                               onchange="previewLinkCover(this, '${idx}')">
                    </div>
                </div>
            </div>
        `;

        linksContainer.appendChild(block);

        // Preview chip
        const preview = document.createElement('div');
        preview.id = `link-preview-chip-${idx}`;
        preview.className = 'flex items-center gap-2 px-3 py-1.5 bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs rounded-full max-w-[180px] truncate';
        preview.innerHTML = `
            <span id="link-preview-icon-${idx}" class="w-5 h-5 rounded-full bg-indigo-200 flex-shrink-0 overflow-hidden flex items-center justify-center">
                <svg class="w-3 h-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
            </span>
            <span id="link-preview-label-${idx}" class="truncate">Tautan baru</span>
        `;
        linksPreviewList.appendChild(preview);
    }

    // ── Menu block (new) ──────────────────────────────────────────
    function addMenuBlock(idx) {
        const categoryOptions = menuCategories
            .map(c => `<option value="${c}">${c}</option>`).join('');

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

    // ── Global handlers ───────────────────────────────────────────
    window.removeLink = function (btn) {
        const block = btn.closest('[data-link-idx]');
        const idx   = block.dataset.linkIdx;
        // Hapus chip preview (bisa existing atau new)
        document.getElementById(`link-preview-chip-existing-${idx.replace('existing-','')}`)?.remove();
        document.getElementById(`link-preview-chip-${idx}`)?.remove();
        block.remove();
        renumberLinks();
        if (!linksContainer.querySelector('[data-link-idx]')) {
            linksEmpty.classList.remove('hidden');
            linksPreviewBar.classList.add('hidden');
        }
    };

    window.removeMenu = function (btn) {
        btn.closest('[data-menu-idx]').remove();
        renumberMenus();
        if (!menusContainer.querySelector('[data-menu-idx]')) {
            menusEmpty.classList.remove('hidden');
        }
    };

    window.updateExistingLinkPreview = function (idx) {
        const block = linksContainer.querySelector(`[data-link-idx="${idx}"]`);
        if (!block) return;
        const label   = block.querySelector('.link-label-input')?.value?.trim() || idx;
        const chipId  = idx.startsWith('existing-')
            ? `link-preview-chip-existing-${idx.replace('existing-', '')}`
            : `link-preview-chip-${idx}`;
        const labelEl = document.querySelector(`#${chipId} span:last-child`);
        if (labelEl) labelEl.textContent = label;
    };

    window.updateNewLinkPreview = function (idx) {
        const block = linksContainer.querySelector(`[data-link-idx="${idx}"]`);
        if (!block) return;
        const label   = block.querySelector('.link-label-input')?.value?.trim() || 'Tautan baru';
        const labelEl = document.getElementById(`link-preview-label-${idx}`);
        if (labelEl) labelEl.textContent = label;
    };

    window.previewLinkCover = function (input, idx) {
        const file = input.files[0]; if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const img         = document.getElementById(`link-thumb-img-${idx}`);
            const placeholder = document.getElementById(`link-thumb-placeholder-${idx}`);
            if (img) {
                img.src = e.target.result;
                img.classList.remove('hidden');
            }
            if (placeholder) placeholder.classList.add('hidden');

            // Update chip icon (existing atau new)
            const chipId  = String(idx).startsWith('existing-')
                ? `link-preview-chip-existing-${String(idx).replace('existing-', '')}`
                : `link-preview-chip-${idx}`;
            const iconEl  = document.querySelector(`#${chipId} span:first-child`);
            if (iconEl) iconEl.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover" alt="">`;
        };
        reader.readAsDataURL(file);
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

    function renumberLinks() {
        linksContainer.querySelectorAll('[data-link-idx]').forEach((block, i) => {
            const num = block.querySelector('.link-number');
            if (num) num.textContent = i + 1;
        });
    }

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