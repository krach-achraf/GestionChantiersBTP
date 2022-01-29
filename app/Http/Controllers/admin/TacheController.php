<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TacheController extends Controller
{
    public function addtache(){
        return view('admin.tache');
    }
    public function showTaches(){
        return view('admin.tache');
    }
}
