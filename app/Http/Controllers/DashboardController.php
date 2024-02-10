<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // $data = array(
        //     'title' => 'Home Page'
        // );

        return view('pages-mahasiswa.dashboard');
    }

}
