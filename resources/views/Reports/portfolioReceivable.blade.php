@extends('adminlte::layouts.app')

@section('contentheader_title')
	 Reporte Cartera por Cobrar
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
			<th>Año</th>
            <th>Mes</th>
			<th>Lote</th>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Valor Cartera</th>
			<th>Valor Cobrado</th>
        </tr>
        </thead>
    </table>

</div>



@endsection

@section('customScript')

	<script type="text/javascript">

		var oTable = $('#payments-table').DataTable({
			// dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
	        //     "<'row'<'col-xs-12't>>"+
	        //     "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
		     processing: true,
		     serverSide: true,
			 ajax: {
	             url: '{{ route("Reports.portfolioReceivableData") }}',
	             data: function (d) {
	                 d.year = $('select[name=year]').val();
	                 d.person_type_id = $('select[name=person_type_id]').val();
	             }
	         },
			 "bFilter": false,
		     columns: [
				 { data: 'year', name: 'year'},
				 { data: 'month_name', name:'month_name'},
				 { data: 'lot_number', name: 'lot_number' },
		         { data: 'person_name', name: 'person_name'},
		         { data: 'person_type_name', name: 'person_type_name' },
		         { data: 'value', name: 'value'},
				 { data: 'payment_value', name: 'payment_value'},
		     ],
			 "columnDefs": [
		      { className: "dt-right", "targets": [0,2,5,6] },
		      { className: "dt-nowrap", "targets": [1,3,4] }
		    ]
		 });

	     $('#search-form').on('submit', function(e) {
	         oTable.draw();
	         e.preventDefault();
	     });

	 </script>
@endsection
