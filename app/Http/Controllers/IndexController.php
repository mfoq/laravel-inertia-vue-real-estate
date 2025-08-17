<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        return Inertia('Index/Index',
            props: [
                "message" => "hello from laravel vue"
            ]);
    }
    public function show()
    {
         return Inertia(component: 'Index/Show');
    }
}
