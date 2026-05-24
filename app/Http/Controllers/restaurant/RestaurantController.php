<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    const CATEGORIES = [
        'Balinese', 'Indonesian', 'Western', 'Italian', 'Japanese',
        'Chinese', 'Korean', 'Indian', 'Mexican', 'Seafood',
        'Vegetarian', 'Vegan', 'Cafe', 'Fast Food', 'Fine Dining',
    ];

    const MENU_CATEGORIES = [
        'Makanan Utama', 'Makanan Pembuka', 'Makanan Penutup',
        'Minuman', 'Camilan', 'Paket Spesial',
    ];

    // -------------------------------------------------------
    // Hapus semua gambar konten dari HTML Summernote
    // -------------------------------------------------------
    private function deleteContentImages(string $content): void
    {
        preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/', $content, $matches);
        foreach ($matches[1] as $url) {
            if (str_contains($url, '/storage/restaurants/content-images/')) {
                Storage::disk('public')->delete('restaurants/content-images/' . basename($url));
            }
        }
    }

    // -------------------------------------------------------
    // List restoran milik user yang login
    // -------------------------------------------------------
    public function index(Request $request)
    {
        $search = $request->query('search');

        $restaurants = Restaurant::with('author')
            ->where('id_author', Auth::id())
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('features.admin.list-restaurant-admin', compact('restaurants'));
    }

    // -------------------------------------------------------
    // List semua restoran (admin & superadmin)
    // -------------------------------------------------------
    public function getAll(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Unauthorized action.');
        }

        $search = $request->query('search');

        $restaurants = Restaurant::with('author')
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('features.admin.list-restaurant-admin', compact('restaurants'));
    }

    // -------------------------------------------------------
    // Form create
    // -------------------------------------------------------
    public function create()
    {
        $categories     = self::CATEGORIES;
        $menuCategories = self::MENU_CATEGORIES;
        return view('features.form.restaurant.create-restaurant', compact('categories', 'menuCategories'));
    }

    // -------------------------------------------------------
    // Simpan restoran baru
    // -------------------------------------------------------
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'category'      => 'required|in:' . implode(',', self::CATEGORIES),
            'start_price'   => 'required|numeric|min:0',
            'description'   => 'required|string',
            'open_time'     => 'required|date_format:H:i',
            'close_time'    => 'required|date_format:H:i',
            'notes'         => 'nullable|string',
            'image_cover'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'menus'                   => 'nullable|array',
            'menus.*.name'            => 'required_with:menus|string|max:255',
            'menus.*.category'        => 'required_with:menus|in:' . implode(',', self::MENU_CATEGORIES),
            'menus.*.price'           => 'required_with:menus|numeric|min:0',
            'menus.*.description'     => 'nullable|string|max:500',
            'menus.*.is_available'    => 'nullable|boolean',
            'menus.*.image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        DB::transaction(function () use ($request) {

            $imagePath = null;
            if ($request->hasFile('image_cover')) {
                $imagePath = $request->file('image_cover')->store('restaurants/covers', 'public');
            }

            $restaurant = Restaurant::create([
                'name'        => $request->name,
                'address'     => $request->address,
                'phone'       => $request->phone,
                'category'    => $request->category,
                'start_price' => $request->start_price,
                'description' => $request->description,
                'open_time'   => $request->open_time,
                'close_time'  => $request->close_time,
                'notes'       => $request->notes,
                'image_cover' => $imagePath,
                'id_author'   => Auth::id(),
            ]);

            foreach ($request->menus ?? [] as $index => $menu) {
                $menuImagePath = null;
                if ($request->hasFile("menus.{$index}.image")) {
                    $menuImagePath = $request->file("menus.{$index}.image")
                                             ->store('restaurants/menus', 'public');
                }

                RestaurantMenu::create([
                    'restaurant_id' => $restaurant->id,
                    'name'          => $menu['name'],
                    'category'      => $menu['category'],
                    'price'         => $menu['price'],
                    'description'   => $menu['description'] ?? null,
                    'is_available'  => isset($menu['is_available']) ? true : false,
                    'image'         => $menuImagePath,
                ]);
            }
        });

        return redirect()->route('restaurants.index')
                         ->with('success', 'Restoran berhasil ditambahkan!');
    }

    // -------------------------------------------------------
    // Form edit
    // -------------------------------------------------------
    public function edit(Restaurant $restaurant)
    {
        if ($restaurant->id_author !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        if ($restaurant->banned) {
            abort(403, 'Restoran ini sedang ditangguhkan/dibanned.');
        }

        $restaurant->load('menus');
        $categories     = self::CATEGORIES;
        $menuCategories = self::MENU_CATEGORIES;

        return view('features.form.restaurant.update-restaurant', compact('restaurant', 'categories', 'menuCategories'));
    }

    // -------------------------------------------------------
    // Update restoran
    // -------------------------------------------------------
    public function update(Request $request, Restaurant $restaurant)
    {
        if ($restaurant->id_author !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        if ($restaurant->banned) {
            abort(403, 'Restoran ini sedang ditangguhkan/dibanned.');
        }

        $request->validate([
            'name'          => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'category'      => 'required|in:' . implode(',', self::CATEGORIES),
            'start_price'   => 'required|numeric|min:0',
            'description'   => 'required|string',
            'open_time'     => 'required|date_format:H:i',
            'close_time'    => 'required|date_format:H:i',
            'notes'         => 'nullable|string',
            'image_cover'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'menus'                   => 'nullable|array',
            'menus.*.id'              => 'nullable|integer|exists:restaurant_menus,id',
            'menus.*.name'            => 'required_with:menus|string|max:255',
            'menus.*.category'        => 'required_with:menus|in:' . implode(',', self::MENU_CATEGORIES),
            'menus.*.price'           => 'required_with:menus|numeric|min:0',
            'menus.*.description'     => 'nullable|string|max:500',
            'menus.*.is_available'    => 'nullable|boolean',
            'menus.*.image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        DB::transaction(function () use ($request, $restaurant) {

            // Update cover restoran
            $imagePath = $restaurant->image_cover;
            if ($request->hasFile('image_cover')) {
                if ($imagePath) Storage::disk('public')->delete($imagePath);
                $imagePath = $request->file('image_cover')->store('restaurants/covers', 'public');
            }

            $restaurant->update([
                'name'        => $request->name,
                'address'     => $request->address,
                'phone'       => $request->phone,
                'category'    => $request->category,
                'start_price' => $request->start_price,
                'description' => $request->description,
                'open_time'   => $request->open_time,
                'close_time'  => $request->close_time,
                'notes'       => $request->notes,
                'image_cover' => $imagePath,
            ]);

            // Hapus menu yang tidak ada di form
            $submittedIds = collect($request->menus ?? [])
                ->pluck('id')->filter()->map(fn($id) => (int) $id)->toArray();

            $restaurant->menus->each(function (RestaurantMenu $menu) use ($submittedIds) {
                if (!in_array($menu->id, $submittedIds)) {
                    if ($menu->image) Storage::disk('public')->delete($menu->image);
                    $menu->delete();
                }
            });

            // Update atau buat menu
            foreach ($request->menus ?? [] as $index => $menuData) {
                $menuImagePath = null;

                if ($request->hasFile("menus.{$index}.image")) {
                    if (!empty($menuData['id'])) {
                        $existing = RestaurantMenu::find($menuData['id']);
                        if ($existing && $existing->image) {
                            Storage::disk('public')->delete($existing->image);
                        }
                    }
                    $menuImagePath = $request->file("menus.{$index}.image")
                                             ->store('restaurants/menus', 'public');
                }

                $payload = [
                    'restaurant_id' => $restaurant->id,
                    'name'          => $menuData['name'],
                    'category'      => $menuData['category'],
                    'price'         => $menuData['price'],
                    'description'   => $menuData['description'] ?? null,
                    'is_available'  => isset($menuData['is_available']) ? true : false,
                ];

                if ($menuImagePath) {
                    $payload['image'] = $menuImagePath;
                }

                if (!empty($menuData['id'])) {
                    RestaurantMenu::where('id', $menuData['id'])
                                  ->where('restaurant_id', $restaurant->id)
                                  ->update($payload);
                } else {
                    RestaurantMenu::create($payload);
                }
            }
        });

        return redirect()->route('restaurants.index')
                         ->with('success', 'Restoran berhasil diupdate!');
    }

    // -------------------------------------------------------
    // Hapus restoran
    // -------------------------------------------------------
    public function destroy(Restaurant $restaurant)
    {
        $isOwner = $restaurant->id_author === Auth::id();
        $isAdmin = in_array(Auth::user()->role, ['admin', 'superadmin']);

        if (!$isOwner && !$isAdmin) abort(403, 'Unauthorized action.');
        if ($isOwner && $restaurant->banned) abort(403, 'Restoran ini sedang dibanned dan tidak dapat dihapus.');

        if ($restaurant->image_cover) {
            Storage::disk('public')->delete($restaurant->image_cover);
        }

        $this->deleteContentImages($restaurant->description ?? '');

        $restaurant->menus->each(function (RestaurantMenu $menu) {
            if ($menu->image) Storage::disk('public')->delete($menu->image);
        });

        $restaurant->delete();

        return redirect()->route('restaurants.index')
                         ->with('success', 'Restoran berhasil dihapus!');
    }

    // -------------------------------------------------------
    // Upload gambar konten Summernote
    // -------------------------------------------------------
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
        ]);

        $path = $request->file('file')->store('restaurants/content-images', 'public');

        return response()->json([
            'url' => asset('storage/' . $path),
        ]);
    }

    // -------------------------------------------------------
    // Ban & Unban
    // -------------------------------------------------------
    public function ban(Restaurant $restaurant)
    {
        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Unauthorized action.');
        }

        $restaurant->update(['banned' => true]);
        return redirect()->back()->with('success', 'Restoran berhasil dibanned!');
    }

    public function unban(Restaurant $restaurant)
    {
        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Unauthorized action.');
        }

        $restaurant->update(['banned' => false]);
        return redirect()->back()->with('success', 'Restoran berhasil diunban!');
    }
}