<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryPreapproval;
use App\Models\DeliveryCompany;
use App\Models\Notification;
use Auth;
use Carbon\Carbon;

class DeliveryPreapprovalController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'resident') {
            $deliveries = DeliveryPreapproval::where('resident_id', $user->id)
                ->latest()->get();
        } elseif ($user->role === 'security') {
            $deliveries = DeliveryPreapproval::whereIn('status', ['expected', 'inside'])
                ->latest()->get();
        } else {
            $deliveries = DeliveryPreapproval::latest()->get();
        }

        return view('admin.delivery.index', compact('deliveries'));
    }

    public function create()
    {
        $companies = DeliveryCompany::where('is_active', 1)->get();
        return view('admin.delivery.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:one_time,frequent',
            'delivery_company_id' => 'required',
            'expected_time' => 'required_if:type,one_time',
            'days_of_week' => 'required_if:type,frequent',
            'validity_months' => 'required_if:type,frequent',
            'time_from' => 'required_if:type,frequent',
            'time_to' => 'required_if:type,frequent',
            'entries_per_day' => 'required_if:type,frequent',
        ]);

        $user = Auth::user();
        $company = DeliveryCompany::find($request->delivery_company_id);

        $data = [
            'resident_id' => $user->id,
            'flat_no' => optional($user->flat)->flat_no,
            'delivery_company_id' => $company->id,
            'delivery_company_name' => $company->name,
            'type' => $request->type,
            'status' => 'expected',
            'surprise_delivery' => $request->surprise_delivery ?? 0,
        ];

        if ($request->type === 'one_time') {
            $data['expected_time'] = (int) $request->expected_time;
        }

        if ($request->type === 'frequent') {
            $from = Carbon::parse($request->time_from);
            $to = Carbon::parse($request->time_to);

            $data['expected_time'] = $from->diffInMinutes($to);
            $data['days_of_week'] = $request->days_of_week;
            $data['validity_months'] = $request->validity_months;
            $data['time_from'] = $request->time_from;
            $data['time_to'] = $request->time_to;
            $data['entries_per_day'] = $request->entries_per_day;
        }

        $delivery = DeliveryPreapproval::create($data);

        // 🔔 Notify Security
        Notification::create([
            'resident_id' => $user->id,
            'reference_id' => $delivery->id,
            'type' => 'delivery',
            'title' => 'Delivery Expected',
            'message' => 'Delivery expected for Flat ' . $data['flat_no'],
            'audience' => 'security',
            'is_read' => 0,
        ]);

        return redirect()->route('delivery.index')
            ->with('success', 'Delivery entry added successfully');
    }
}
