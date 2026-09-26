<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\EstablishmentView;
use Illuminate\Support\Facades\Auth;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        $account = Auth::guard('business')->user()->load([
            'establishment' => function ($query) {
                $query->withCount(['reviews', 'favoritedBy'])->with('tags');
            },
        ]);

        $viewStats = null;

        if ($account->establishment) {
            $establishmentId = $account->establishment->id;

            $viewStats = [
                'today' => EstablishmentView::where('establishment_id', $establishmentId)
                    ->whereDate('viewed_at', now()->toDateString())
                    ->count(),
                'last_3_days' => EstablishmentView::where('establishment_id', $establishmentId)
                    ->where('viewed_at', '>=', now()->subDays(3))
                    ->count(),
                'last_week' => EstablishmentView::where('establishment_id', $establishmentId)
                    ->where('viewed_at', '>=', now()->subWeek())
                    ->count(),
                'last_month' => EstablishmentView::where('establishment_id', $establishmentId)
                    ->where('viewed_at', '>=', now()->subMonth())
                    ->count(),
                'last_3_months' => EstablishmentView::where('establishment_id', $establishmentId)
                    ->where('viewed_at', '>=', now()->subMonths(3))
                    ->count(),
                'total' => EstablishmentView::where('establishment_id', $establishmentId)->count(),
            ];
        }

        return view('owner.dashboard', [
            'account' => $account,
            'establishment' => $account->establishment,
            'viewStats' => $viewStats,
        ]);
    }
}
