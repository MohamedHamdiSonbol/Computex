<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View {
        $lang = get_active_lang();
        $languages = get_active_languages();

        return view('admin.dashboard')->with(compact('lang',  'languages'));
    }
}
