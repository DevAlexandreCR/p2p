<?php

namespace App\Http\Controllers;

use App\Constants\Permissions;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * @return View
     * @throws AuthorizationException
     */
    public function main(): View
    {
        $this->authorize(Permissions::VIEW_DASHBOARD, request()->user());
        return view('dashboard.dashboard');
    }
}
