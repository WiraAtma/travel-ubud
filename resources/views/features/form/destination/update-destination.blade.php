<x-sidebar-app-layout>

  <div class="max-w-5xl mx-auto px-4 py-10">
      <div class="mb-8 flex items-center justify-between">
          <div>
              <h1 class="text-3xl font-bold text-gray-800">Edit Destinasi</h1>
              <p class="text-gray-500 mt-1">Perbarui informasi destinasi wisata</p>
          </div>
          <a href="{{ route('destinations.index') }}"
             class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
              ← Kembali
          </a>
      </div>

      @if (session('success'))
          <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
              {{ session('success') }}
          </div>
      @endif

      <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
          <form action="{{ route('destinations.update', $destination) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')

              <div class="p-6 space-y-6">

                  {{-- Judul --}}
                  <div>
                      <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                          Judul Destinasi
                      </label>
                      <input type="text"
                             name="title"
                             id="title"
                             value="{{ old('title', $destination->title) }}"
                             class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                             placeholder="Contoh: Pantai Kuta Bali">
                      @error('title')
                          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                      @enderror
                  </div>

                  {{-- Lokasi --}}
                  <div>
                      <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                          Lokasi
                      </label>
                      <input type="text"
                             name="location"
                             id="location"
                             value="{{ old('location', $destination->location) }}"
                             class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                             placeholder="Contoh: Kuta, Badung, Bali">
                      @error('location')
                          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                      @enderror
                  </div>

                  {{-- Kategori (multi-select) --}}
                  <div>
                      <label class="block text-sm font-medium text-gray-700 mb-2">
                          Kategori <span class="text-gray-400 font-normal">(bisa pilih lebih dari satu)</span>
                      </label>
                      <div class="flex flex-wrap gap-2">
                          @foreach ($categories as $cat)
                              <label class="cursor-pointer">
                                  <input type="checkbox"
                                         name="categories[]"
                                         value="{{ $cat }}"
                                         class="sr-only peer"
                                         {{ in_array($cat, old('categories', (array) $destination->categories)) ? 'checked' : '' }}>
                                  <span class="inline-block px-3 py-1.5 text-sm rounded-full border border-gray-300 text-gray-600
                                               peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600
                                               hover:border-indigo-400 hover:text-indigo-600 transition-all select-none">
                                      {{ $cat }}
                                  </span>
                              </label>
                          @endforeach
                      </div>
                      @error('categories')
                          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                      @enderror
                  </div>

                  {{-- Cover Image --}}
                  <div>
                      <label class="block text-sm font-medium text-gray-700 mb-2">
                          Gambar Sampul
                      </label>

                      <div id="cover-preview-wrapper" class="{{ $destination->image_cover ? '' : 'hidden' }} mb-3">
                          <img id="cover-preview"
                               src="{{ $destination->image_cover ? Storage::url($destination->image_cover) : '#' }}"
                               alt="Preview Cover"
                               class="w-full max-h-64 object-cover rounded-xl border border-gray-200">
                      </div>

                      <label for="image_cover"
                             class="flex items-center gap-3 px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-indigo-400 hover:bg-indigo-50 transition group">
                          <svg class="w-6 h-6 text-gray-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                          </svg>
                          <div>
                              <p class="text-sm font-medium text-gray-600 group-hover:text-indigo-600">
                                  {{ $destination->image_cover ? 'Ganti gambar sampul' : 'Klik untuk pilih gambar sampul' }}
                              </p>
                              <p class="text-xs text-gray-400">JPG, JPEG, PNG, WEBP — maks. 2MB</p>
                          </div>
                      </label>
                      <input type="file" name="image_cover" id="image_cover" accept="image/*" class="hidden">
                      @error('image_cover')
                          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                      @enderror
                  </div>

                  {{-- Konten Summernote --}}
                  <div>
                      <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                          Deskripsi Destinasi
                      </label>
                      <textarea name="content" id="content">{{ old('content', $destination->content) }}</textarea>
                      @error('content')
                          <p class="mt-1 text-sm text-red-600 mt-2">{{ $message }}</p>
                      @enderror
                  </div>

                  {{-- Tautan Destinasi --}}
                  <div class="border border-gray-200 rounded-2xl overflow-hidden">
                      <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                          <div>
                              <h2 class="text-base font-semibold text-gray-700">Tautan Destinasi</h2>
                              <p class="text-xs text-gray-400 mt-0.5">Tambahkan link penting (Google Maps, Instagram, Website, dll.)</p>
                          </div>
                          <button type="button" id="add-link-btn"
                                  class="px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                              + Tambah Tautan
                          </button>
                      </div>

                      <div id="links-preview-bar" class="{{ $destination->links->isNotEmpty() ? '' : 'hidden' }} px-6 pt-4">
                          <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-3">Preview Tampilan</p>
                          <div id="links-preview-list" class="flex flex-wrap gap-2 mb-4">
                              @foreach ($destination->links as $link)
                                  <div id="link-preview-chip-existing-{{ $link->id }}"
                                       class="flex items-center gap-2 px-3 py-1.5 bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs rounded-full max-w-[180px] truncate">
                                      <span class="w-5 h-5 rounded-full bg-indigo-200 flex-shrink-0 overflow-hidden flex items-center justify-center">
                                          @if ($link->image_cover)
                                              <img src="{{ Storage::url($link->image_cover) }}" class="w-full h-full object-cover" alt="">
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
                          @foreach ($destination->links as $link)
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
                                                 placeholder="Contoh: Google Maps, Instagram, TripAdvisor"
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
                                              <span class="text-gray-400 font-normal">(opsional - thumbnail/logo link)</span>
                                          </label>
                                          <div class="flex items-center gap-4">
                                              <div id="link-thumb-wrapper-existing-{{ $link->id }}"
                                                   class="w-14 h-14 rounded-xl border-2 border-dashed border-gray-200 flex items-center justify-center bg-gray-50 overflow-hidden flex-shrink-0 transition">
                                                  @if ($link->image_cover)
                                                      <img id="link-thumb-img-existing-{{ $link->id }}"
                                                           src="{{ Storage::url($link->image_cover) }}"
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

                      @if ($destination->links->isEmpty())
                          <div id="links-empty" class="px-6 py-10 text-center text-gray-400 text-sm">
                              Belum ada tautan. Klik <strong>+ Tambah Tautan</strong> untuk menambahkan link destinasi.
                          </div>
                      @else
                          <div id="links-empty" class="hidden"></div>
                      @endif
                  </div>

              </div>

              {{-- Actions --}}
              <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-3">
                  <a href="{{ route('destinations.index') }}"
                     class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 rounded-lg transition">
                      Batal
                  </a>
                  <button type="submit"
                          class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition">
                      Update Destinasi
                  </button>
              </div>

          </form>
      </div>
  </div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {

    const coverInput  = document.getElementById('image_cover');
    const previewImg  = document.getElementById('cover-preview');
    const previewWrap = document.getElementById('cover-preview-wrapper');

    coverInput.addEventListener('change', function () {
      const file = this.files[0];
      if (!file) return;
      const reader = new FileReader();
      reader.onload = e => {
        previewImg.src = e.target.result;
        previewWrap.classList.remove('hidden');
      };
      reader.readAsDataURL(file);
    });

    $('#content').summernote({
      lang: 'id-ID',
      height: 450,
      minHeight: 300,
      followingToolbar: false,
      dialogsInBody: true,
      placeholder: 'Tulis deskripsi destinasi di sini...',
      toolbar: [
        ['style',    ['style']],
        ['font',     ['bold', 'underline', 'italic', 'strikethrough', 'superscript', 'subscript', 'clear']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['color',    ['color']],
        ['para',     ['ul', 'ol', 'paragraph']],
        ['height',   ['height']],
        ['table',    ['table']],
        ['insert',   ['link', 'picture', 'video', 'hr']],
        ['view',     ['fullscreen', 'codeview', 'undo', 'redo', 'help']],
      ],
      fontNames: ['Arial','Arial Black','Comic Sans MS','Courier New','Georgia','Impact','Tahoma','Times New Roman','Trebuchet MS','Verdana','Inter','Poppins'],
      fontSizes: ['10','11','12','13','14','15','16','18','20','22','24','28','32','36','48','64'],
      styleTags: [
        'p',
        { title: 'Heading 1', tag: 'h1', className: '', value: 'h1' },
        { title: 'Heading 2', tag: 'h2', className: '', value: 'h2' },
        { title: 'Heading 3', tag: 'h3', className: '', value: 'h3' },
        { title: 'Heading 4', tag: 'h4', className: '', value: 'h4' },
        'blockquote', 'pre',
      ],
      callbacks: {
        onImageUpload: function (files) {
          Array.from(files).forEach(file => uploadImageToServer(file, this));
        },
      },
    });

    $(document).on('click', '.note-editor a[href="#"]', function (e) {
      e.preventDefault();
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
                   placeholder="Contoh: Google Maps, Instagram, TripAdvisor"
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
              <span class="text-gray-400 font-normal">(opsional - thumbnail/logo link)</span>
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

    window.removeLink = function (btn) {
      const block = btn.closest('[data-link-idx]');
      const idx   = block.dataset.linkIdx;
      document.getElementById(`link-preview-chip-existing-${idx.replace('existing-', '')}`)?.remove();
      document.getElementById(`link-preview-chip-${idx}`)?.remove();
      block.remove();
      renumberLinks();
      if (!linksContainer.querySelector('[data-link-idx]')) {
        linksEmpty.classList.remove('hidden');
        linksPreviewBar.classList.add('hidden');
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

        const chipId  = String(idx).startsWith('existing-')
          ? `link-preview-chip-existing-${String(idx).replace('existing-', '')}`
          : `link-preview-chip-${idx}`;
        const iconEl  = document.querySelector(`#${chipId} span:first-child`);
        if (iconEl) iconEl.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover" alt="">`;
      };
      reader.readAsDataURL(file);
    };

    function renumberLinks() {
      linksContainer.querySelectorAll('[data-link-idx]').forEach((block, i) => {
        const num = block.querySelector('.link-number');
        if (num) num.textContent = i + 1;
      });
    }

    function uploadImageToServer(file, editor) {
      const formData = new FormData();
      formData.append('file', file);
      formData.append('_token', '{{ csrf_token() }}');
      fetch('{{ route('destinations.upload-image') }}', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => { if (data.url) $(editor).summernote('insertImage', data.url); })
        .catch(() => alert('Gagal mengupload gambar. Silakan coba lagi.'));
    }

  });
</script>
@endpush

</x-sidebar-app-layout>
