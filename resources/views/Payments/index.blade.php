@extends('adminlte::layouts.app')

@section('contentheader_title')
	 Registro de Pagos
@endsection


@section('main-content')
    <div class="container-fluid">
        <div class="col-md-4">
            <label class="" for="searchNumber">Cédula / RUC</label>
            <div class="input-group">
              <div class="input-group-addon">#</div>
              <input type="text" class="form-control" id="searchNumber" placeholder="Cédula / RUC">
              <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Buscar</button>
              </span>
            </div>
		</div>
		<div class="col-md-4">
			<label class="" for="searchName">Nombre</label>
			<div class="input-group">
				<input type="text" class="form-control" id="searchName" placeholder="Nombre/Razon Social">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button">Buscar</button>
				</span>
			</div>
    	</div>

    	{{ $persons->count() }}

	<table class="table table-bordered table-hover">
		<thead>
			<th>Tipo Propiedad</th>
			<th>Numero de Lote</th>
			<th>Acciones</th>
		</thead>
		<tr>
			<td>Casa</td>
			<td>Nro 450</td>
			<td>Seleccionar</td>
		</tr>

			<tr>

			<td>Lote</td>
			<td>Nro 180</td>
			<td>Seleccionar</td>
		</tr>
	</table>
	<table>
		<caption>PAGOS PERIODOS 2017</caption>
		<thead>
			<th>Mes</th>
			<th>Valor</th>
			<th>Pago</th>
		</thead>
		<tr>
			<td>Enero</td>
			<td>10</td>
			<td>
				<input type="checkbox" name="" value="">
			</td>
		</tr>
		<tr>
			<td>Febrero</td>
			<td>10</td>
			<td>
				<input type="checkbox" name="" value="">
			</td>
		</tr>
		<tr>
			<td>Marzo</td>
			<td>10</td>
			<td>
				<input type="checkbox" name="" value="">
			</td>
		</tr>
		<tr>
			<td>Abril</td>
			<td>10</td>
			<td>
				<input type="checkbox" name="" value="">
			</td>
		</tr>
		<tr>
			<td>Mayo</td>
			<td>10</td>
			<td>
				<input type="checkbox" name="" value="">
			</td>
		</tr>
		<tr>
			<td>Junio</td>
			<td>10</td>
			<td>
				<input type="checkbox" name="" value="">
			</td>
		</tr>
		<tr>
			<td>Julio</td>
			<td>10</td>
			<td>
				<input type="checkbox" name="" value="">
			</td>
		</tr>
		<tr>
			<td>Agosto</td>
			<td>10</td>
			<td>
				<input type="checkbox" name="" value="">
			</td>
		</tr>
		<tr>
			<td>Septiembre</td>
			<td>10</td>
			<td>
				<input type="checkbox" name="" value="">
			</td>
		</tr>
		<tr>
			<td>Octubre</td>
			<td>10</td>
			<td>
				<input type="checkbox" name="" value="">
			</td>
		</tr>
		<tr>
			<td>Noviembre</td>
			<td>10</td>
			<td>
				<input type="checkbox" name="" value="">
			</td>
		</tr>
		<tr>
			<td>Dicimbre</td>
			<td>10</td>
			<td>
				<input type="checkbox" name="" value="">
			</td>
		</tr>

	</table>
	<div class="box-footer">
		<button type="submit" class="btn btn-success" >
			<i class="fa fa-save"></i>  Grabar
		</button
	</div>
</div>

@endsection
