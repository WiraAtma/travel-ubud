<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Models\Article\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    // Hapus semua gambar konten dari HTML
    private function deleteContentImages(string $content): void
    {
        // Ambil semua src gambar dari tag <img> dalam konten
        preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/', $content, $matches);

        foreach ($matches[1] as $url) {
            // Hanya hapus gambar yang disimpan lokal (storage)
            if (str_contains($url, '/storage/articles/content-images/')) {
                $path = 'articles/content-images/' . basename($url);
                Storage::disk('public')->delete($path);
            }
        }
    }

    // List semua article milik user yang sedang login
    public function index(Request $request)
    {
        $search = $request->query('search');

        $articles = Article::with('author')
                     ->where('id_author', Auth::id())
                     ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
                     ->orderBy('created_at', 'desc')
                     ->paginate(10)
                     ->withQueryString();

        return view('features.admin.list-article-admin', compact('articles'));
    }

    // List semua article dari semua user
    public function getAll(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Unauthorized action.');
        }

        $search = $request->query('search');

        $articles = Article::with('author')
                     ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
                     ->orderBy('created_at', 'desc')
                     ->paginate(10)
                     ->withQueryString();

        return view('features.admin.list-article-admin', compact('articles'));
    }


    // Form create
    public function create()
    {
        return view('features.form.article.create-article');
    }

    // Simpan article baru
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'image_cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'content'     => 'required|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_cover')) {
            $imagePath = $request->file('image_cover')
                                 ->store('articles/covers', 'public');
        }

        Article::create([
            'title'       => $request->title,
            'image_cover' => $imagePath,
            'content'     => $request->content,
            'id_author'   => Auth::id(),
        ]);

        return redirect()->route('articles.index')
                         ->with('success', 'Article berhasil dibuat!');
    }

    // Form edit
    public function edit(Article $article)
    {
        if ($article->id_author !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        if ($article->banned) {
            abort(403, 'Artikel ini sedang ditangguhkan/dibanned.');
        }
        return view('features.form.article.update-article', compact('article'));
    }

    // Update article
    public function update(Request $request, Article $article)
    {
        if ($article->id_author !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        if ($article->banned) {
            abort(403, 'Artikel ini sedang ditangguhkan/dibanned.');
        }
        $request->validate([
            'title'       => 'required|string|max:255',
            'image_cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'content'     => 'required|string',
        ]);

        $imagePath = $article->image_cover;
        if ($request->hasFile('image_cover')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image_cover')
                                 ->store('articles/covers', 'public');
        }

        // Hapus gambar konten lama yang tidak dipakai lagi
        if ($article->content !== $request->content) {
            // Cari gambar yang ada di konten lama tapi tidak ada di konten baru
            preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/', $article->content, $oldMatches);
            preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/', $request->content, $newMatches);

            $oldImages = $oldMatches[1] ?? [];
            $newImages = $newMatches[1] ?? [];

            // Hapus gambar yang sudah tidak ada di konten baru
            foreach ($oldImages as $url) {
                if (!in_array($url, $newImages) && str_contains($url, '/storage/articles/content-images/')) {
                    $path = 'articles/content-images/' . basename($url);
                    Storage::disk('public')->delete($path);
                }
            }
        }

        $article->update([
            'title'       => $request->title,
            'image_cover' => $imagePath,
            'content'     => $request->content,
        ]);

        return redirect()->route('articles.index')
                         ->with('success', 'Article berhasil diupdate!');
    }

    // Hapus article
    public function destroy(Article $article)
    {
        $isOwner = $article->id_author === Auth::id();
        $isAdmin = in_array(Auth::user()->role, ['admin', 'superadmin']);

        if (!$isOwner && !$isAdmin) {
            abort(403, 'Unauthorized action.');
        }

        if ($isOwner && $article->banned) {
            abort(403, 'Artikel ini sedang dibanned dan tidak dapat dihapus.');
        }

        // Hapus cover
        if ($article->image_cover) {
            Storage::disk('public')->delete($article->image_cover);
        }

        // Hapus semua gambar di dalam konten
        $this->deleteContentImages($article->content);

        $article->delete();

        return redirect()->route('articles.index')
                         ->with('success', 'Article berhasil dihapus!');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
        ]);

        $path = $request->file('file')->store('articles/content-images', 'public');

        return response()->json([
            'url' => asset('storage/' . $path),
        ]);
    }

    // Ban article
    public function ban(Article $article)
    {
        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Unauthorized action.');
        }

        $article->update(['banned' => true]);

        return redirect()->back()->with('success', 'Article berhasil dibanned!');
    }

    // Unban article
    public function unban(Article $article)
    {
        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Unauthorized action.');
        }

        $article->update(['banned' => false]);

        return redirect()->back()->with('success', 'Article berhasil diunban!');
    }
}