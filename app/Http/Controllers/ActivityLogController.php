<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = DB::select("
            SELECT a.*, u.username
            FROM activity_logs a
            LEFT JOIN users u ON a.id_user = u.id_user
            ORDER BY a.created_at DESC
        ");

        return view('activity_logs.index', compact('logs'));
    }
}
