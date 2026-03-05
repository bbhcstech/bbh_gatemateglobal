<?php

namespace App\Http\Controllers;

use App\Models\HelpPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HelpPaymentController extends Controller
{
    public function index()
    {
        $payments = DB::table('help_payments')->latest()->get();
        return view('admin.help.payments.index', compact('payments'));
    }
    
    public function create()
    {
        return view('admin.help.payments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'mobile'      => 'required|string|max:15',
            'amount'      => 'required|numeric|min:1',
            'payment_mode'=> 'required',
            'remarks'     => 'nullable|string'
        ]);

        DB::table('help_payments')->insert([
            'name'         => $request->name,
            'mobile'       => $request->mobile,
            'amount'       => $request->amount,
            'payment_mode' => $request->payment_mode,
            'notes'      => $request->remarks,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return redirect()
            ->route('help.payments.index')
            ->with('success', 'Payment added successfully');
    }
}
