<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Medicos;
use App\User;
use Validator;
use Datatables;
use Auth;

class MedicosController extends Controller
{
    public function medicosApi(){
        $medicos = Medicos::get();
        $mediosArray = array("medicos" => $medicos);
        return json_encode($mediosArray);
    }

    public function medicos(){
        return view('medicos.medicos');
    }

    public function novo(){
        return view('medicos.novo');
    }

    public function Criar(Request $request){
        $validator = Validator::make($request->all(), [
          'CPF' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/novoMedico')
                        ->withErrors($validator)
                        ->withInput();
        }

        $novoMedico = new Medicos();
        $novoMedico->user_id = Auth::User()->id;
        $novoMedico->nome = Auth::User()->name;
        $novoMedico->CPF = $request->CPF;
        $novoMedico->especialidade = $request->especialidade;
        $novoMedico->CRM = $request->CRM;
        $novoMedico->sexo = $request->sexo;
        $novoMedico->email = Auth::User()->email;
        $novoMedico->celular = $request->celular;
        $novoMedico->data_nascimento = $request->data_nascimento;
        $novoMedico->observacao = $request->observacao;
        $novoMedico->save();

        $usuario = User::find(Auth::User()->id);
        $usuario->level = "M";
        $usuario->save();

        return redirect('/novoMedico')->with('success','Paciente atualizado com sucesso.');
    }

    public function editar(Request $request){
      $validator = Validator::make($request->all(), [
        'CPF' => 'required',
      ]);

      if ($validator->fails()) {
          return redirect('/medicos')
                      ->withErrors($validator)
                      ->withInput();
      }

      $novoMedico = Medicos::find($request->id);
      $novoMedico->CPF = $request->CPF;
      $novoMedico->especialidade = $request->especialidade;
      $novoMedico->CRM = $request->CRM;
      $novoMedico->sexo = $request->sexo;
      $novoMedico->celular = $request->celular;
      $novoMedico->data_nascimento = $request->data_nascimento;
      $novoMedico->observacao = $request->observacao;
      $novoMedico->save();

      return redirect('/medicos')->with('success','');
  }
    public function excluir(Request $request){
        $excluirMedico = Medicos::find($request->id);
        $excluirMedico->delete();

        return back();
    }
    public function data(){
        $data = Medicos::get();

        $dt = Datatables::of($data);

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
  
                        <div class="form-group">
                            <label for"nome">CPF</label>
                            <input type="text" class="form-control CPF" name="CPF" value="'.$data->CPF.'" required>
                        </div>
                      
                        <div class="form-group">
                            <label for"nome">CRM</label>
                            <input type="text" class="form-control" name="CRM" value="'.$data->CRM.'" required>
                        </div>

                        <div class="form-group">
                            <label for"nome">Celular</label>
                            <input type="text" class="form-control celular" name="celular" value="'.$data->celular.'" required>
                        </div>

                        <div class="form-group">
                            <label for"nome">Sexo</label>
                            <select name="sexo" class="form-control" required>
                              <option value="M" '.($data->sexo == "M" ? "selected" : "").'>Masculino</option>
                              <option value="F" '.($data->sexo == "F" ? "selected" : "").'>Feminino</option>
                              <option value="O" '.($data->sexo == "Outros" ? "selected" : "").'>Outros</option>
                            </select>
                        </div>
      
                        <div class="form-group">
                            <label for="observacao">Observações</label>
                            <textarea class="form-control rounded-0" name="observacao" id="observacao" rows="3">'.$data->observacao.'</textarea>
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
        });


        return $dt->make(true);
    }
}
