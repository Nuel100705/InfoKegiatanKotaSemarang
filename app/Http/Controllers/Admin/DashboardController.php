<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'admin' => Session::get('admin'),
            'totalCategories' => Category::count(),
            'totalEvents' => Event::count(),
            'eventsWithImage' => Event::whereNotNull('image')->count(),
            'eventsWithVideo' => Event::whereNotNull('video')->count(),
        ]);
    }
}
