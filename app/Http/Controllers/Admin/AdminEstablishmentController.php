<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminEstablishmentController extends Controller
{
    public function index(Request $request)
    {
	$query = Establishment::query()->with('businessAccount');

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        $establishments = $query->orderByDesc('created_at')->get();

        return view('admin.establishments.index', [
            'establishments' => $establishments,
            'statusFilter' => $request->query('status'),
        ]);
    }

    public function approve(Establishment $establishment): RedirectResponse
    {
        $establishment->status = 'approved';
        $establishment->rejection_reason = null;
        $establishment->save();

        return back()->with('status', $establishment->name.' onaylandı.');
    }

    public function reject(Request $request, Establishment $establishment): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ]);

        $establishment->status = 'rejected';
        $establishment->rejection_reason = $validated['rejection_reason'];
        $establishment->save();

        return back()->with('status', $establishment->name.' reddedildi.');
    }
}
