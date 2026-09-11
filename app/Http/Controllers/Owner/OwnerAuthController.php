<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\BusinessAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class OwnerAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('owner.auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:business_accounts,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        BusinessAccount::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'status' => 'pending',
        ]);

        return redirect()->route('owner.login')
            ->with('status', 'Başvurunuz alındı. İncelendikten sonra size bildirim yapılacaktır.');
    }

    public function showLoginForm()
    {
        return view('owner.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $account = BusinessAccount::where('email', $credentials['email'])->first();

        if (! $account || ! Hash::check($credentials['password'], $account->password)) {
            throw ValidationException::withMessages([
                'email' => 'Girdiğiniz bilgiler kayıtlarımızla eşleşmiyor.',
            ]);
        }

        if (! $account->isApproved()) {
            throw ValidationException::withMessages([
                'email' => 'Başvurunuz inceleniyor. Onaylandığında bildirim alacaksınız.',
            ]);
        }

        Auth::guard('business')->login($account, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->route('owner.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('business')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('owner.login');
    }
}
