@extends('adminlte::layouts.app')

@section('contentheader_title')
	<!-- {{ trans('adminlte_lang::message.home') }}
	 -->
	 Reportes
@endsection

@section('main-content')
    <div class="box">

        <table class="table table-bordered" id="tasks-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Numero de lote</th>
                <th>Pago</th>
                <th>Periodo</th>

            </tr>
            </thead>
        </table>

    </div>
@endsection
