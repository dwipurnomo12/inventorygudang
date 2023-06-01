<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $log = Activity::latest()->get();
        return view('aktivitas-user.index', [
            'logs' => $log
        ]);
    }

}
