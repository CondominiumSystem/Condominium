@extends('adminlte::layouts.app')

@section('contentheader_title')
	 Registro de Pagos
@endsection


@section('main-content')
    <div class="container-fluid">

		<!-- Criterios de Búsqueda -->
    	<div class="box box-success">
 			<div class="box-body">
    			<div class="col-md-4">

    				{{-- <h3 class="box-title">Buscar por:</h3>
 --}}
    			</div>
		        <div class="col-md-4">
		            {{-- <label class="" for="searchNumber">Cédula / RUC</label> --}}
					<!-- Inicio Buscador por Document Number -->
					{!! Form::open(['route'=>'Payments.index', 'method' =>'GET', 'class' => 'navbar-form pull-right']) !!}
			            <div class="input-group">
			              {!! Form::text('document_number',null,['class'=> 'form-control','placeholder'=>'Cédula / RUC..','aria-describedby'=>'search'])!!}
			              <span class="input-group-btn">
			                  <button class="btn btn-default" type="button">Buscar</button>
			              </span>
		            </div>
					{!! Form::close() !!}
					<!-- Fin Buscador -->
				</div>
				<div class="col-md-4">
					{{-- <label class="" for="lot_number">Número de Lote</label> --}}
					{!! Form::open(['route'=>'Payments.index', 'method' =>'GET', 'class' => 'navbar-form pull-right']) !!}
					<div class="input-group">
						<input type="text" class="form-control" id="lot_number" name="lot_number" placeholder="Número de Lote">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button">Buscar</button>
						</span>
					</div>
					{!! Form::close() !!}
		    	</div>
	    	</div>
    	</div>

		<!-- Listado de Propiedades -->
		@if ($properties != null)

		<div class="box box-success">
			<div class="box-body">
				<table class="table table-bordered table-hover">
					<thead>
						<th>Tipo Propiedad</th>
						<th>Lote</th>
						<th>Propietario</th>
						<th>Acciones</th>
					</thead>
					<tbody>
                @foreach ($properties as $property)
                  <tr>
                      <td>{{ $property->property_type_name}}</td>
                      <td>{{ $property->lot_number}}</td>
                      <td>{{ $property->person_name }}</td>
                      <td>seleccione</td>
                  </tr>
                @endforeach

              </tbody>

				</table>
			</div>
		</div>
		@endif

		<div class="box box-success">

			<div class="box-header">
              	<h3 class="box-title">PAGOS PERIODOS:</h3>
            	<ul class="pagination pagination-sm no-margin pull-right">
	                <li><a href="#">&laquo;</a></li>
	                <li><a href="#">2018</a></li>
	                <li><a href="#">&raquo;</a></li>
              	</ul>
            </div>

            <div class="box-footer clearfix">
            </div>

			<div class="box-body">
				<div class="row">
					<div class="col-md-6">
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
										<td>{{$payment["month_name"]}}</td>
										<td>
											{{ $payment["quota"] }}
										</td>
										<td>
											{{ $payment["is_payment"] }}
										</td>
										<td>
											<input type="checkbox" name="" value="">
										</td>
									</tr>
									@endforeach
								@endif
							</tbody>
							</table>
						</div>
					</div>

					<div class="col-md-6">
						<table class="table table-bordered">
							<thead>
								<th>Mes</th>
								<th>Valor</th>
								<th>Pago</th>
							</thead>
							<tr>
								<td>Julio</td>
								<td>10</td>
								<td>
									<input type="checkbox" name="" value="">
								</td>
							</tr>
						</table>
					</div>

				</div>

			</div>
		</div>
		<div class="box-footer">
			<button type="submit" class="btn btn-success" >
				<i class="fa fa-save"></i>  Grabar
			</button>
		</div>
</div>

@endsection
