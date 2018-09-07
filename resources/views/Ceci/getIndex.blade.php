@extends('adminlte::layouts.app')

@section('contentheader_title')
	 Reporte de Pagos
@endsection

@section('main-content')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <div class="box">
        <div class="box-body">
            {!! $dataTable->table(['class' => 'table table-bordered table-condensed']) !!}
        </div>
    </div>
@endsection

@section('customScript')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js" ></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>
{!! $dataTable->scripts() !!}
@stop
