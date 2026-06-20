<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Hotel\Hotel;
use App\Models\Hotel\HotelRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HotelRatingController extends BaseController
{
    /** POST /hotel/{hotel}/rating */
    public function store(Request $request, Hotel $hotel)
    {
        $request->validate([
            'score' => 'required|integer|min:1|max:5',
        ]);

        HotelRating::updateOrCreate(
            [
                'hotel_id' => $hotel->id,
                'user_id'  => Auth::id(),
            ],
            ['score' => $request->score]
        );

        $hotel->recalculateRating();

        return redirect(route('hotels.detail', $hotel->id) . '#rating-section')
            ->with('success', 'Rating berhasil disimpan!');
    }
}