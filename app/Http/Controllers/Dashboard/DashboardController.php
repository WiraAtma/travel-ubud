<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Destination\Destination;

class DashboardController extends Controller
{
    public function index()
    {
        $topDestinations = Destination::orderByDesc('rating')
                            ->take(4)
                            ->get();

        return view('dashboard', compact('topDestinations'));
    }
}
