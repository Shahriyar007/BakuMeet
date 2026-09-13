<?php

namespace App\Http\Controllers\Owner;

use Illuminate\Support\Facades\DB;
use App\Models\EstablishmentPhoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Establishment;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class EstablishmentController extends Controller
{
    private array $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

    public function create()
    {
        $account = Auth::guard('business')->user();

        Gate::forUser($account)->authorize('create', Establishment::class);

        return view('owner.establishments.create', [
            'tags' => Tag::all(),
            'pendingPhotos' => $account->unassignedPhotos,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $account = Auth::guard('business')->user();

        Gate::forUser($account)->authorize('create', Establishment::class);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:cafe,restaurant'],
            'description' => ['nullable', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'mood' => ['required', 'string', 'in:sakin,romantik,canlı,lüks,bütçedostu'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'price_range' => ['required', 'integer', 'min:1', 'max:3'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer', 'exists:tags,id'],
            'photos' => ['nullable', 'array', 'max:5'],
            'photos.*' => ['image', 'max:5120'],
        ]);

        DB::transaction(function () use ($request, $validated, $account) {
            $establishment = Establishment::create([
                'name' => $validated['name'],
                'type' => $validated['type'],
                'description' => $validated['description'] ?? null,
                'location' => $validated['location'],
                'mood' => $validated['mood'],
                'latitude' => $validated['latitude'] ?? null,
                'longitude' => $validated['longitude'] ?? null,
                'price_range' => $validated['price_range'],
                'opening_hours' => $this->buildOpeningHours($request),
                'status' => 'pending',
            ]);

            if (! empty($validated['tags'])) {
                $establishment->tags()->sync($validated['tags']);
            }

            // Attach any photos already uploaded via AJAX before the form was submitted
            $account->unassignedPhotos()->update(['establishment_id' => $establishment->id]);

            // Fallback: legacy synchronous upload path, in case JS was unavailable
            if ($request->hasFile('photos')) {
                $this->storePhotos($request, $establishment);
            }

            $account->establishment_id = $establishment->id;
            $account->save();
        });

        return redirect()->route('owner.dashboard')
            ->with('status', 'İşletmeniz eklendi. Onaylandıktan sonra yayına alınacaktır.');
    }

    public function edit()
    {
        $account = Auth::guard('business')->user();
        $establishment = $account->establishment->load('photos', 'tags');

        Gate::forUser($account)->authorize('update', $establishment);

        return view('owner.establishments.edit', [
            'establishment' => $establishment,
            'tags' => Tag::all(),
            'selectedTagIds' => $establishment->tags->pluck('id')->toArray(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $account = Auth::guard('business')->user();
        $establishment = $account->establishment;

        Gate::forUser($account)->authorize('update', $establishment);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:cafe,restaurant'],
            'description' => ['nullable', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'mood' => ['required', 'string', 'in:sakin,romantik,canlı,lüks,bütçedostu'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'price_range' => ['required', 'integer', 'min:1', 'max:3'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer', 'exists:tags,id'],
            'photos' => ['nullable', 'array', 'max:5'],
            'photos.*' => ['image', 'max:5120'],
        ]);

        DB::transaction(function () use ($request, $validated, $establishment) {
            $establishment->update([
                'name' => $validated['name'],
                'type' => $validated['type'],
                'description' => $validated['description'] ?? null,
                'location' => $validated['location'],
                'mood' => $validated['mood'],
                'latitude' => $validated['latitude'] ?? null,
                'longitude' => $validated['longitude'] ?? null,
                'price_range' => $validated['price_range'],
                'opening_hours' => $this->buildOpeningHours($request),
            ]);

            $establishment->tags()->sync($validated['tags'] ?? []);

            // Fallback: legacy synchronous upload path, in case JS was unavailable
            if ($request->hasFile('photos')) {
                $this->storePhotos($request, $establishment);
            }
        });

        return redirect()->route('owner.dashboard')
            ->with('status', 'İşletme bilgileriniz güncellendi.');
    }

    /**
     * AJAX endpoint: upload a single photo immediately on selection.
     * If the account has no establishment yet (create flow), the photo is
     * stored unassigned (business_account_id set, establishment_id null)
     * and gets attached to the establishment once store() runs.
     * If the account already has an establishment (edit flow), the photo
     * is attached directly.
     */
    public function uploadPhoto(Request $request): JsonResponse
    {
        $account = Auth::guard('business')->user();

        $request->validate([
            'photo' => ['required', 'image', 'max:5120'],
        ]);

        $establishment = $account->establishment;

        if ($establishment) {
            Gate::forUser($account)->authorize('update', $establishment);
        }

        $existingCount = $establishment
            ? $establishment->photos()->count()
            : $account->unassignedPhotos()->count();

        if ($existingCount >= 5) {
            return response()->json([
                'success' => false,
                'message' => 'En fazla 5 fotoğraf yükleyebilirsiniz.',
            ], 422);
        }

        $file = $request->file('photo');
        $ownerSegment = $establishment ? $establishment->id : 'pending-'.$account->id;
        $path = 'establishments/'.$ownerSegment.'/'.Str::random(20).'.'.$file->getClientOriginalExtension();

        try {
            Storage::disk('r2')->put($path, file_get_contents($file));
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Fotoğraf sunucuya yüklenemedi. Lütfen tekrar deneyin.',
            ], 500);
        }

        $hasExistingPrimary = $establishment
            ? $establishment->photos()->where('is_primary', true)->exists()
            : $account->unassignedPhotos()->where('is_primary', true)->exists();

        $photo = EstablishmentPhoto::create([
            'establishment_id' => $establishment?->id,
            'business_account_id' => $establishment ? null : $account->id,
            'path' => $path,
            'is_primary' => ! $hasExistingPrimary,
            'sort_order' => $existingCount,
        ]);

        return response()->json([
            'success' => true,
            'photo_id' => $photo->id,
            'url' => $photo->url(),
        ]);
    }

    public function destroyPhoto(EstablishmentPhoto $photo): RedirectResponse
    {
        $account = Auth::guard('business')->user();
        $establishment = $account->establishment;

        $belongsToEstablishment = $establishment && $photo->establishment_id === $establishment->id;
        $belongsToAccountUnassigned = is_null($photo->establishment_id) && $photo->business_account_id === $account->id;

        abort_if(! $belongsToEstablishment && ! $belongsToAccountUnassigned, 403);

        $wasPrimary = $photo->is_primary;
        $ownerQuery = $belongsToEstablishment
            ? $establishment->photos()
            : $account->unassignedPhotos();

        Storage::disk('r2')->delete($photo->path);
        $photo->delete();

        if ($wasPrimary) {
            $nextPhoto = $ownerQuery->orderBy('sort_order')->first();

            if ($nextPhoto) {
                $nextPhoto->update(['is_primary' => true]);
            }
        }

        return back()->with('status', 'Fotoğraf silindi.');
    }

    private function storePhotos(Request $request, Establishment $establishment): void
    {
        $hasExistingPrimary = $establishment->photos()->where('is_primary', true)->exists();

        foreach ($request->file('photos') as $index => $file) {
            $path = 'establishments/'.$establishment->id.'/'.Str::random(20).'.'.$file->getClientOriginalExtension();

            Storage::disk('r2')->put($path, file_get_contents($file));

            EstablishmentPhoto::create([
                'establishment_id' => $establishment->id,
                'path' => $path,
                'is_primary' => ! $hasExistingPrimary && $index === 0,
                'sort_order' => $establishment->photos()->count(),
            ]);

            $hasExistingPrimary = true;
        }
    }

    private function buildOpeningHours(Request $request): array
    {
        $hours = [];

        foreach ($this->days as $day) {
            if ($request->boolean("closed_{$day}")) {
                $hours[$day] = ['closed' => 1];
                continue;
            }

            $hours[$day] = [
                'open' => $request->input("open_{$day}", '09:00'),
                'close' => $request->input("close_{$day}", '22:00'),
            ];
        }

        return $hours;
    }
}
