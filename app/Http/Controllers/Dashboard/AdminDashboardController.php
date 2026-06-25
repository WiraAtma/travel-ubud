<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Article\Article;
use App\Models\Destination\Destination;
use App\Models\Hotel\Hotel;
use App\Models\Restaurant\Restaurant;
use App\Models\Company\CompanyRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $user        = auth()->user();
        $isAdmin     = in_array($user->role, ['admin', 'superadmin']);
        $isCompany   = $user->role === 'company';
        $companyRole = $user->company_role ?? null;

        $canDestination = $isAdmin || ($isCompany && $companyRole === 'destination');
        $canRestaurant  = $isAdmin || ($isCompany && $companyRole === 'restaurant');
        $canHotel       = $isAdmin || ($isCompany && $companyRole === 'hotel');
        $canCompanyReq  = $isAdmin;

        // ─── Cache key per role agar data tidak mix antar user ───────────
        $cacheKey = "admin_dashboard_{$user->role}_{$companyRole}";

        $data = Cache::remember($cacheKey, now()->addMinutes(10), function () use (
            $isAdmin, $canDestination, $canRestaurant, $canHotel, $canCompanyReq
        ) {
            return $this->buildDashboardData(
                $isAdmin, $canDestination, $canRestaurant, $canHotel, $canCompanyReq
            );
        });

        return view('admin', array_merge($data, compact('user')));
    }

    private function buildDashboardData($isAdmin, $canDestination, $canRestaurant, $canHotel, $canCompanyReq): array
    {
        // ─── Summary Cards ────────────────────────────────────────────────
        $stats = [];
        if ($isAdmin)        $stats['total_users']        = User::count();
        if ($canDestination) $stats['total_destinations'] = Destination::count();
        if ($canHotel)       $stats['total_hotels']       = Hotel::count();
        if ($canRestaurant)  $stats['total_restaurants']  = Restaurant::count();
        $stats['total_articles']   = Article::count();
        if ($canCompanyReq)  $stats['pending_requests']   = CompanyRequest::where('status', 'pending')->count();

        // ─── Content Growth — 1 query per model pakai GROUP BY ────────────
        // Ganti 24 query menjadi max 4 query
        $startDate = now()->subMonths(5)->startOfMonth();

        $contentGrowth = ['labels' => [], 'destinations' => [], 'hotels' => [], 'restaurants' => [], 'articles' => []];
        $months = collect(range(5, 0))->map(fn($i) => now()->subMonths($i));
        $contentGrowth['labels'] = $months->map(fn($m) => $m->format('M Y'))->values();

        // Helper: satu query GROUP BY year/month
        $growthQuery = fn($model) => $model::where('created_at', '>=', $startDate)
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('year', 'month')
            ->get()
            ->keyBy(fn($r) => "{$r->year}-{$r->month}");

        $mapToMonths = fn($rows) => $months->map(
            fn($m) => $rows->get("{$m->year}-{$m->month}")?->total ?? 0
        )->values();

        if ($canDestination) $contentGrowth['destinations'] = $mapToMonths($growthQuery(Destination::class));
        if ($canHotel)       $contentGrowth['hotels']       = $mapToMonths($growthQuery(Hotel::class));
        if ($canRestaurant)  $contentGrowth['restaurants']  = $mapToMonths($growthQuery(Restaurant::class));
        $contentGrowth['articles'] = $mapToMonths($growthQuery(Article::class));

        $avgRatings = ['labels' => [], 'data' => []];
        if ($canDestination) { $avgRatings['labels'][] = 'Destinasi'; $avgRatings['data'][] = round(Destination::avg('rating') ?? 0, 2); }
        if ($canHotel)       { $avgRatings['labels'][] = 'Hotel';     $avgRatings['data'][] = round(Hotel::avg('rating') ?? 0, 2); }
        if ($canRestaurant)  { $avgRatings['labels'][] = 'Restoran';  $avgRatings['data'][] = round(Restaurant::avg('rating') ?? 0, 2); }

        // ─── Company Request Charts — admin only ──────────────────────────
        $companyRequestChart = ['labels' => [], 'data' => []];
        $companyFieldChart   = ['labels' => [], 'data' => []];

        if ($canCompanyReq) {
            // 1 query untuk status
            $requestStatus = CompanyRequest::select('status', DB::raw('count(*) as total'))
                ->groupBy('status')->pluck('total', 'status');

            $companyRequestChart = [
                'labels' => ['Pending', 'Approved', 'Rejected'],
                'data'   => [
                    $requestStatus['pending']  ?? 0,
                    $requestStatus['approved'] ?? 0,
                    $requestStatus['rejected'] ?? 0,
                ],
            ];

            // 1 query untuk field
            $fieldBreakdown = CompanyRequest::select('field', DB::raw('count(*) as total'))
                ->groupBy('field')->pluck('total', 'field');

            $companyFieldChart = [
                'labels' => ['Restaurant', 'Destination', 'Hotel'],
                'data'   => [
                    $fieldBreakdown['restaurant']  ?? 0,
                    $fieldBreakdown['destination'] ?? 0,
                    $fieldBreakdown['hotel']       ?? 0,
                ],
            ];
        }

        // ─── User Growth ──────────────────────────────────────────────────
        $userGrowth = ['labels' => [], 'data' => []];
        if ($isAdmin) {
            $userRows = User::where('created_at', '>=', $startDate)
                ->select(DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
                ->groupBy('year', 'month')->get()
                ->keyBy(fn($r) => "{$r->year}-{$r->month}");

            $userGrowth = [
                'labels' => $contentGrowth['labels'],
                'data'   => $mapToMonths($userRows),
            ];
        }

        // ─── Top Rated — select hanya kolom yang dibutuhkan ──────────────
        $topDestinations = $canDestination
            ? Destination::where('banned', false)->orderByDesc('rating')->limit(5)->get(['title', 'rating', 'rating_count'])
            : collect();

        $topHotels = $canHotel
            ? Hotel::where('banned', false)->orderByDesc('rating')->limit(5)->get(['name', 'rating', 'rating_count'])
            : collect();

        $topRestaurants = $canRestaurant
            ? Restaurant::where('banned', false)->orderByDesc('rating')->limit(5)->get(['name', 'rating', 'rating_count'])
            : collect();

        // ─── Banned Stats — 1 query per model dengan kondisional ─────────
        $bannedStats = ['destinations' => 0, 'hotels' => 0, 'restaurants' => 0];
        if ($isAdmin) {
            // Gabungkan jadi 3 query ringan (sudah minimal)
            $bannedStats = [
                'destinations' => Destination::where('banned', true)->count(),
                'hotels'       => Hotel::where('banned', true)->count(),
                'restaurants'  => Restaurant::where('banned', true)->count(),
            ];
        }

        return compact(
            'stats', 'contentGrowth', 'avgRatings',
            'companyRequestChart', 'companyFieldChart', 'userGrowth',
            'topDestinations', 'topHotels', 'topRestaurants', 'bannedStats'
        );
    }
}