<?php

use Illuminate\Support\Facades\DB;

function logActivity($action, $description)
{
    DB::insert("
        INSERT INTO activity_logs (id_user, action, description)
        VALUES (?, ?, ?)
    ", [
        session('id_user'),
        $action,
        $description
    ]);
}
