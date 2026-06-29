<x-sidebar-app-layout>

  <div class="max-w-5xl mx-auto px-4 py-10">
      <div class="mb-8">
          <h1 class="text-3xl font-bold text-gray-800">Buat Destinasi Baru</h1>
          <p class="text-gray-500 mt-1">Isi formulir di bawah untuk menambahkan destinasi wisata baru</p>
      </div>

      @if (session('success'))
          <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
              {{ session('success') }}
          </div>
      @endif

      <form action="{{ route('destinations.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          {{-- ========== INFORMASI UTAMA ========== --}}
          <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">
              <div class="p-6 space-y-6">

                  <div>
                      <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Destinasi</label>
                      <input type="text" name="title" id="title" value="{{ old('title') }}"
                             class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                             placeholder="Contoh: Pantai Kuta Bali">
                      @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                  </div>

                  <div>
                      <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                      <input type="text" name="location" id="location" value="{{ old('location') }}"
                             class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                             placeholder="Contoh: Kuta, Badung, Bali">
                      @error('location') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                  </div>

                  <div>
                      <label class="block text-sm font-medium text-gray-700 mb-2">
                          Kategori <span class="text-gray-400 font-normal">(bisa pilih lebih dari satu)</span>
                      </label>
                      <div class="flex flex-wrap gap-2">
                          @foreach ($categories as $cat)
                              <label class="cursor-pointer">
                                  <input type="checkbox" name="categories[]" value="{{ $cat }}"
                                         class="sr-only peer"
                                         {{ in_array($cat, old('categories', [])) ? 'checked' : '' }}>
                                  <span class="inline-block px-3 py-1.5 text-sm rounded-full border border-gray-300 text-gray-600
                                               peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600
                                               hover:border-indigo-400 hover:text-indigo-600 transition-all select-none">
                                      {{ $cat }}
                                  </span>
                              </label>
                          @endforeach
                      </div>
                      @error('categories') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                  </div>

                  <div>
                      <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Sampul</label>
                      <div id="cover-preview-wrapper" class="mb-3 hidden">
                          <img id="cover-preview" src="#" alt="Preview Cover"
                               class="w-full max-h-64 object-cover rounded-xl border border-gray-200">
                      </div>
                      <label for="image_cover"
                             class="flex items-center gap-3 px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-indigo-400 hover:bg-indigo-50 transition group">
                          <svg class="w-6 h-6 text-gray-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                          </svg>
                          <div>
                              <p class="text-sm font-medium text-gray-600 group-hover:text-indigo-600">Klik untuk pilih gambar sampul</p>
                              <p class="text-xs text-gray-400">JPG, JPEG, PNG, WEBP — maks. 2MB</p>
                          </div>
                      </label>
                      <input type="file" name="image_cover" id="image_cover" accept="image/*" class="hidden">
                      @error('image_cover') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                  </div>

                  <div>
                      <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Destinasi</label>
                      <textarea name="content" id="content">{{ old('content') }}</textarea>
                      @error('content') <p class="mt-1 text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                  </div>

              </div>
          </div>

          {{-- ========== LINKS (LINKTREE STYLE) ========== --}}
          <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">
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

              {{-- Preview linktree --}}
              <div id="links-preview-bar" class="hidden px-6 pt-4">
                  <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-3">Preview Tampilan</p>
                  <div id="links-preview-list" class="flex flex-wrap gap-2 mb-4"></div>
                  <hr class="border-gray-100">
              </div>

              <div id="links-container" class="divide-y divide-gray-100"></div>

              <div id="links-empty" class="px-6 py-10 text-center text-gray-400 text-sm">
                  Belum ada tautan. Klik <strong>+ Tambah Tautan</strong> untuk menambahkan link destinasi.
              </div>
          </div>

          {{-- Actions --}}
          <div class="px-0 py-4 flex items-center justify-end gap-3">
              <a href="{{ route('destinations.index') }}"
                 class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 rounded-lg transition">
                  Batal
              </a>
                <button type="submit" id="submit-btn"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition">
                    Simpan Destinasi
                </button>
          </div>

      </form>
  </div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {

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
                    Menyimpan...
                </span>
            `;
        }, 50);
    });

    // ── Summernote ────────────────────────────────────────────────
    $('#content').summernote({
      height: 450, minHeight: 300, followingToolbar: false, dialogsInBody: true,
      placeholder: 'Tulis deskripsi destinasi di sini...',
      toolbar: [
        ['style', ['style']], ['font', ['bold','underline','italic','strikethrough','superscript','subscript','clear']],
        ['fontname', ['fontname']], ['fontsize', ['fontsize']], ['color', ['color']],
        ['para', ['ul','ol','paragraph']], ['height', ['height']], ['table', ['table']],
        ['insert', ['link','picture','video','hr']], ['view', ['fullscreen','codeview','undo','redo','help']],
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
          const editor = this;
          Array.from(files).forEach(file => {
            const fd = new FormData();
            fd.append('file', file);
            fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            fetch('/admin/destination/upload-image', { method: 'POST', body: fd })
              .then(r => r.json()).then(d => { if (d.url) $(editor).summernote('insertImage', d.url); })
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

    // ── Links ─────────────────────────────────────────────────────
    let linkIndex = 0;
    const linksContainer   = document.getElementById('links-container');
    const linksEmpty       = document.getElementById('links-empty');
    const linksPreviewBar  = document.getElementById('links-preview-bar');
    const linksPreviewList = document.getElementById('links-preview-list');

    document.getElementById('add-link-btn').addEventListener('click', () => {
        addLinkBlock(linkIndex++);
        linksEmpty.classList.add('hidden');
        linksPreviewBar.classList.remove('hidden');
    });

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
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Nama Tautan</label>
                    <input type="text" name="links[${idx}][label]"
                           class="link-label-input w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="Contoh: Google Maps, Instagram, TripAdvisor"
                           oninput="updateLinkPreview(${idx})" required>
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
                             class="w-14 h-14 rounded-xl border-2 border-dashed border-gray-200 flex items-center justify-center bg-gray-50 overflow-hidden flex-shrink-0">
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
            <span id="link-preview-label-${idx}" class="truncate">Tautan #${idx + 1}</span>
        `;
        linksPreviewList.appendChild(preview);
    }

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

    window.updateLinkPreview = function (idx) {
        const block = linksContainer.querySelector(`[data-link-idx="${idx}"]`);
        if (!block) return;
        const label   = block.querySelector('.link-label-input')?.value?.trim() || `Tautan #${idx + 1}`;
        const labelEl = document.getElementById(`link-preview-label-${idx}`);
        if (labelEl) labelEl.textContent = label;
    };

    window.previewLinkCover = function (input, idx) {
        const file = input.files[0]; if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const img         = document.getElementById(`link-thumb-img-${idx}`);
            const placeholder = document.getElementById(`link-thumb-placeholder-${idx}`);
            if (img && placeholder) {
                img.src = e.target.result;
                img.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            const iconEl = document.getElementById(`link-preview-icon-${idx}`);
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

  });
</script>
@endpush

</x-sidebar-app-layout>