<?php

namespace App\Http\Controllers\Destination;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Destination\Destination;
use App\Models\Destination\DestinationRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DestinationRatingController extends BaseController
{
    /** POST /destinasi/{destination}/rating */
    public function store(Request $request, Destination $destination)
    {
        $request->validate([
            'score' => 'required|integer|min:1|max:5',
        ]);

        DestinationRating::updateOrCreate(
            [
                'destination_id' => $destination->id,
                'user_id'        => Auth::id(),
            ],
            ['score' => $request->score]
        );

        $destination->recalculateRating();

        return redirect()
            ->route('destinations.detail', $destination->id)
            ->with('success', 'Rating berhasil disimpan!');
    }
}