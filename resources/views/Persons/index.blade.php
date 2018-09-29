@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
    Personas
@endsection

@section('contentheader_description')
 Listado
@endsection

@section('new_button')
	@permission('create-auth-persons')
		<div class="pull-right">
			<a href="{{url('Persons/create')}}" type="button" class="btn btn-primary">
				<i class="fa fa-plus" aria-hidden="true"></i> Agregar
			</a>
		</div>
	@endpermission
@endsection

@section('main-content')
		<!-- Default box -->
		<div class="box box-success">

			<div class="box-header with-border">
		        <div class="">

							<div class="row">
								<div class="col-sm-2">
								{!! Form::select('person_type_id',$person_types,null,['class'=>'input-filter input-sm form-control', 'placeholder'=>'Seleccione Tipo']) !!}
								</div>
								<div class="col-sm-2">
									<!-- Inicio Buscador por Nombre -->
										{!! Form::open(['route'=>'Persons.index', 'method' =>'GET', 'class' => '']) !!}
										<div class ="input-group" >
											{!! Form::text('name',null,['class'=> 'form-control input-sm','placeholder'=>'Buscar Contacto..','aria-describedby'=>'search'])!!}
											<span class="input-group-addon" id="search">
											<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
										</span>
										</div>
										{!! Form::close() !!}
									</div>
									<!-- Fin Buscador -->
									<div class="col-sm-4">
									<!-- Inicio Buscador por Documento -->
									{!! Form::open(['route'=>'Persons.index', 'method' =>'GET', 'class' => '']) !!}
										<div class ="input-group" >
										{!! Form::text('document_number',null,['class'=> 'form-control input-sm','placeholder'=>'Nro. Documento..','aria-describedby'=>'searchByNumber'])!!}
										<span class="input-group-addon" id="searchByNumber">
										<span class="glyphicon glyphicon-search" aria-hidden="true"></span></span>
										</div>
									{!! Form::close() !!}
									</div>
									<!-- Fin Buscador -->
						        </div>

							</div>

		    </div>
		    <!-- /.box-header -->


	      <div class="box-body">
	          <table class="table table-bordered table-hover">

              <thead>
								<th>Tipo</th>
                <th>Nombre</th>
                <th>Documento</th>
                <th>Teléfono</th>
                <th>Celular</th>
                <th>Dirección</th>
                <!-- <th>Fecha Inicio</th> -->
                <th>Acción</th>
              </thead>
              <tbody>
                @foreach ($persons as $person)
                  <tr>
					  <td>{{ $person->personType->name }}</td>
                      <td>{{ $person->name}}</td>
                      <td>{{ $person->document_number}}</td>
                      <td>{{ $person->phone }}</td>
                      <td>{{ $person->cell_phone }}</td>
                      <td>{{ $person->address}}</td>
                      <!-- <td>{{ $person->start_date}}</td> -->
                      <td>
						   @permission('edit-auth-persons')
							<a href="{{ route('Persons.edit', $person->id )}}" type="button" class="btn btn-xs btn-warning">
								<i class="fa fa-pencil" aria-hidden="true"></i> Editar
							</a>
							@endpermission

							@if( $person->properties->count() > 0)
							<a href="{{ route('Properties.index', [ 'id' => $person->id] )}}" type="button" class="btn btn-xs btn-info ">
								<i class="fa fa-home" aria-hidden="true"></i> Propiedades
							</a>
							@endif

							@permission('delete-auth-persons')
							<a href="" alt="Borrar" type="button"
								data-href="{{ route('Persons.destroy', $person->id )}}"
								class="btn btn-xs btn-danger"  data-toggle="modal" data-target="#confirm-delete">
								<i class="fa fa-trash" aria-hidden="true"></i> Borrar
							</a>
							@endpermission

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
