<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HealthController extends Controller
{
    public function index()
    {
        $db = DB::connection()->getPdo() ? 'ok' : 'fail';
        return response()->json([
            'app' => 'ok',
            'db' => $db,
            'time' => now()->toISOString(),
        ]);
    }
}
