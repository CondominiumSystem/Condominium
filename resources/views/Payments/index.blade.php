@extends('adminlte::layouts.app')

@section('contentheader_title')
	 Registro de Pagos
@endsection

@section('main-content')

    <div class="container-fluid">
		<div class="row">
		        <!-- left column -->
		        <div class="col-md-6">
					<!-- Criterios de Búsqueda -->
			    	<div class="box box-success">
			 			<div class="box-body">
							{{-- <label class="" for="lot_number">Número de Lote</label> --}}
							{!! Form::open(['route'=>'Payments.index', 'method' =>'GET']) !!}

								<div class="col-md-5">

									<div class="input-group">
									  {!! Form::text('document_number',null,['class'=> 'form-control','placeholder'=>'Cédula / RUC..','aria-describedby'=>'search'])!!}
									  <span class="input-group-btn">
  										<button class="btn btn-default" type="submit">
  											<span class="btn-label"><i class="fa fa-search"></i></span>
  										</button>
  									</span>
									</div>

								</div>

								<div class="col-md-3">
									{!! Form::select('period_id',$periods,$selected_period,['class'=>'select form-control','required']) !!}
								</div>
								<div class="col-md-4">
								<div class="input-group">
									{!! Form::text('lot_number',$lot_number,['class'=> 'form-control','placeholder'=>'Lote','aria-describedby'=>'search'])!!}
									<span class="input-group-btn">
										<button class="btn btn-default" type="submit">
											<span class="btn-label"><i class="fa fa-search"></i></span>
										</button>
									</span>
								</div>
					    		</div>
							{!! Form::close() !!}
				    	</div>
			    	</div>

					<!-- Listado de Propiedades -->
					@if ($properties != null)

					<div class="box box-success">
						<div class="box-body">
							<table class="table table-bordered table-hover">
								<thead>
									<th>Propiedad</th>
									<th>Lote</th>
									<th>Residente</th>
									<th>Desde</th>
									<th>Hasta</th>
								</thead>
								<tbody>
			                @foreach ($properties as $property)
			                  <tr>
			                      <td>{{ $property->property_type_name}}</td>
			                      <td>
									  <a href="{{ route('Payments.index', $property->person_id )}}">
										  {{ $property->lot_number}}</a>
								  </td>
			                      <td>{{ $property->person_name }}</td>
								  <td>{{ $property->date_from }}</td>
								  <td>{{ $property->date_to }}</td>
			                  </tr>
			                @endforeach

			              </tbody>

							</table>
						</div>
					</div>
					@endif

				</div>
				<!-- right column -->
				{!! Form::open(['route'=>'Payments.store', 'method' =>'POST']) !!}
				@if($properties != null)
				{!! Form::hidden('property_id', $properties->first()->id  ) !!}
				@endif
				<div class="col-md-6">
					<div class="box box-success">
						<div class="box-header">
			              	<h3 class="box-title">PAGOS AÑO: {{ $selected_period }}
							</h3>
							<button type="submit" class="btn btn-success no-margin pull-right" data-toggle="modal" data-target="#modal-confirm" >
								<i class="fa fa-money"></i>  Pagar
							</button>
			            </div>
						<div class="box-body">
							<div class="bs-callout bs-callout-warning">
								<table class="table table-bordered table-hover">
									<thead>
										<th>Mes</th>
										<th>Valor</th>
										<th>Pago</th>
									</thead>
									<tbody>
									@if( $payments == null)
										<tr>
											<td colspan="3">
												No hay datos
											</td>
										</tr>
									@else
										@foreach($payments as $payment)
										<tr>
											<td>{{$payment->month_name}}</td>
											<td>{{ $payment->quota }}</td>
											<td>
												@if ( $payment->is_payment )
												<span>PAGADO</span>
												@else
												<span>NO</span>
												{!! Form::checkbox('active[]',$payment->period_id,$payment->is_payment) !!}
												@endif
											</td>
										</tr>
										@endforeach
									@endif
								</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				{!! Form::close() !!}
		</div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Confirmar Borrado</h4>
      </div>

      <div class="modal-body">
        <p>Estás a punto de eliminar un inmueble, este procedimiento es irreversible.</p>
        <p>¿Quieres proceder?</p>
        <p class="debug-url"></p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <a class="btn btn-danger btn-ok">Borrar</a>
      </div>
    </div>
  </div>
</div>

<!-- begin modal -->
<div class="modal modal-info fade" id="modal-confirm">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">Info Modal</h4>
	  </div>
	  <div class="modal-body">
		<p>One fine body&hellip;</p>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-outline">Save changes</button>
	  </div>
	</div>
	<!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


@endsection

@section('customScript')
  <script>
    $('#confirm-delete').on('show.bs.modal', function(e) {
      $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));

      $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
    });
  </script>
@endsection
