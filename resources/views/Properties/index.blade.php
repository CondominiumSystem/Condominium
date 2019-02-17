@extends('adminlte::layouts.app')

@section('contentheader_title')
	<!-- {{ trans('adminlte_lang::message.home') }}
	 -->
	 Listado de Propieades
@endsection

@section('contentheader_description')
	@if( $person != null)
	[ {{ $person->name }} ]
	@endif
@endsection

@section('new_button')
	<!-- Boton Agregar -->
	<div class="col-md-4">

	      <a href="{{route('Properties.create',($person)?$person->id:0)}}" type="button" class="btn btn-primary btn-xs">
	          <i class="fa fa-plus" aria-hidden="true"></i> Agregar
	      </a>
	</div>
	<!-- Fin Boton Agregar -->
@endsection

@section('main-content')
<!-- Propiedades de la Persona -->
@if( $person != null)
<div class="box box-success">
	<div class="box-header with-border">
		<div class="box-body">
				@if( $propertiesPerson->count() > 0)
				<table class="table table-bordered table-hover">
					<thead>
						<th>Lote</th><th>Tipo</th><th>Descripcion</th><th>Dirección</th><th>Acciones</th>
					</thead>
			    <tbody>
			      @foreach ($propertiesPerson as $propertyPerson)
						<tr>
							<td>{{ $propertyPerson->lot_number}}</td>
							<td>{{ $propertyPerson->property_type->name}}</td>
							<td>{{ $propertyPerson->note}}</td>
							<td>{{ $propertyPerson->address }}</td>
							<td>
								<a href="{{ route('Properties.edit', [$propertyPerson->id, (($person)?$propertyPerson->id:0) ])}}" type="button" class="btn btn-xs btn-warning">
								<i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
								<a href="" alt="Borrar" data-href="{{ route('Properties.destroy', $propertyPerson->id )}}"
								type="button" class="btn btn-xs btn-danger"
								data-toggle="modal" data-target="#confirm-delete">
								<i class="fa fa-trash" aria-hidden="true"></i> Borrar</a>
							</td>
						</tr>
			      @endforeach
				</tbody>
				</table>
				<!-- Paginado -->
				{{ $propertiesPerson->links() }}
				<!-- Fin Paginado -->
				@endif
  	</div>
	</div>
</div>
@endif



		<!-- Default box -->
<div class="box box-success">
	<div class="box-header with-border">
			<div class="row">
				<div class="col-sm-3">
						<!-- Inicio Buscador por Número de Lote -->
							{!! Form::open(['route'=>'Properties.index', 'method' =>'GET']) !!}
							<div class ="input-group" >
								{!! Form::text('lot_number',$lot_number,['class'=> 'form-control','placeholder'=>'Número de Lote','aria-describedby'=>'search'])!!}
								{!! Form::hidden('person_id', (($person)?$person->id:0)) !!}
								<span class="input-group-btn">
									<button class="btn btn-default" type="submit">
										<i class="fa fa-search"></i>
									</button>
								</span>
							</div>
							{!! Form::close() !!}
						<!-- Fin Buscador -->
				</div>
			</div>
	</div>
	<div class="box-body">
		@if($properties != null)

				@if( $properties->count() > 0)
				<table class="table table-bordered table-hover">
					<thead>
						<th>Lote</th>
						<th>Tipo</th>
						<th>Descripcion</th>
						<th>Dirección</th>
						<th>Acciones</th>
					</thead>
				    <tbody>
				      @foreach ($properties as $property)
							<tr>
								<td>{{ $property->lot_number}}</td>
								<td>{{ $property->property_type->name}}</td>
								<td>{{ $property->note}}</td>
								<td>{{ $property->address }}</td>
								<td>
									<a href="{{ route('Properties.edit', [$property->id, (($person_id)?$person->id:0) ])}}" type="button" class="btn btn-xs btn-warning">
										<i class="fa fa-pencil" aria-hidden="true"></i> Editar
									</a>
									<a href="" alt="Borrar" data-href="{{ route('Properties.destroy', $property->id )}}" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#confirm-delete">
										<i class="fa fa-trash" aria-hidden="true"></i> Borrar
									</a>

								</td>
							</tr>
				      @endforeach
					</tbody>
				</table>
				<!-- Paginado -->
				{{ $properties->links() }}
				<!-- Fin Paginado -->
				@endif
			@endif
	</div>
		<!-- /.box-body -->
</div>
		<!-- /.box -->



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
@endsection

@section('customScript')
  <script>
    $('#confirm-delete').on('show.bs.modal', function(e) {
      $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));

      $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
    });
  </script>
@endsection
