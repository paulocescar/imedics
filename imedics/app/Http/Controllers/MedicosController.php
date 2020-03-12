<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MedicosController extends Controller
{
    public function medicos(){
        return view('medicos');
    }
}
