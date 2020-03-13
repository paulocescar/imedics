@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3>Cadastrar médicos</h3>
            <label for"">Campos obrigátórios (*)</label>
            @if(Session::has('success'))
            <div class="form-group row">
                <div class="col-md-12">
                    <p id="success">Médico cadastrado com sucesso.</p></a>
                </div>
            </div>
            @endif
            <form action="/medicos/criar" method="post">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for"nome">Especialidade (*)</label>
                            <input type="text" class="form-control" name="especialidade" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for"nome">CPF (*)</label>
                            <input type="text" class="form-control CPF" name="CPF" required>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for"nome">CRM (*)</label>
                            <input type="text" class="form-control" name="CRM" required>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for"nome">Celular (*)</label>
                            <input type="text" class="form-control celular" name="celular" required>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for"nome">Data de nascimento (*)</label>
                            <input type="date" class="form-control" name="data_nascimento" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for"nome">Sexo (*)</label>
                            <select name="sexo" class="form-control" required>
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                                <option value="O">Outros</option>
                            </select>
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
        $('.celular').mask('(99) 99999-9999', {clearifnotmatch: true});
    });
</script>
@endsection