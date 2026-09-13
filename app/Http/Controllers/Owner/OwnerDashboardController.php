<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
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

        return view('owner.dashboard', [
            'account' => $account,
            'establishment' => $account->establishment,
        ]);
    }
}
