@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3>Marcar consulta</h3>
            <label for"">Campos obrigátórios (*)</label>
            @if(Session::has('success'))
            <div class="form-group row">
                <div class="col-md-12">
                    <p id="success">Consulta efetuada com sucesso.</p></a>
                </div>
            </div>
            @endif
            <form action="/agendar/criar" method="post">
                {{csrf_field()}}

                <?php $paciente = App\Pacientes::where('user_id','=',Auth::User()->id)->get(); ?>
                @if($paciente == '[]' || $paciente == null)
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for"nome">CPF (*)</label>
                            <input type="text" class="form-control CPF" name="CPF" required>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for"nome">Sexo (*)</label>
                            <select name="sexo" class="form-control" required>
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                                <option value="O">Outros</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for"nome">Data de nascimento (*)</label>
                            <input type="date" class="form-control" name="data_nascimento" required>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for"nome">Especialidade (*)</label>
                            <select name="medico" class="form-control" required>
                                @foreach($especiliadades as $e)
                                    <option value="{{$e->id}}">{{$e->especialidade}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for"nome">Data de agendamento (*)</label>
                            <input type="date" class="form-control" name="data_agendamento" min="{{date('Y-m-d')}}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for"nome">Horário (*)</label>
                            <input type="time" class="form-control" name="horario" min="08:00" max="18:00" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="observacao">Observações</label>
                    <textarea class="form-control rounded-0" name="observacao" id="observacao" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-success">Cadastrar</button>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function($){
        $('.CPF').mask('999.999.999-99', {clearifnotmatch: true});
    });
</script>
@endsection