<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Hotel\Hotel;
use App\Models\Hotel\HotelRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    private function deleteContentImages(string $content): void
    {
        preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/', $content, $matches);
        foreach ($matches[1] as $url) {
            if (str_contains($url, '/storage/hotels/content-images/')) {
                Storage::disk('public')->delete('hotels/content-images/' . basename($url));
            }
        }
    }

    // -------------------------------------------------------
    // List hotel milik user yang login
    // -------------------------------------------------------
    public function index(Request $request)
    {
        $search = $request->query('search');

        $hotels = Hotel::with('author')
            ->where('id_author', Auth::id())
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('features.admin.list-hotel-admin', compact('hotels'));
    }

    // -------------------------------------------------------
    // List semua hotel (admin & superadmin)
    // -------------------------------------------------------
    public function getAll(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Unauthorized action.');
        }

        $search = $request->query('search');

        $hotels = Hotel::with('author')
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('features.admin.list-hotel-admin', compact('hotels'));
    }

    // -------------------------------------------------------
    // Form create
    // -------------------------------------------------------
    public function create()
    {
        return view('features.form.hotel.create-hotel');
    }

    // -------------------------------------------------------
    // Simpan hotel baru (beserta kamar-kamarnya)
    // -------------------------------------------------------
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'start_price'   => 'required|numeric|min:0',
            'facilities'    => 'required|array|min:1',
            'facilities.*'  => 'required|string|max:100',
            'checkin_time'  => 'required|date_format:H:i',
            'checkout_time' => 'required|date_format:H:i',
            'description'   => 'required|string',
            'notes'         => 'nullable|string',
            'image_cover'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            // Rooms
            'rooms'                    => 'nullable|array',
            'rooms.*.name'             => 'required_with:rooms|string|max:255',
            'rooms.*.max_guests'       => 'required_with:rooms|integer|min:1',
            'rooms.*.price'            => 'required_with:rooms|numeric|min:0',
            'rooms.*.facilities'       => 'required_with:rooms|array|min:1',
            'rooms.*.facilities.*'     => 'required|string|max:100',
            'rooms.*.image_cover'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        DB::transaction(function () use ($request) {

            // Upload cover hotel
            $imagePath = null;
            if ($request->hasFile('image_cover')) {
                $imagePath = $request->file('image_cover')->store('hotels/covers', 'public');
            }

            $hotel = Hotel::create([
                'name'          => $request->name,
                'address'       => $request->address,
                'phone'         => $request->phone,
                'start_price'   => $request->start_price,
                'facilities'    => $request->facilities,
                'checkin_time'  => $request->checkin_time,
                'checkout_time' => $request->checkout_time,
                'description'   => $request->description,
                'notes'         => $request->notes,
                'image_cover'   => $imagePath,
                'id_author'     => Auth::id(),
            ]);

            // Simpan kamar
            if ($request->has('rooms')) {
                foreach ($request->rooms as $index => $room) {
                    $roomImagePath = null;
                    if ($request->hasFile("rooms.{$index}.image_cover")) {
                        $roomImagePath = $request->file("rooms.{$index}.image_cover")
                                                 ->store('hotels/rooms', 'public');
                    }

                    HotelRoom::create([
                        'hotel_id'    => $hotel->id,
                        'name'        => $room['name'],
                        'max_guests'  => $room['max_guests'],
                        'price'       => $room['price'],
                        'facilities'  => $room['facilities'],
                        'image_cover' => $roomImagePath,
                    ]);
                }
            }
        });

        return redirect()->route('hotels.index')
                         ->with('success', 'Hotel berhasil ditambahkan!');
    }

    // -------------------------------------------------------
    // Form edit
    // -------------------------------------------------------
    public function edit(Hotel $hotel)
    {
        if ($hotel->id_author !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        if ($hotel->banned) {
            abort(403, 'Hotel ini sedang ditangguhkan/dibanned.');
        }

        $hotel->load('rooms');
        return view('features.form.hotel.update-hotel', compact('hotel'));
    }

    // -------------------------------------------------------
    // Update hotel
    // -------------------------------------------------------
    public function update(Request $request, Hotel $hotel)
    {
        if ($hotel->id_author !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        if ($hotel->banned) {
            abort(403, 'Hotel ini sedang ditangguhkan/dibanned.');
        }

        $request->validate([
            'name'          => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'start_price'   => 'required|numeric|min:0',
            'facilities'    => 'required|array|min:1',
            'facilities.*'  => 'required|string|max:100',
            'checkin_time'  => 'required|date_format:H:i',
            'checkout_time' => 'required|date_format:H:i',
            'description'   => 'required|string',
            'notes'         => 'nullable|string',
            'image_cover'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'rooms'                    => 'nullable|array',
            'rooms.*.name'             => 'required_with:rooms|string|max:255',
            'rooms.*.max_guests'       => 'required_with:rooms|integer|min:1',
            'rooms.*.price'            => 'required_with:rooms|numeric|min:0',
            'rooms.*.facilities'       => 'required_with:rooms|array|min:1',
            'rooms.*.facilities.*'     => 'required|string|max:100',
            'rooms.*.image_cover'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            // ID kamar existing yang diedit
            'rooms.*.id'               => 'nullable|integer|exists:hotel_rooms,id',
        ]);

        DB::transaction(function () use ($request, $hotel) {

            // Update cover hotel
            $imagePath = $hotel->image_cover;
            if ($request->hasFile('image_cover')) {
                if ($imagePath) Storage::disk('public')->delete($imagePath);
                $imagePath = $request->file('image_cover')->store('hotels/covers', 'public');
            }

            $hotel->update([
                'name'          => $request->name,
                'address'       => $request->address,
                'phone'         => $request->phone,
                'start_price'   => $request->start_price,
                'facilities'    => $request->facilities,
                'checkin_time'  => $request->checkin_time,
                'checkout_time' => $request->checkout_time,
                'description'   => $request->description,
                'notes'         => $request->notes,
                'image_cover'   => $imagePath,
            ]);

            // Kumpulkan ID kamar yang masih ada di form (untuk tahu mana yang dihapus)
            $submittedRoomIds = collect($request->rooms ?? [])
                ->pluck('id')
                ->filter()
                ->map(fn($id) => (int) $id)
                ->toArray();

            // Hapus kamar yang sudah tidak ada di form
            $hotel->rooms->each(function (HotelRoom $room) use ($submittedRoomIds) {
                if (!in_array($room->id, $submittedRoomIds)) {
                    if ($room->image_cover) {
                        Storage::disk('public')->delete($room->image_cover);
                    }
                    $room->delete();
                }
            });

            // Update atau buat kamar
            foreach ($request->rooms ?? [] as $index => $roomData) {
                $roomImagePath = null;

                if ($request->hasFile("rooms.{$index}.image_cover")) {
                    // Jika kamar existing, hapus cover lama dulu
                    if (!empty($roomData['id'])) {
                        $existingRoom = HotelRoom::find($roomData['id']);
                        if ($existingRoom && $existingRoom->image_cover) {
                            Storage::disk('public')->delete($existingRoom->image_cover);
                        }
                    }
                    $roomImagePath = $request->file("rooms.{$index}.image_cover")
                                             ->store('hotels/rooms', 'public');
                }

                $roomPayload = [
                    'hotel_id'   => $hotel->id,
                    'name'       => $roomData['name'],
                    'max_guests' => $roomData['max_guests'],
                    'price'      => $roomData['price'],
                    'facilities' => $roomData['facilities'],
                ];

                if ($roomImagePath) {
                    $roomPayload['image_cover'] = $roomImagePath;
                }

                if (!empty($roomData['id'])) {
                    // Update kamar existing
                    HotelRoom::where('id', $roomData['id'])
                             ->where('hotel_id', $hotel->id)
                             ->update($roomPayload);
                } else {
                    // Kamar baru
                    HotelRoom::create($roomPayload);
                }
            }
        });

        return redirect()->route('hotels.index')
                         ->with('success', 'Hotel berhasil diupdate!');
    }

    // -------------------------------------------------------
    // Hapus hotel
    // -------------------------------------------------------
    public function destroy(Hotel $hotel)
    {
        $isOwner = $hotel->id_author === Auth::id();
        $isAdmin = in_array(Auth::user()->role, ['admin', 'superadmin']);

        if (!$isOwner && !$isAdmin) {
            abort(403, 'Unauthorized action.');
        }
        if ($isOwner && $hotel->banned) {
            abort(403, 'Hotel ini sedang dibanned dan tidak dapat dihapus.');
        }

        // Hapus cover hotel
        if ($hotel->image_cover) {
            Storage::disk('public')->delete($hotel->image_cover);
        }

        $this->deleteContentImages($hotel->description ?? '');

        // Hapus semua cover kamar
        $hotel->rooms->each(function (HotelRoom $room) {
            if ($room->image_cover) {
                Storage::disk('public')->delete($room->image_cover);
            }
        });

        $hotel->delete(); // rooms terhapus otomatis via cascade

        return redirect()->route('hotels.index')
                         ->with('success', 'Hotel berhasil dihapus!');
    }

    // -------------------------------------------------------
    // Upload gambar konten Summernote
    // -------------------------------------------------------
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
        ]);

        $path = $request->file('file')->store('hotels/content-images', 'public');

        return response()->json([
            'url' => asset('storage/' . $path),
        ]);
    }

    // -------------------------------------------------------
    // Ban & Unban
    // -------------------------------------------------------
    public function ban(Hotel $hotel)
    {
        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Unauthorized action.');
        }

        $hotel->update(['banned' => true]);
        return redirect()->back()->with('success', 'Hotel berhasil dibanned!');
    }

    public function unban(Hotel $hotel)
    {
        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Unauthorized action.');
        }

        $hotel->update(['banned' => false]);
        return redirect()->back()->with('success', 'Hotel berhasil diunban!');
    }
}