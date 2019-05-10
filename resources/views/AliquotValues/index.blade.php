@extends('adminlte::layouts.app')

@section('contentheader_title')
	<!-- {{ trans('adminlte_lang::message.home') }}
	 -->
	 Valores de Alicuotas
@endsection

@section('contentheader_description')

@endsection

@section('new_button')
	<!-- Boton Agregar -->
	<div class="col-md-4">

	      <a href="{{route('AliquotValues.create')}}" type="button" class="btn btn-primary btn-xs">
	          <i class="fa fa-plus" aria-hidden="true"></i> Agregar
	      </a>
	</div>
	<!-- Fin Boton Agregar -->
@endsection

@section('main-content')
		<!-- Default box -->
<div class="box box-success">
      	<div class="box-body">

					@if( $alicuotValues->count() > 0)
					<table class="table table-bordered table-hover">
					    <thead>
  					    <th>Id</th>
								<th>Tipo Propiedad</th>
  						  <th>Valor</th>
                <th>Fecha Desde</ht>
  					    <th>Fecha Hasta</th>
					    </thead>
					    <tbody>
					      @foreach ($alicuotValues as $alicuotValue)
				        <tr>
			              <td>{{ $alicuotValue->id}}</td>
										<td>{{ $alicuotValue->propertyType->name }}</td>
						        <td>{{ $alicuotValue->value}}</td>
			              <td>{{ $alicuotValue->start_date}}</td>
                    <td>
                      @if ($alicuotValue->end_date != null)
                            {{ $alicuotValue->end_date }}
                      @else
                          Vigente
                      @endif
                    </td>
				          </tr>
					      @endforeach
						</tbody>
					</table>

					@endif


    	</div>
		<!-- /.box-body -->
</div>
		<!-- /.box -->

@endsection

@section('customScript')
	<script>
        //Date picker
        $('#date_from').datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true,
			language: 'es'
        });

        $("#property_type_id").on('change',function(){

          if($("#property_type_id").val() !== ""){
            alert($("#property_type_id").val());
          }else {
            alert("Seleccione un tipo de propiedad");
          }

        });

	</script>
@endsection
