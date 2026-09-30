<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PhotoOptimizer
{
    private const MAX_SIDE = 1600;
    private const QUALITY = 82;

    public function store(UploadedFile $file, string $folder): string
    {
        $raw = file_get_contents($file);
        $ext = $file->getClientOriginalExtension();

        if (function_exists('imagecreatefromstring')) {
            try {
                $src = @imagecreatefromstring($raw);
                if ($src !== false) {
                    $src = $this->fixOrientation($src, $file);
                    $w = imagesx($src);
                    $h = imagesy($src);
                    $scale = min(1, self::MAX_SIDE / max($w, $h));
                    $nw = max(1, (int) round($w * $scale));
                    $nh = max(1, (int) round($h * $scale));

                    $dst = imagecreatetruecolor($nw, $nh);
                    imagefill($dst, 0, 0, imagecolorallocate($dst, 255, 255, 255));
                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);

                    ob_start();
                    imagejpeg($dst, null, self::QUALITY);
                    $raw = ob_get_clean();
                    $ext = 'jpg';

                    imagedestroy($src);
                    imagedestroy($dst);
                }
            } catch (\Throwable $e) {
                report($e);
            }
        }

        $path = $folder.'/'.Str::random(20).'.'.$ext;
        Storage::disk('r2')->put($path, $raw);

        return $path;
    }

    private function fixOrientation($img, UploadedFile $file)
    {
        if (! function_exists('exif_read_data')) {
            return $img;
        }
        $exif = @exif_read_data($file->getRealPath());
        $angle = match ($exif['Orientation'] ?? 1) {
            3 => 180,
            6 => -90,
            8 => 90,
            default => 0,
        };

        return $angle !== 0 ? imagerotate($img, $angle, 0) : $img;
    }
}
