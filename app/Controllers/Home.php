<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/customer');  // Dashboard tujuan setelah login
        }

        return view('home/index');  // Halaman welcome untuk pengunjung belum login
    }
}
