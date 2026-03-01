<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Dashboard home.
     */
    public function __invoke(): View
    {
        return view('dashboard.index');
    }
}
