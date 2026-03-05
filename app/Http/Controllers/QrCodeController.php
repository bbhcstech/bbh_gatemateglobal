<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeGenerator;

class QrCodeController extends Controller
{
    /**
     * Show all QR Codes
     */
    public function index()
    {
        $qrcodes = QrCode::latest()->paginate(10);
        return view('qrcodes.index', compact('qrcodes'));
    }

    /**
     * Show form to create new QR
     */
    public function create()
    {
        return view('qrcodes.create');
    }

    /**
     * Store new QR Code
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'nullable|string|max:255',
            'category'  => 'nullable|string|max:255',
            'type'      => 'required|string|in:url,text,wifi,map,whatsapp,pdf',
            'payload'   => 'required',
            'size'      => 'nullable|integer|min:100|max:1000',
            'foreground'=> 'nullable|string',
            'background'=> 'nullable|string',
        ]);

        $size = $request->input('size', 300);

        // Generate QR Code image
        $qrImage = QrCodeGenerator::format('png')
            ->size($size)
            ->errorCorrection('H')
            ->color(0,0,0)
            ->backgroundColor(255,255,255)
            ->generate($request->payload);

        // Save QR Code file in storage
        $fileName = 'qrcodes/' . uniqid() . '.png';
        Storage::disk('public')->put($fileName, $qrImage);

        // Store DB record
        $qr = QrCode::create([
            'user_id'   => auth()->id() ?? null,
            'name'      => $request->name,
            'category'  => $request->category,
            'type'      => $request->type,
            'payload'   => $request->payload,
            'size'      => $size,
            'file_path' => $fileName,
            'foreground'=> $request->foreground,
            'background'=> $request->background,
        ]);

        return redirect()->route('qrcodes.index')
            ->with('success', 'QR Code generated successfully!');
    }

    /**
     * Show a QR Code
     */
    public function show(QrCode $qrcode)
    {
        return view('qrcodes.show', compact('qrcode'));
    }

    /**
     * Delete a QR Code
     */
    public function destroy(QrCode $qrcode)
    {
        if ($qrcode->file_path && Storage::disk('public')->exists($qrcode->file_path)) {
            Storage::disk('public')->delete($qrcode->file_path);
        }
        $qrcode->delete();

        return redirect()->route('qrcodes.index')
            ->with('success', 'QR Code deleted successfully!');
    }
}
