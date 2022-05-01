<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bulletinboard;

class BulletinboardController extends Controller
{
    public function index(Request $request)
    {
        $items = Bulletinboard::all();
        return view('Bulletinboard.index',['items' => $items]);
    }
}
