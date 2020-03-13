<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Validator;
use Auth;
use Datatables;

class UsuarioController extends Controller
{
    public function usuarios(){
        return view('usuarios');
    }

    public function Criar(Request $request){
        $email = User::where('email','=',$request->email)->get();
        if($email != '[]'){
            return redirect('/register')->withInput()->with('success','Alguns campos estão errados.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return redirect('/register')
                        ->withErrors($validator)
                        ->withInput()
                        ->with('success','Alguns campos estão errados.');
        }

        $novoUsuario = new User();
        $novoUsuario->name = $request->name;
        $novoUsuario->email = $request->email;
        $novoUsuario->password = bcrypt($request->password);
        $novoUsuario->level = 'P';
        $novoUsuario->save();

        return redirect('/login')->with('success','Sua conta foi criada com sucesso.');
    } 

    public function editar(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect('/usuarios')
                        ->withErrors($validator)
                        ->withInput()
                        ->with('error','Sua conta foi criada com sucesso.');
        }

        $editarUsuario = User::find($request->id);
        $editarUsuario->name = $request->name;
        $editarUsuario->email = $request->email;
        $editarUsuario->level = $request->level;
        $editarUsuario->save();

        return back();
    }

    public function excluir(Request $request){
        $excluirUsuario = User::find($request->id);
        $excluirUsuario->delete();

        return back();
    }

    public function data()
    {
        $data = User::select(array('users.id','users.name','users.email','users.level','users.created_at'));

        $dt = Datatables::of($data);

        $dt->editColumn('created_at', function ($data) {
            return $data->created_at ? with(new \Carbon\Carbon($data->created_at))->format('d/m/Y') : '';

        })->editColumn('level', function ($data) {
            $acesso = "";
            if($data->level == 'A'){
                $acesso = "Administrador";
            }else if($data->level == 'M'){
                $acesso = "Médico";
            }else{
                $acesso = "Paciente";
            }
            return $acesso;

        })->addColumn('action', function ($data) {
            return '<a href="#edit-'.$data->id.'" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modaleditar">Editar</a>
            <div class="modal fade" id="modaleditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja alterar?</h5>
                  </div>
                    <form action="/usuarios/editar" method="post">
                        <div class="container">
                            '.csrf_field().'
                            <input type="hidden" name="id" value="'.$data->id.'">
                            
                            <div class="form-group">
                                <label for"nome">Nome</label>
                                <input type="text" class="form-control" name="name" value="'.$data->name.'">
                            </div>

                            <div class="form-group">
                                <label for"nome">E-mail</label>
                                <input type="text" class="form-control" name="email" value="'.$data->email.'">
                            </div>
                            
                            <div class="form-group">
                                <label for"nome">Nivel de acesso</label>
                                <select name="level" class="form-control">
                                    <option value="A" '.($data->level == "A" ? "selected" : "").'>Administrador</option>
                                    <option value="M" '.($data->level == "M" ? "selected" : "").'>Médico</option>
                                    <option value="P" '.($data->level == "P" ? "selected" : "").'>Paciente</option>
                                </select>
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
