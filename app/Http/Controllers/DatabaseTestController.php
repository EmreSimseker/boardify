<?php

namespace App\Http\Controllers;

use App\Services\Database\Conn;

class DatabaseTestController extends Controller
{
    public function index()
    {
        $connInstance = Conn::getInstance();
        $connection = $connInstance->getConnection();
        $connected = $connection ? true : false;

        return view('welcome', compact('connected'));
    }
}
