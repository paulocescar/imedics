@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3>Pacientes</h3>
            <table id="table" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Sexo</th>
                        <th>Data de nascimento</th>
                        <th>Açoes</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
        $(document).ready(function () {
            $('#table').DataTable({
                'processing' : true,
                'serverSide' : true,
                'ajax' : {
                    'url' : '/pacientes/data',
                    'type' : 'get'
                },
                "columns": [
                    {data : 'id'},
                    {data : 'nome'},
                    {data : 'sexo'},
                    {data : 'data_nascimento'},
                    {data : 'action'}
                ]
            })
        }); 
</script>
@endsection