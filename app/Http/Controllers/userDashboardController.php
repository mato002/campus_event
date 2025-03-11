<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class userDashboardController extends Controller
{
    public function index()
    {
        return view('home'); // or any other view you want to return
    }
}
