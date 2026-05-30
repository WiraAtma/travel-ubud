<?php

namespace App\Http\Controllers\Destination;

use App\Http\Controllers\Controller;
use App\Models\Destination\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DestinationController extends Controller
{
    const CATEGORIES = [
        'Pantai', 'Alam', 'Budaya', 'Sejarah',
        'Kuliner', 'Hiburan', 'Relaksasi', 'Adventure',
        'Belanja', 'Spiritual',
    ];

    // Hapus semua gambar konten dari HTML
    private function deleteContentImages(string $content): void
    {
        preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/', $content, $matches);

        foreach ($matches[1] as $url) {
            if (str_contains($url, '/storage/destinations/content-images/')) {
                $path = 'destinations/content-images/' . basename($url);
                Storage::disk('public')->delete($path);
            }
        }
    }

    // List destinasi milik user yang login
    public function index(Request $request)
    {
        $search = $request->query('search');

        $destinations = Destination::with('author')
            ->where('id_author', Auth::id())
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('features.admin.list-destination-admin', compact('destinations'));
    }

    // List semua destinasi (admin & superadmin)
    public function getAll(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Unauthorized action.');
        }

        $search = $request->query('search');

        $destinations = Destination::with('author')
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('features.admin.list-destination-admin', compact('destinations'));
    }

    // Form create
    public function create()
    {
        $categories = self::CATEGORIES;
        return view('features.form.destination.create-destination', compact('categories'));
    }

    // Simpan destinasi baru
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'categories'  => 'required|array|min:1',
            'categories.*'=> 'in:' . implode(',', self::CATEGORIES),
            'image_cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'content'     => 'required|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_cover')) {
            $imagePath = $request->file('image_cover')
                                 ->store('destinations/covers', 'public');
        }

        Destination::create([
            'title'       => $request->title,
            'location'    => $request->location,
            'categories'  => $request->categories,
            'image_cover' => $imagePath,
            'content'     => $request->content,
            'id_author'   => Auth::id(),
        ]);

        return redirect()->route('destinations.index')
                         ->with('success', 'Destinasi berhasil dibuat!');
    }

    // Form edit
    public function edit(Destination $destination)
    {
        if ($destination->id_author !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        if ($destination->banned) {
            abort(403, 'Destinasi ini sedang ditangguhkan/dibanned.');
        }

        $categories = self::CATEGORIES;
        return view('features.form.destination.update-destination', compact('destination', 'categories'));
    }

    // Update destinasi
    public function update(Request $request, Destination $destination)
    {
        if ($destination->id_author !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        if ($destination->banned) {
            abort(403, 'Destinasi ini sedang ditangguhkan/dibanned.');
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'categories'  => 'required|array|min:1',
            'categories.*'=> 'in:' . implode(',', self::CATEGORIES),
            'image_cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'content'     => 'required|string',
        ]);

        $imagePath = $destination->image_cover;
        if ($request->hasFile('image_cover')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image_cover')
                                 ->store('destinations/covers', 'public');
        }

        // Hapus gambar konten lama yang tidak dipakai lagi
        if ($destination->content !== $request->content) {
            preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/', $destination->content, $oldMatches);
            preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/', $request->content, $newMatches);

            $oldImages = $oldMatches[1] ?? [];
            $newImages = $newMatches[1] ?? [];

            foreach ($oldImages as $url) {
                if (!in_array($url, $newImages) && str_contains($url, '/storage/destinations/content-images/')) {
                    $path = 'destinations/content-images/' . basename($url);
                    Storage::disk('public')->delete($path);
                }
            }
        }

        $destination->update([
            'title'       => $request->title,
            'location'    => $request->location,
            'categories'  => $request->categories,
            'image_cover' => $imagePath,
            'content'     => $request->content,
        ]);

        return redirect()->route('destinations.index')
                         ->with('success', 'Destinasi berhasil diupdate!');
    }

    // Hapus destinasi
    public function destroy(Destination $destination)
    {
        $isOwner = $destination->id_author === Auth::id();
        $isAdmin = in_array(Auth::user()->role, ['admin', 'superadmin']);

        if (!$isOwner && !$isAdmin) {
            abort(403, 'Unauthorized action.');
        }

        if ($isOwner && $destination->banned) {
            abort(403, 'Destinasi ini sedang dibanned dan tidak dapat dihapus.');
        }

        if ($destination->image_cover) {
            Storage::disk('public')->delete($destination->image_cover);
        }

        $this->deleteContentImages($destination->content);

        $destination->delete();

        return redirect()->route('destinations.index')
                         ->with('success', 'Destinasi berhasil dihapus!');
    }

    // Upload gambar konten (Summernote)
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
        ]);

        $path = $request->file('file')->store('destinations/content-images', 'public');

        return response()->json([
            'url' => asset('storage/' . $path),
        ]);
    }

    // Ban destinasi
    public function ban(Destination $destination)
    {
        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Unauthorized action.');
        }

        $destination->update(['banned' => true]);

        return redirect()->back()->with('success', 'Destinasi berhasil dibanned!');
    }

    // Unban destinasi
    public function unban(Destination $destination)
    {
        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Unauthorized action.');
        }

        $destination->update(['banned' => false]);

        return redirect()->back()->with('success', 'Destinasi berhasil diunban!');
    }
}