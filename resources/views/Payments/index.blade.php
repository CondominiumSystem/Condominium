@extends('adminlte::layouts.app')

@section('contentheader_title')
	 Registro de Pagos
@endsection

@section('main-content')
		<div class="row">
		        <!-- left column -->
		        <div class="col-md-6">
					<!-- Criterios de Búsqueda -->
			    	<div class="box box-success">
			 			<div class="box-body">
							{{-- <label class="" for="lot_number">Número de Lote</label> --}}
							{!! Form::open(['route'=>'Payments.index', 'method' =>'GET']) !!}

								<div class="col-md-6">
									<div class="input-group">
									  {!! Form::text('document_number',null,['class'=> 'form-control','placeholder'=>'Cédula / RUC..','aria-describedby'=>'search'])!!}
									  <span class="input-group-btn input-group-sm">
  										<button class="btn btn-default" type="submit">
  											<span class="btn-label"><i class="fa fa-search"></i></span>
  										</button>
  									</span>
									</div>
								</div>

								<div class="col-md-6">
								<div class="input-group">
									{!! Form::text('lot_number',$lot_number,['class'=> 'form-control','placeholder'=>'Lote','maxlength' => 3,'aria-describedby'=>'search'])!!}
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
							<table class="table table-bordered table-hover" id="tblProperties">
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
				{!! Form::open(['route'=>'Payments.store', 'id' => 'formPayment','method' =>'POST']) !!}
					<input type="hidden" name="_token" value="{{csrf_token()}}">
				@if($properties != null && $properties->count() > 0 )
				{!! Form::hidden('property_id', $properties->first()->id  ) !!}
				@endif
				<div class="col-md-6">
					<div class="box box-success">
						<div class="box-header">
			              	<h3 class="box-title">PAGOS AÑO:
							</h3>
							<button type="button" id="btnPayment"
								class="btn btn-success no-margin pull-right">
								<i class="fa fa-money"></i>  Pagar
							</button>
			            </div>
						<div class="box-body">
							<div class="bs-callout bs-callout-warning">
								<table class="table table-bordered table-hover" id="tblPayments">
									<thead>
										<th>Año</th>
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
											<td>{{$payment->year}}</td>
											<td>{{$payment->month_name}}</td>
											<td>{{ $payment->value }}</td>
											<td>
												@if ( $payment->payment_value > 0 )
												<span>PAGADO</span>
												@else
												<span>NO</span>
												{!! Form::checkbox('active[]',$payment->period_id, 0) !!}
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
				<!-- {!! Form::close() !!} -->
			</form>
		</div>
<!-- Modal -->
<div class="modal fade" id="confirmPayment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Confirmar Pago</b></h4>
      </div>
      <div class="modal-body">
        <p class="detalle"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <a class="btn btn-success btn-ok" id="btnAceptPayment">Aceptar</a>
      </div>
    </div>
  </div>
</div>

<!-- begin modal -->
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Información</h4>
      </div>
      <div class="modal-body">
        <p>No se encontro registros pedientes</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>


<!-- /.modal -->


@endsection

@section('customScript')
  <script>

    $('#confirm-delete').on('show.bs.modal', function(e) {
      $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));

      $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
    });


	var tblProperties = $("#tblProperties");
	var tblPayments = $("#tblPayments");


	$("#btnAceptPayment").on('click',function(event){
		$("#formPayment").submit();
	});

	$("#btnPayment").on('click',function(event){
		event.preventDefault();
	    if( tblProperties[0] != undefined && tblPayments.find('input[type=checkbox]:checked').length > 0 ){

			var items = tblPayments.find('input[type=checkbox]:checked');//.find('td');
			var tableConfirmation = $("<table class='table table-bordered table-hover'><thead><th>Mes</th><th>Valor</th></thead><tbody></tbody></table>");
//debugger;
			//console.log(items);
			var total = 0.0;
			for (var i = 0; i < items.length; i++){
				var rows = $(items[i]).parent().parent().find('td');
				total = total + parseFloat(rows[2].innerText);
				tableConfirmation.append('<tr><td>' + rows[1].innerText + '</td><td>' + rows[2].innerText + '</td></tr>'  );
			}
			//if( total >= 0){
				debugger;
				tableConfirmation.append('<tfoot><tr><td><b>TOTAL</b></td><td><b>' + total.toFixed(2) + '</b></td></tr></tfoot>'  );
			//}

			$("#confirmPayment").find(".detalle").html('');
			$("#confirmPayment").find(".detalle").append(tableConfirmation);

	        $("#confirmPayment").modal();
	    }
	    else {
	        $("#myModal").modal();
	    }
	    return false;

	})

  </script>
@endsection
