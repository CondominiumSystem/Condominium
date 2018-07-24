
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
                {!! Form::select('year',$years,null,['class'=>'select form-control','placeholder'=>'Año']) !!}
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

	<script type="text/javascript">

		var oTable = $('#payments-table').DataTable({
			dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
	            "<'row'<'col-xs-12't>>"+
	            "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
		     processing: true,
		     serverSide: true,
			 ajax: {
	             url: '{{ route("Reports.paymentsData") }}',
	             data: function (d) {
	                 d.year = $('select[name=year]').val();
	                 d.person_type_id = $('select[name=person_type_id]').val();
	             }
	         },
		     columns: [
		         { data: 'person_name', name: 'persons.name'},
		         { data: 'person_type_name', name: 'person_types.name' },
		         { data: 'lot_number', name: 'properties.lot_number' },
		         { data: 'value', name: 'payments.value'},
		         { data: 'year', name: 'periods.year'},
		         { data: 'month_name', name:'periods.month_name'},
		     ]
		 });


	     $('#search-form').on('submit', function(e) {
	         oTable.draw();
	         e.preventDefault();
	     });

	 </script>
@endsection
