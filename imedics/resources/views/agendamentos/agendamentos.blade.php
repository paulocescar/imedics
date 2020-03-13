@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3>Agendamentos</h3>
            <table id="table" class="table table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Médico - Especialidade</th>
                        <th>Paciente</th>
                        <th>status</th>
                        <th>Data Agendamento</th>	
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
                'url' : '/agendamentos/data',
                'type' : 'get'
            },
            "columns": [
                {data : 'id'},
                {data : 'medico_id'},
                {data : 'paciente_id'},
                {data : 'status'},
                {data : 'data_agendamento'},
                {data : 'action'}
            ]
        })
    }); 
</script>
@endsection