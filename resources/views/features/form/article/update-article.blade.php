<x-sidebar-app-layout>

  <div class="max-w-5xl mx-auto px-4 py-10">
      <div class="mb-8 flex items-center justify-between">
          <div>
              <h1 class="text-3xl font-bold text-gray-800">Edit Artikel</h1>
              <p class="text-gray-500 mt-1">Perbarui konten artikel</p>
          </div>
          <a href="{{ route('articles.index') }}"
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
          <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')

              <div class="p-6 space-y-6">

                  {{-- Title --}}
                  <div>
                      <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                          Judul Artikel
                      </label>
                      <input type="text"
                             name="title"
                             id="title"
                             value="{{ old('title', $article->title) }}"
                             class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                             placeholder="Masukkan judul artikel">
                      @error('title')
                          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                      @enderror
                  </div>

                  {{-- Cover Image --}}
                  <div>
                      <label class="block text-sm font-medium text-gray-700 mb-2">
                          Gambar Sampul
                      </label>

                      {{-- Preview cover lama atau baru --}}
                      <div id="cover-preview-wrapper" class="{{ $article->image_cover ? '' : 'hidden' }} mb-3">
                          <img id="cover-preview"
                               src="{{ $article->image_cover ? Storage::url($article->image_cover) : '#' }}"
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
                                  {{ $article->image_cover ? 'Ganti gambar sampul' : 'Klik untuk pilih gambar sampul' }}
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
                                id="content">{{ old('content', $article->content) }}</textarea>
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
                  <button type="submit"
                          class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition">
                      Update Artikel
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
        placeholder: 'Tulis konten artikel di sini...',

        toolbar: [
          ['style',     ['style']],
          ['font',      ['bold', 'underline', 'italic', 'strikethrough', 'superscript', 'subscript', 'clear']],
          ['fontname',  ['fontname']],
          ['fontsize',  ['fontsize']],
          ['color',     ['color']],
          ['para',      ['ul', 'ol', 'paragraph']],
          ['height',    ['height']],
          ['table',     ['table']],
          ['insert',    ['link', 'picture', 'video', 'hr']],
          ['view',      ['fullscreen', 'codeview', 'undo', 'redo', 'help']],
        ],

        fontNames: [
          'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New',
          'Georgia', 'Impact', 'Tahoma', 'Times New Roman',
          'Trebuchet MS', 'Verdana', 'Inter', 'Poppins',
        ],

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

      // Prevent page jumping to top when clicking Summernote toolbar/dropdown buttons
      $(document).on('click', '.note-editor a[href="#"]', function (e) {
        e.preventDefault();
      });

      // Preserve scroll position inside the editor when using toolbar/dropdowns/popovers
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

      function uploadImageToServer(file, editor) {
        const formData = new FormData();
        formData.append('file', file);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route('articles.upload-image') }}', {
          method: 'POST',
          body: formData,
        })
        .then(res => res.json())
        .then(data => {
          if (data.url) {
            $(editor).summernote('insertImage', data.url);
          }
        })
        .catch(() => alert('Gagal mengupload gambar. Silakan coba lagi.'));
      }

    });
  </script>
  @endpush

</x-sidebar-app-layout>