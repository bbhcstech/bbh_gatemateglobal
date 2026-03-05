<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::latest()->paginate(20);

        return view('admin.security.activity', compact('logs'));
    }
}
