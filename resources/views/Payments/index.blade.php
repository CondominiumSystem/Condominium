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
							<button type="submit" class="btn btn-success no-margin pull-right" >
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
											<td>
												{{ $payment->quota }}
											</td>
											<td>
												@if ( $payment->is_payment )
												<span>PAGADO</span>
												@else
												<span>NO</span>
												{!! Form::checkbox('active[]',$payment->period_id,$payment->is_payment) !!}
												@endif
												<!-- <input class="checkbox" type="checkbox" name="is_pay[]"
												id="check-box-{{ $payment->period_id }}"
												value="{{ $payment->is_payment }}"
												{{ ($payment->is_payment) ? "checked" : "" }} /> -->
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

@endsection
