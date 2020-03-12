<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pacientes;
use Validator;
use Auth;
use Datatables;

class PacientesController extends Controller
{
    public function pacientes(){
        return view('pacientes');
    }

    public function Criar(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'data_nascimento' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/pacientes')
                        ->withErrors($validator)
                        ->withInput();
        }

        $novoPaciente = new Pacientes();
        $novoPaciente->nome = $request->nome;
        if($request->CPF){ $novoPaciente->CPF = $request->CPF; }
        if($request->CNPJ){ $novoPaciente->CNPJ = $request->CNPJ; }
        if($request->sexo){ $novoPaciente->sexo = $request->sexo; }
        $novoPaciente->email = $request->email;
        $novoPaciente->celular = $request->celular;
        if($request->sexo){ $novoPaciente->preferencias = $request->preferencias; }
        $novoPaciente->comunicao = $request->comunicao;
        $novoPaciente->data_nascimento = $request->data_nascimento;
        if($request->sexo){ $novoPaciente->observacao = $request->observacao; }
        $novoPaciente->save();

        return redirect('/Pacientes')->with('success','Paciente atualizado com sucesso.');
    } 

    public function editar(Request $request){

        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect('/Pacientes')
                        ->withErrors($validator)
                        ->withInput();
        }

        $novoPaciente = Pacientes::find($request->id);
        $novoPaciente->nome = $request->nome;
        if($request->CPF){ $novoPaciente->CPF = $request->CPF; }
        if($request->CNPJ){ $novoPaciente->CNPJ = $request->CNPJ; }
        if($request->sexo){ $novoPaciente->sexo = $request->sexo; }
        $novoPaciente->email = $request->email;
        $novoPaciente->celular = $request->celular;
        if($request->sexo){ $novoPaciente->preferencias = $request->preferencias; }
        $novoPaciente->comunicao = $request->comunicao;
        $novoPaciente->data_nascimento = $request->data_nascimento;
        if($request->sexo){ $novoPaciente->observacao = $request->observacao; }
        $novoPaciente->save();

        return redirect('/pacientes')->with('success','Paciente atualizado com sucesso.');
    } 
    
    public function excluir(Request $request){
        $excluirPaciente= Pacientes::find($request->id);
        $excluirPaciente->delete();

        return back();
    }

    public function data()
    {
        $data = Pacientes::select(array('pacientes.id','pacientes.nome','pacientes.email','pacientes.sexo','pacientes.celular','pacientes.CPF','pacientes.CNPJ','pacientes.data_nascimento'));

        $dt = Datatables::of($data);

        $dt->editColumn('data_nascimento', function ($data) {
            return $data->data_nascimento ? with(new \Carbon\Carbon($data->data_nascimento))->format('d/m/Y') : '';

        })->editColumn('sexo', function ($data) {
            $sexo = "";
            if($data->sexo == 'M'){
                $sexo = "Masculino";
            }else if($data->sexo == 'F'){
                $sexo = "Feminino";
            }else{
                $sexo = "Outros";
            }
            return $sexo;

        })->addColumn('action', function ($data) {
            return '<a href="#edit-'.$data->id.'" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modaleditar">Editar</a>
            <div class="modal fade" id="modaleditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja alterar?</h5>
                  </div>
                    <form action="/pacientes/editar" method="post">
                        <div class="container">
                            '.csrf_field().'
                            <input type="hidden" name="id" value="'.$data->id.'">
                            
                            <div class="form-group">
                                <label for"nome">Nome</label>
                                <input type="text" class="form-control" name="nome" value="'.$data->nome.'">
                            </div>

                            <div class="form-group">
                                <label for"nome">E-mail</label>
                                <input type="text" class="form-control" name="email" value="'.$data->email.'">
                            </div>

                            <div class="form-group">
                                <label for"nome">CPF</label>
                                <input type="text" class="form-control" name="CPF" value="'.$data->CPF.'">
                            </div>
                            
                            <div class="form-group">
                                <label for"nome">CNPJ</label>
                                <input type="text" class="form-control" name="CNPJ" value="'.$data->CNPJ.'">
                            </div>
                            
                            <div class="form-group">
                                <label for"nome">Sexo</label>
                                <select name="sexo" class="form-control">
                                    <option value="M" '.($data->sexo == "M" ? "selected" : "").'>Masculino</option>
                                    <option value="F" '.($data->sexo == "F" ? "selected" : "").'>Feminino</option>
                                    <option value="O" '.($data->sexo == "Outros" ? "selected" : "").'>Outros</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for"nome">Data de nascimento</label>
                                <input type="date" class="form-control" name="data_nascimento" value="'.with(new \Carbon\Carbon($data->data_nascimento))->format('Y-m-d').'">
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
                  <div class="modal-body">
                    <p>'.$data->id.' - '.$data->nome.'</p>
                  </div>
                  <div class="modal-footer">
                  <form action="/pacientes/excluir" method="post">
                        '.csrf_field().'
                        <input type="hidden" name="id" value="'.$data->id.'">
                        <button type="submit" class="btn btn-danger">Excluir</button>
                  </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  </div>
                </div>
              </div>
            </div>';
        });

        return $dt->make(true);
    }
}
