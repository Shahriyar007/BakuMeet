<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessAccount;
use App\Models\Establishment;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $pendingAccounts = BusinessAccount::where('status', 'pending')->count();
        $pendingEstablishments = Establishment::where('status', 'pending')->count();
        $totalEstablishments = Establishment::count();
        $totalAccounts = BusinessAccount::count();

        return view('admin.dashboard', [
            'pendingAccounts' => $pendingAccounts,
            'pendingEstablishments' => $pendingEstablishments,
            'totalEstablishments' => $totalEstablishments,
            'totalAccounts' => $totalAccounts,
        ]);
    }
}
