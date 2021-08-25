<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function demo(string $value)
    {
        return view('demo', [
            'value' => $value
        ]);
    }

    public function npm()
    {
        return view('npm');
    }
}
