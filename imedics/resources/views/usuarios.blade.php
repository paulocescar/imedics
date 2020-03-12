@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3>Usuários</h3>
            <table id="table" class="table table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Data</th>
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
                    'url' : '/usuarios/data',
                    'type' : 'get'
                },
                "columns": [
                    {data : 'id'},
                    {data : 'name'},
                    {data : 'email'},
                    {data : 'created_at'},
                    {data : 'action'}
                ]
            })
        }); 
</script>
@endsection