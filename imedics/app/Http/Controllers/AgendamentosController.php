<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Agendamentos;
use App\Medicos;
use App\Pacientes;
use Validator;
use Datatables;
use Auth;

class AgendamentosController extends Controller
{
    public function agendamentos(){
        return view('agendamentos.agendamentos');
    }

    public function agendar(){
        $especiliadades = Medicos::get();
        return view('agendamentos.agendar', compact('especiliadades'));
    }

    public function criar(Request $request){

        $paciente = Pacientes::where('user_id','=',Auth::User()->id)->get();

        if($paciente == '[]' || $paciente == null){
            $novoPaciente = new Pacientes();
            $novoPaciente->nome = Auth::User()->name;
            $novoPaciente->user_id = Auth::User()->id;
            if($request->CPF){ $novoPaciente->CPF = $request->CPF; }
            if($request->CNPJ){ $novoPaciente->CNPJ = $request->CNPJ; }
            if($request->sexo){ $novoPaciente->sexo = $request->sexo; }
            $novoPaciente->email = Auth::User()->email;
            if($request->celular){ $novoPaciente->celular = $request->celular; }
            if($request->preferencias){ $novoPaciente->preferencias = $request->preferencias; }
            if($request->preferencias){ $novoPaciente->comunicao = $request->comunicao; }
            $novoPaciente->data_nascimento = $request->data_nascimento;
            if($request->observacao){ $novoPaciente->observacao = $request->observacao; }
            $novoPaciente->save();
        }

        $novoAgendamento = new Agendamentos();
        if($paciente == '[]' || $paciente == null){
            $novoAgendamento->paciente_id = $novoPaciente->id;
        }else{
            $novoAgendamento->paciente_id = $paciente->first()->id;
        }
        $novoAgendamento->medico_id = $request->medico;
        $novoAgendamento->data_agendamento = $request->data_agendamento." ".$request->horario;
        $novoAgendamento->observacao = $request->observacao;
        $novoAgendamento->status = 'M';
        $novoAgendamento->save();

        return redirect('/agendar')->with('success','.');
    }

    public function cancelar(Request $request){

        $cancelarAgendamento = Agendamentos::find($request->id);
        $cancelarAgendamento->status = 'C'; 
        $cancelarAgendamento->save();

        return redirect('/agendamentos');
    }

    public function data(){
        if(Auth::User()->level == "A"){
            $data = Agendamentos::get();
        }else if(Auth::User()->level == "M"){
            $data = Agendamentos::where('medico_id','=',Medicos::where('user_id','=',Auth::User()->id)->get()->first()->id)->get();
        }else{
            $data = Agendamentos::where('paciente_id','=',Pacientes::where('user_id','=',Auth::User()->id)->get()->first()->id)->get();
        }

        $dt = Datatables::of($data);

        if(Auth::User()->level == "A"){
            $dt->addColumn('action', function ($data) {
                
                return '<a href="#edit-'.$data->id.'" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modaleditar">Editar</a>
                <div class="modal fade" id="modaleditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Deseja alterar?</h5>
                    </div>
                        <form action="/medicos/editar" method="post">
                        <div class="container">
                            '.csrf_field().'
                            <input type="hidden" name="id" value="'.$data->id.'">
        
                            <div class="form-group">
                                <label for"nome">Especialidade</label>
                                <input type="text" class="form-control" name="especialidade" value="'.$data->especialidade.'" required>
                            </div>
                        
                            <div class="form-group">
                                <label for"nome">Data de nascimento</label>
                                <input type="date" class="form-control" name="data_nascimento"value="'.with(new \Carbon\Carbon($data->data_nascimento))->format('Y-m-d').'" required>
                            </div>
    
                        </div>
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Alterar</button>
                                
                        </form>
                    
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                    </div>
                </div>
                </div>
                <a href="#edit-'.$data->id.'" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#exampleModal">Excluir</a>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Deseja Excluir?</h5>
                    </div>
                    <div class="modal-footer">
                    <form action="/usuarios/excluir" method="post">
                            '.csrf_field().'
                            <input type="hidden" name="id" value="'.$data->id.'">
                            <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                    </div>
                </div>
                </div>';
            })->editColumn('medico_id', function ($data) {
                return Medicos::find($data->medico_id)->nome . " - ". Medicos::find($data->medico_id)->especialidade;
    
            })->editColumn('paciente_id', function ($data) {
                return Pacientes::find($data->paciente_id)->nome;
    
            })->editColumn('status', function ($data) {
                $status = "";
                if($data->status == "M"){
                    $status = "Marcado";
                }else if($data->status == "C"){
                    $status = "Cancelado";
                }else if($data->status == "E"){
                    $status = "Em andamento";
                }else if($data->status == "F"){
                    $status = "Finalizado";
                }
                return $status;
                
            })->editColumn('data_agendamento', function ($data) {
                return with(new \Carbon\Carbon($data->data_agendamento))->format('m/d/Y H:i:s');
                
            })->addColumn('action', function ($data) {
                if($data->status == 'M'){
                    return '<form action="/agendamentos/cancelar" method="post"> 
                        '.csrf_field().'
                        <input type="hidden" name="id" value="'.$data->id.'">
                        <button type="submit" class="btn btn-xs btn-danger">Cancelar</button>
                    </form>';
                }
            });
        }else{
            $dt->editColumn('medico_id', function ($data) {
                return Medicos::find($data->medico_id)->nome . " - ". Medicos::find($data->medico_id)->especialidade;
    
            })->editColumn('paciente_id', function ($data) {
                return Pacientes::find($data->paciente_id)->nome;
    
            })->editColumn('status', function ($data) {
                $status = "";
                if($data->status == "M"){
                    $status = "Marcado";
                }else if($data->status == "C"){
                    $status = "Cancelado";
                }else if($data->status == "E"){
                    $status = "Em andamento";
                }else if($data->status == "F"){
                    $status = "Finalizado";
                }
                return $status;
                
            })->editColumn('data_agendamento', function ($data) {
                return with(new \Carbon\Carbon($data->data_agendamento))->format('m/d/Y H:i:s');
                
            })->addColumn('action', function ($data) {
                if($data->status == 'M'){
                    return '<form action="/agendamentos/cancelar" method="post"> 
                        '.csrf_field().'
                        <input type="hidden" name="id" value="'.$data->id.'">
                        <button type="submit" class="btn btn-xs btn-danger">Cancelar</button>
                    </form>';
                }
            });
        }
        return $dt->make(true);
    }
}
