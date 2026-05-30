<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Hotel\Hotel;
use App\Models\Hotel\HotelLink;
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
    // Simpan hotel baru (beserta kamar-kamarnya & links)
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

            // Links
            'links'                    => 'nullable|array',
            'links.*.label'            => 'required_with:links|string|max:100',
            'links.*.url'              => 'required_with:links|url|max:2048',
            'links.*.image_cover'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
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

            // Simpan links
            if ($request->has('links')) {
                foreach ($request->links as $index => $link) {
                    $linkImagePath = null;
                    if ($request->hasFile("links.{$index}.image_cover")) {
                        $linkImagePath = $request->file("links.{$index}.image_cover")
                                                  ->store('hotels/links', 'public');
                    }

                    HotelLink::create([
                        'hotel_id'    => $hotel->id,
                        'label'       => $link['label'],
                        'url'         => $link['url'],
                        'image_cover' => $linkImagePath,
                        'sort_order'  => $index,
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

        $hotel->load('rooms', 'links');
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

            // Rooms
            'rooms'                    => 'nullable|array',
            'rooms.*.name'             => 'required_with:rooms|string|max:255',
            'rooms.*.max_guests'       => 'required_with:rooms|integer|min:1',
            'rooms.*.price'            => 'required_with:rooms|numeric|min:0',
            'rooms.*.facilities'       => 'required_with:rooms|array|min:1',
            'rooms.*.facilities.*'     => 'required|string|max:100',
            'rooms.*.image_cover'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'rooms.*.id'               => 'nullable|integer|exists:hotel_rooms,id',

            // Links
            'links'                    => 'nullable|array',
            'links.*.label'            => 'required_with:links|string|max:100',
            'links.*.url'              => 'required_with:links|url|max:2048',
            'links.*.image_cover'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'links.*.id'               => 'nullable|integer|exists:hotel_links,id',
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

            // ── Rooms ──────────────────────────────────────────────
            $submittedRoomIds = collect($request->rooms ?? [])
                ->pluck('id')->filter()->map(fn($id) => (int) $id)->toArray();

            $hotel->rooms->each(function (HotelRoom $room) use ($submittedRoomIds) {
                if (!in_array($room->id, $submittedRoomIds)) {
                    if ($room->image_cover) Storage::disk('public')->delete($room->image_cover);
                    $room->delete();
                }
            });

            foreach ($request->rooms ?? [] as $index => $roomData) {
                $roomImagePath = null;
                if ($request->hasFile("rooms.{$index}.image_cover")) {
                    if (!empty($roomData['id'])) {
                        $existing = HotelRoom::find($roomData['id']);
                        if ($existing?->image_cover) Storage::disk('public')->delete($existing->image_cover);
                    }
                    $roomImagePath = $request->file("rooms.{$index}.image_cover")->store('hotels/rooms', 'public');
                }

                $roomPayload = [
                    'hotel_id'   => $hotel->id,
                    'name'       => $roomData['name'],
                    'max_guests' => $roomData['max_guests'],
                    'price'      => $roomData['price'],
                    'facilities' => $roomData['facilities'],
                ];
                if ($roomImagePath) $roomPayload['image_cover'] = $roomImagePath;

                if (!empty($roomData['id'])) {
                    HotelRoom::where('id', $roomData['id'])->where('hotel_id', $hotel->id)->update($roomPayload);
                } else {
                    HotelRoom::create($roomPayload);
                }
            }

            // ── Links ──────────────────────────────────────────────
            $submittedLinkIds = collect($request->links ?? [])
                ->pluck('id')->filter()->map(fn($id) => (int) $id)->toArray();

            // Hapus link yang sudah tidak ada di form
            $hotel->links->each(function (HotelLink $link) use ($submittedLinkIds) {
                if (!in_array($link->id, $submittedLinkIds)) {
                    if ($link->image_cover) Storage::disk('public')->delete($link->image_cover);
                    $link->delete();
                }
            });

            // Update atau buat link
            foreach ($request->links ?? [] as $index => $linkData) {
                $linkImagePath = null;
                if ($request->hasFile("links.{$index}.image_cover")) {
                    if (!empty($linkData['id'])) {
                        $existing = HotelLink::find($linkData['id']);
                        if ($existing?->image_cover) Storage::disk('public')->delete($existing->image_cover);
                    }
                    $linkImagePath = $request->file("links.{$index}.image_cover")->store('hotels/links', 'public');
                }

                $linkPayload = [
                    'hotel_id'   => $hotel->id,
                    'label'      => $linkData['label'],
                    'url'        => $linkData['url'],
                    'sort_order' => $index,
                ];
                if ($linkImagePath) $linkPayload['image_cover'] = $linkImagePath;

                if (!empty($linkData['id'])) {
                    HotelLink::where('id', $linkData['id'])->where('hotel_id', $hotel->id)->update($linkPayload);
                } else {
                    HotelLink::create($linkPayload);
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

        if (!$isOwner && !$isAdmin) abort(403, 'Unauthorized action.');
        if ($isOwner && $hotel->banned) abort(403, 'Hotel ini sedang dibanned dan tidak dapat dihapus.');

        if ($hotel->image_cover) Storage::disk('public')->delete($hotel->image_cover);
        $this->deleteContentImages($hotel->description ?? '');

        $hotel->rooms->each(function (HotelRoom $room) {
            if ($room->image_cover) Storage::disk('public')->delete($room->image_cover);
        });

        // Hapus cover semua links
        $hotel->links->each(function (HotelLink $link) {
            if ($link->image_cover) Storage::disk('public')->delete($link->image_cover);
        });

        $hotel->delete(); // cascade: rooms & links terhapus otomatis

        return redirect()->route('hotels.index')->with('success', 'Hotel berhasil dihapus!');
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

        return response()->json(['url' => asset('storage/' . $path)]);
    }

    // -------------------------------------------------------
    // Ban & Unban
    // -------------------------------------------------------
    public function ban(Hotel $hotel)
    {
        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) abort(403, 'Unauthorized action.');
        $hotel->update(['banned' => true]);
        return redirect()->back()->with('success', 'Hotel berhasil dibanned!');
    }

    public function unban(Hotel $hotel)
    {
        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) abort(403, 'Unauthorized action.');
        $hotel->update(['banned' => false]);
        return redirect()->back()->with('success', 'Hotel berhasil diunban!');
    }
}