<?php

namespace App\Http\Controllers\Restaurant;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantRatingController extends BaseController
{
    /** POST /restoran/{restaurant}/rating */
    public function store(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'score' => 'required|integer|min:1|max:5',
        ]);

        RestaurantRating::updateOrCreate(
            [
                'restaurant_id' => $restaurant->id,
                'user_id'       => Auth::id(),
            ],
            ['score' => $request->score]
        );

        $restaurant->recalculateRating();

        return redirect(route('restaurants.detail', $restaurant->id) . '#rating-section')
            ->with('success', 'Rating berhasil disimpan!');
    }
}