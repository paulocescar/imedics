@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3>Médicos</h3>
            <table id="table" class="table table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>CRM</th>
                        <th>Especialidade</th>
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
                'url' : '/medicos/data',
                'type' : 'get'
            },
            "columns": [
                {data : 'id'},
                {data : 'nome'},
                {data : 'CRM'},
                {data : 'especialidade'},
                {data : 'action'}
            ]
        })
    }); 
</script>
@endsection