<x-sidebar-app-layout>

  <div class="max-w-5xl mx-auto px-4 py-10">
      <div class="mb-8">
          <h1 class="text-3xl font-bold text-gray-800">Buat Artikel Baru</h1>
          <p class="text-gray-500 mt-1">Isi formulir di bawah untuk membuat artikel baru</p>
      </div>

      @if (session('success'))
          <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
              {{ session('success') }}
          </div>
      @endif

      <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
          <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
              @csrf

              <div class="p-6 space-y-6">

                  {{-- Title --}}
                  <div>
                      <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                          Judul Artikel
                      </label>
                      <input type="text"
                             name="title"
                             id="title"
                             value="{{ old('title') }}"
                             class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                             placeholder="Masukkan judul artikel">
                      @error('title')
                          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                      @enderror
                  </div>

                  {{-- Cover Image --}}
                  <div>
                      <label for="image_cover" class="block text-sm font-medium text-gray-700 mb-2">
                          Gambar Sampul
                      </label>

                      {{-- Preview Box --}}
                      <div id="cover-preview-wrapper" class="mb-3 hidden">
                          <img id="cover-preview"
                               src="#"
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
                                  Klik untuk pilih gambar sampul
                              </p>
                              <p class="text-xs text-gray-400">JPG, JPEG, PNG, WEBP — maks. 2MB</p>
                          </div>
                      </label>
                      <input type="file"
                             name="image_cover"
                             id="image_cover"
                             accept="image/*"
                             class="hidden">
                      @error('image_cover')
                          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                      @enderror
                  </div>

                  {{-- Content - Summernote --}}
                  <div>
                      <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                          Konten Artikel
                      </label>
                      <textarea name="content"
                                id="content">{{ old('content') }}</textarea>
                      @error('content')
                          <p class="mt-1 text-sm text-red-600 mt-2">{{ $message }}</p>
                      @enderror
                  </div>

              </div>

              {{-- Actions --}}
              <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-3">
                  <a href="{{ route('articles.index') }}"
                     class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 rounded-lg transition">
                      Batal
                  </a>
                <button type="submit" id="submit-btn"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition">
                    Simpan Artikel
                </button>
              </div>

          </form>
      </div>
  </div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {

    // Cover preview
    const coverInput  = document.getElementById('image_cover');
    const previewImg  = document.getElementById('cover-preview');
    const previewWrap = document.getElementById('cover-preview-wrapper');
    if (coverInput) {
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
    }

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

    // Summernote
    $('#content').summernote({
      height: 450,
      minHeight: 300,
      followingToolbar: false,
      dialogsInBody: true,
      placeholder: 'Tulis konten artikel di sini...',
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
          const editor = this;
          Array.from(files).forEach(file => {
            const formData = new FormData();
            formData.append('file', file);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            fetch('/admin/article/upload-image', { method: 'POST', body: formData })
              .then(r => r.json())
              .then(data => { if (data.url) $(editor).summernote('insertImage', data.url); })
              .catch(() => alert('Gagal upload gambar.'));
          });
        },
      },
    });

    $(document).on('click', '.note-editor a[href="#"]', function (e) {
      e.preventDefault();
    });

    let editorScrollTop = 0;
    $(document).on('mousedown', '.note-toolbar, .note-dropdown-menu, .note-popover', function () {
      const editable = $('.note-editable');
      if (editable.length) {
        editorScrollTop = editable.scrollTop();
      }
    });
    $(document).on('click', '.note-toolbar, .note-dropdown-menu, .note-popover', function () {
      const editable = $('.note-editable');
      if (editable.length) {
        const cachedScroll = editorScrollTop;
        setTimeout(function () {
          editable.scrollTop(cachedScroll);
        }, 10);
      }
    });
    

  });
</script>
@endpush

</x-sidebar-app-layout>