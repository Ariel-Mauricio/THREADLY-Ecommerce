<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')
            ->latest();

        if ($request->has('action') && $request->action !== '') {
            $query->where('action', $request->action);
        }

        if ($request->has('user_id') && $request->user_id !== '') {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('date') && $request->date !== '') {
            $query->whereDate('created_at', $request->date);
        }

        $activities = $query->paginate(50);
        
        $actions = ActivityLog::distinct()->pluck('action');

        return view('admin.activity.index', compact('activities', 'actions'));
    }

    public function clear()
    {
        $count = ActivityLog::where('created_at', '<', now()->subDays(30))->delete();
        
        return redirect()->back()->with('success', "Se eliminaron {$count} registros antiguos.");
    }
}
