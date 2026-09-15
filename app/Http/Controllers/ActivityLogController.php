<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    // Menampilkan semua log aktivitas
    public function index()
    {
        $activityLogs = ActivityLog::with('user')
            ->latest()
            ->get();

        return view('admin.activity-log.index', compact('activityLogs'));
    }
}