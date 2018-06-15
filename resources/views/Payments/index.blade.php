@extends('adminlte::layouts.app')

@section('contentheader_title')
	 Registro de Pagos
@endsection


@section('main-content')
    <div class="container-fluid">



		<nav class="navbar navbar-default">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="#">Buscar Por</a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <form class="navbar-form navbar-left">
		        <div class="form-group">
		          <input type="text" class="form-control" placeholder="Search">
		        </div>
		        <button type="submit" class="btn btn-default">Submit</button>
		      </form>
		      <form class="navbar-form navbar-left">
		        <div class="form-group">
		          <input type="text" class="form-control" placeholder="Search">
		        </div>
		        <button type="submit" class="btn btn-default">Submit</button>
		      </form>
		      <ul class="nav navbar-nav navbar-right">
		        <li><a href="#">Link</a></li>
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
		          <ul class="dropdown-menu">
		            <li><a href="#">Action</a></li>
		            <li><a href="#">Another action</a></li>
		            <li><a href="#">Something else here</a></li>
		            <li role="separator" class="divider"></li>
		            <li><a href="#">Separated link</a></li>
		          </ul>
		        </li>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>


    	<div class="box box-success">
{{--             <div class="box-header">
              <h3 class="box-title">Buscar por:</h3>
            </div>
 --}}    		<div class="box-body">
    			<div class="col-md-4">
    				<h3 class="box-title">Buscar por:</h3>	
    			</div>
		        <div class="col-md-4">
		            {{-- <label class="" for="searchNumber">Cédula / RUC</label> --}}
		            <div class="input-group">
		              <input type="text" class="form-control" id="searchNumber" placeholder="Cédula / RUC">
		              <span class="input-group-btn">
		                  <button class="btn btn-default" type="button">Buscar</button>
		              </span>
		            </div>
				</div>
				<div class="col-md-4">
					{{-- <label class="" for="lot_number">Número de Lote</label> --}}
					<div class="input-group">
						<input type="text" class="form-control" id="lot_number" placeholder="Número de Lote">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button">Buscar</button>
						</span>
					</div>
		    	</div>
	    	</div>
    	</div>

		<!-- Listado de Propiedades -->
		<div class="box box-success">
			<div class="box-body">

				<table class="table table-bordered table-hover">
					<thead>
						<th>Tipo Propiedad</th>
						<th>Numero de Lote</th>
						<th>Acciones</th>
					</thead>
					<tr>
						<td>Casa</td>
						<td>Nro 450</td>
						<td><a href="#">Seleccionar</a></td>
					</tr>
					<tr>
						<td>Lote</td>
						<td>Nro 180</td>
						<td><a href="#">Seleccionar</a></td>
					</tr>
				</table>
				
			</div>
			
		</div>
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
					</div>

				</div>

			</div>
		</div>	



	<div class="box-footer">
		<button type="submit" class="btn btn-success" >
			<i class="fa fa-save"></i>  Grabar
		</button
	</div>
</div>

@endsection
