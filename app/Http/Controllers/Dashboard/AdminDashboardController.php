<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Article\Article;
use App\Models\Destination\Destination;
use App\Models\Hotel\Hotel;
use App\Models\Restaurant\Restaurant;
use App\Models\Company\CompanyRequest;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ─── Summary Cards ────────────────────────────────────────────────
        $stats = [
            'total_users'        => User::count(),
            'total_destinations' => Destination::count(),
            'total_hotels'       => Hotel::count(),
            'total_restaurants'  => Restaurant::count(),
            'total_articles'     => Article::count(),
            'pending_requests'   => CompanyRequest::where('status', 'pending')->count(),
        ];

        // ─── Content Growth (last 6 months) ───────────────────────────────
        $months = collect(range(5, 0))->map(fn($i) => now()->subMonths($i));

        $monthLabels = $months->map(fn($m) => $m->format('M Y'))->values();

        $contentGrowth = [
            'labels'       => $monthLabels,
            'destinations' => $months->map(fn($m) => Destination::whereYear('created_at', $m->year)
                ->whereMonth('created_at', $m->month)->count())->values(),
            'hotels'       => $months->map(fn($m) => Hotel::whereYear('created_at', $m->year)
                ->whereMonth('created_at', $m->month)->count())->values(),
            'restaurants'  => $months->map(fn($m) => Restaurant::whereYear('created_at', $m->year)
                ->whereMonth('created_at', $m->month)->count())->values(),
            'articles'     => $months->map(fn($m) => Article::whereYear('created_at', $m->year)
                ->whereMonth('created_at', $m->month)->count())->values(),
        ];

        // ─── Average Ratings ──────────────────────────────────────────────
        $avgRatings = [
            'labels' => ['Destinasi', 'Hotel', 'Restoran'],
            'data'   => [
                round(Destination::avg('rating') ?? 0, 2),
                round(Hotel::avg('rating') ?? 0, 2),
                round(Restaurant::avg('rating') ?? 0, 2),
            ],
        ];

        // ─── Company Request Status (Donut) ───────────────────────────────
        $requestStatus = CompanyRequest::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $companyRequestChart = [
            'labels' => ['Pending', 'Approved', 'Rejected'],
            'data'   => [
                $requestStatus['pending']  ?? 0,
                $requestStatus['approved'] ?? 0,
                $requestStatus['rejected'] ?? 0,
            ],
        ];

        // ─── Company Request Field Breakdown (Bar) ────────────────────────
        $fieldBreakdown = CompanyRequest::select('field', DB::raw('count(*) as total'))
            ->groupBy('field')
            ->pluck('total', 'field');

        $companyFieldChart = [
            'labels' => ['Restaurant', 'Destination', 'Hotel'],
            'data'   => [
                $fieldBreakdown['restaurant']  ?? 0,
                $fieldBreakdown['destination'] ?? 0,
                $fieldBreakdown['hotel']       ?? 0,
            ],
        ];

        // ─── User Growth (last 6 months) ──────────────────────────────────
        $userGrowth = [
            'labels' => $monthLabels,
            'data'   => $months->map(fn($m) => User::whereYear('created_at', $m->year)
                ->whereMonth('created_at', $m->month)->count())->values(),
        ];

        // ─── Top Rated Destinations ───────────────────────────────────────
        $topDestinations = Destination::where('banned', false)
            ->orderByDesc('rating')
            ->limit(5)
            ->get(['title', 'rating', 'rating_count']);

        // ─── Top Rated Hotels ─────────────────────────────────────────────
        $topHotels = Hotel::where('banned', false)
            ->orderByDesc('rating')
            ->limit(5)
            ->get(['name', 'rating', 'rating_count']);

        // ─── Top Rated Restaurants ────────────────────────────────────────
        $topRestaurants = Restaurant::where('banned', false)
            ->orderByDesc('rating')
            ->limit(5)
            ->get(['name', 'rating', 'rating_count']);

        // ─── Banned Content Count ─────────────────────────────────────────
        $bannedStats = [
            'destinations' => Destination::where('banned', true)->count(),
            'hotels'       => Hotel::where('banned', true)->count(),
            'restaurants'  => Restaurant::where('banned', true)->count(),
        ];

        return view('admin', compact(
            'stats',
            'contentGrowth',
            'avgRatings',
            'companyRequestChart',
            'companyFieldChart',
            'userGrowth',
            'topDestinations',
            'topHotels',
            'topRestaurants',
            'bannedStats',
        ));
    }
}