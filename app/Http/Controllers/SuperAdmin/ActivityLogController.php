<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user:id,name,avatar')
            ->orderBy('created_at', 'desc');

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->paginate(30);

        return view('superadmin.activity-logs.index', compact('logs'));
    }

    public function clear()
    {
        $count = ActivityLog::where('created_at', '<', now()->subDays(30))->count();
        ActivityLog::where('created_at', '<', now()->subDays(30))->delete();

        ActivityLog::log(ActivityLog::ACTION_DELETE, "Menghapus {$count} log aktivitas lama");

        return back()->with('success', "{$count} log aktivitas berhasil dihapus!");
    }
}
