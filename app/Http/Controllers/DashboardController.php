<?php

namespace App\Http\Controllers;

use App\Constants\Permissions;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function main(): View
    {
        $this->authorize(Permissions::VIEW_DASHBOARD, request()->user());
        return view('dashboard.dashboard');
    }
}
