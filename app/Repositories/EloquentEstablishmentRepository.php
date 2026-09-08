public function getAllWithCoordinates(): Collection
{
    return Establishment::whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->get();
}
