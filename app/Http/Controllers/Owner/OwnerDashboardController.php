<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        $account = Auth::guard('business')->user();

        return view('owner.dashboard', [
            'account' => $account,
            'establishment' => $account->establishment,
        ]);
    }
}
