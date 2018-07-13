
@extends('adminlte::layouts.app')

@section('contentheader_title')

	 Reportes de Pagos
@endsection

@section('contentheader_description')

@endsection

@section('main-content')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">

<div class="box">
    <div class="panel-body">
        <form method="POST" id="search-form" class="form-inline" role="form">

            {!! Form::label('year', 'Año:') !!}
            <div class="input-group date">
                {!! Form::select('year',$years,null,['class'=>'select form-control','required']) !!}
            </div>

            <label for="person_type_id">Residente:</label>
			{!! Form::select('person_type_id',$person_types,null,['class'=>'select form-control', 'placeholder'=>'Seleccione Tipo']) !!}

            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
    </div>
    <table class="table table-bordered" id="payments-table">
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Lote</th>
            <th>Valor</th>
            <th>Año</th>
            <th>Mes</th>
        </tr>
        </thead>
    </table>

</div>



@endsection

@section('customScript')

<!--
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">

<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script> -->


	<script type="text/javascript">

$(document).ready( function () {

		$('#payments-table').DataTable({
		     processing: true,
		     serverSide: true,
		     ajax: '{!! route("Reports.paymentsData") !!}',
		     columns: [
		         { data: 'person_name', name: 'persons.name'},
		         { data: 'person_type_name', name: 'person_types.name' },
		         { data: 'lot_number', name: 'properties.lot_number' },
		         { data: 'value', name: 'payments.value'},
		         { data: 'year', name: 'periods.year'},
		         { data: 'month_name', name:'periods.month_name'},
		     ]
		 });

} );

	 </script>
@endsection
