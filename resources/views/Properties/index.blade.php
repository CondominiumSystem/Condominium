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

@section('main-content')
	<div class ="input-group" >
      <a href="{{url('Properties/create')}}" type="button" class="btn btn-primary">
          <i class="fa fa-plus" aria-hidden="true"></i> Agregar
      </a>
    </div>
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">

				<!-- Default box -->
				<div class="box">
					<!-- <div class="box-header with-border">
						<h3 class="box-title">Home</h3>

						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fa fa-minus"></i></button>
							<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
								<i class="fa fa-times"></i></button>
						</div>
					</div> -->
					<div class="box box-success">
				      <div class="box-body">
				          <table class="table table-bordered table-hover">
                                <thead>
                                <th>Lote</th>
                                <th>Descripcion</th>
								<th>Activo</th>
								<th>Tipo</th>
								<th>Acciones</th>
                                </thead>
                                <tbody>
                                  @foreach ($properties as $property)
                                      <tr>
                                          <td>{{ $property->lot_number}}</td>
                                          <td>{{ $property->note}}</td>
										  <td>
											  @if ( $property->active )
											  <span>SI</span>
											  {!! Form::checkbox('active',$property->active,true) !!}
											  @else
											  <span>NO</span>
											  @endif
										  </td>
										  <td>{{ $property->property_type->name}}</td>


										  <td>
											  <a href="{{ route('Properties.edit', $property->id )}}" type="button" class="btn btn-xs btn-warning">
												  <i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
											  <a href="{{ route('Properties.destroy', $property->id )}}" type="button" onclick="return confirm('Seguro en Eliminar?')" class="btn btn-xs btn-danger">
												  <i class="fa fa-trash" aria-hidden="true"></i> Borrar</a>

										  </td>

                                      </tr>
                                  @endforeach
                            	</tbody>

                            </table>
                        </div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->

			</div>
		</div>
	</div>
@endsection
