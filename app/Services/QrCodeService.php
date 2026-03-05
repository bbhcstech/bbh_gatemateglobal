<?php
namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode as QR;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class QrCodeService
{
    public function buildContent(string $type, array $data): string
    {
        return match (true) {
            in_array($type, ['url','app']) => $data['url'],
            $type === 'text' => $data['text'],
            $type === 'wifi' => $this->wifiString($data),
            $type === 'map' => $this->geoString($data),
            $type === 'whatsapp' => $this->waString($data),
            in_array($type, ['pdf','audio']) => $data['public_url'] ?? $data['url'] ?? '',
            default => '',
        };
    }

    protected function wifiString(array $d): string
    {
        $hidden = !empty($d['hidden']) ? 'true' : 'false';
        $enc = $d['encryption'] === 'nopass' ? '' : $d['encryption'];
        return "WIFI:T:{$enc};S:{$d['ssid']};P:{$d['password'] ?? ''};H:{$hidden};;";
    }

    protected function geoString(array $d): string
    {
        $lat = $d['lat']; 
        $lng = $d['lng'];
        return "geo:{$lat},{$lng}";
    }

    protected function waString(array $d): string
    {
        $phone = preg_replace('/[^0-9]/','',$d['phone']);
        $text = isset($d['message']) ? rawurlencode($d['message']) : '';
        return $text ? "https://wa.me/{$phone}?text={$text}" : "https://wa.me/{$phone}";
    }

    /**
     * Generate and store QR image, optionally overlaying a center logo (PNG only).
     * Returns relative storage path like "qrs/abc.png".
     */
    public function generateAndStore(string $content, array $opts = [], ?string $logoTmpPath = null): string
    {
        // Default options
        $size   = $opts['size'] ?? 400;
        $margin = $opts['margin'] ?? 2;
        $color  = $opts['color'] ?? [0, 0, 0];     // black
        $bg     = $opts['bg'] ?? [255, 255, 255]; // white

        // Generate QR image raw data (PNG)
        $qrPng = QR::format('png')
            ->size($size)
            ->margin($margin)
            ->color($color[0], $color[1], $color[2])
            ->backgroundColor($bg[0], $bg[1], $bg[2])
            ->generate($content);

        // Convert QR to Intervention Image
        $qrImage = Image::make($qrPng);

        // If logo provided, merge in center
        if ($logoTmpPath && file_exists($logoTmpPath)) {
            $logo = Image::make($logoTmpPath);

            // Resize logo to fit inside QR (e.g., 20%)
            $logoSize = intval($size * 0.2);
            $logo->resize($logoSize, $logoSize, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $x = intval(($qrImage->width() - $logo->width()) / 2);
            $y = intval(($qrImage->height() - $logo->height()) / 2);

            $qrImage->insert($logo, 'top-left', $x, $y);
        }

        // Build file name & save
        $fileName = 'qrs/' . Str::random(20) . '.png';

        Storage::disk('public')->put($fileName, (string) $qrImage->encode('png', 90));

        return $fileName;
    }
}
