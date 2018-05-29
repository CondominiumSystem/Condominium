@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
    Personas
@endsection


@section('contentheader_description')
	<!-- Inicio Buscador por Nombre -->
		{!! Form::open(['route'=>'Persons.index', 'method' =>'GET', 'class' => 'navbar-form pull-right']) !!}
		<div class ="input-group" >
			{!! Form::text('name',null,['class'=> 'form-control','placeholder'=>'Buscar Contacto..','aria-describedby'=>'search'])!!}
			<span class="input-group-addon" id="search">
			<span class="glyphicon glyphicon-search" aria-hidden="true"></span></span>
		</div>
		{!! Form::close() !!}
	<!-- Fin Buscador -->

	<!-- Inicio Buscador por Documento -->
	{!! Form::open(['route'=>'Persons.index', 'method' =>'GET', 'class' => 'navbar-form pull-right']) !!}
		<div class ="input-group" >
		{!! Form::text('document_number',null,['class'=> 'form-control','placeholder'=>'Nro. Documento..','aria-describedby'=>'searchByNumber'])!!}
		<span class="input-group-addon" id="searchByNumber">
		<span class="glyphicon glyphicon-search" aria-hidden="true"></span></span>
		</div>
	{!! Form::close() !!}
	<!-- Fin Buscador -->

	<div class ="input-group" >
	  <a href="{{url('Persons/create')}}" type="button" class="btn btn-primary">
		  <i class="fa fa-plus" aria-hidden="true"></i> Agregar
	  </a>
	</div>

@endsection



@section('main-content')
		<!-- Default box -->
		<div class="box box-success">
	      <div class="box-body">
	          <table class="table table-bordered table-hover">

              <thead>
                <th>Nombre</th>
                <th>Documento</th>
                <th>Teléfono</th>
                <th>Celular</th>
                <th>Dirección</th>
                <th>Fecha Inicio</th>
                <th>Acción</th>
              </thead>
              <tbody>
                @foreach ($persons as $person)
                  <tr>
                      <td>{{ $person->name}}</td>
                      <td>{{ $person->document_number}}</td>
                      <td>{{ $person->phone }}</td>
                      <td>{{ $person->cell_phone }}</td>
                      <td>{{ $person->address}}</td>
                      <td>{{ $person->start_date}}</td>
                      <td>
                          <a href="{{ route('Persons.edit', $person->id )}}" type="button" class="btn btn-xs btn-warning">
                            <i class="fa fa-pencil" aria-hidden="true"></i> Editar
                          </a>
												  <a href="{{ route('Properties.index', [ 'id' => $person->id] )}}" type="button" class="btn btn-xs btn-warning">
                            <i class="fa fa-pencil" aria-hidden="true"></i> Propiedades
                          </a>

						  						<a href="" alt="Borrar"
														data-href="{{ route('Persons.destroy', $person->id )}}"
														type="button"
														class="btn btn-xs btn-danger"  data-toggle="modal" data-target="#confirm-delete">
	                        	<i class="fa fa-trash" aria-hidden="true"></i> Borrar
													</a>


                      </td>
                  </tr>
                @endforeach
              </tbody>
          </table>
		  <!-- Paginado -->
  	         {{ $persons->appends(request()->input())->links() }}
			 <!-- Fin Paginado -->
		<!-- /.box-body -->
		</div>
	<!-- /.box -->
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
            <p>Estás a punto de eliminar una persona, este procedimiento es irreversible.</p>
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
