<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgendamentosController extends Controller
{
    public function agendamentos(){
        return view('agendamentos');
    }
}
