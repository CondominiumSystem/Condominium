@extends('adminlte::layouts.app')
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
    Nueva Persona
@endsection


@section('main-content')
  @if(count($errors) > 0)
      <div class="alert alert-danger" role="alert">
	       <ul>
           @foreach($errors->all() as $error)
	          <li>{{$error}}</li>
	       @endforeach
           </ul>
      </div>

  @endif

<div class="main_container">
	<div class="box box-success">
	    {!! Form::Open(['route' => 'Persons.store','method' => 'POST']) !!}
			<div class="box-body">
				<div class="col-md-4">
					<div class="form-group">
                        {!! Form::label('person_type_id', 'Tipo') !!}
                        {!! Form::select('person_type_id',$person_types,null,['class'=>'select form-control','required', 'placeholder'=>'Seleccione Tipo']) !!}
                    </div>
				</div>

				<div class="col-md-12">
				    <div class="form-group">
				        {!! Form::label('name', 'Nombre') !!}
				        {!! Form::text('name', null ,['class'=>'form-control','placeholder'=>'Nombre del Cliente','maxlength' => 50, 'requerid' ]) !!}
				    </div>
				</div>

		        <div class="col-md-4">
		            <div class="form-group">
		                {!! Form::label('document_number', 'Cédula/Ruc') !!}
		                <div class="input-group">
		                    <span class="input-group-addon" id="sizing-addon2">
		                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
		                    </span>
		                    {!! Form::text('document_number',null,['class'=>'form-control','placeholder'=>'Cédula ó Ruc','maxlength' => 13, 'requerid' ]) !!}
		                </div>
		            </div>
		        </div>

		        <div class="col-md-4">
		            <div class="form-group">
		                {!! Form::label('phone', 'Teléfono') !!}
		                <div class="input-group">
		                    <span class="input-group-addon" id="sizing-addon2">
		                        <i class="fa fa-phone"></i>
		                    </span>
		                    {!! Form::text('phone',null,['class'=>'form-control','placeholder'=>'Teléfono','maxlength' => 10, 'requerid' ]) !!}
		                </div>
		            </div>
				</div>

		        <div class="col-md-4">
		            <div class="form-group">
		                {!! Form::label('cell_phone', 'Celular') !!}
		                <div class="input-group">
		                    <span class="input-group-addon" id="sizing-addon2">
		                        <i class="fa fa-mobile"></i>
		                    </span>
		                    {!! Form::text('cell_phone',null,['class'=>'form-control','placeholder'=>'Celular','maxlength' => 10,'requerid' ]) !!}
		                </div>
		            </div>
		        </div>

		        <div class="col-md-8">
		            <div class="form-group">
		                {!! Form::label('address', 'Dirección') !!}
		                <div class="input-group">
		                    <span class="input-group-addon" id="sizing-addon2">
		                        <i class="fal fa-address-card"></i>
		                    </span>
		                    {!! Form::text('address',null,['class'=>'form-control','placeholder'=>'Dirección','maxlength' => 80, 'requerid' ]) !!}
		                </div>
		            </div>
		        </div>


	        </div>


			<!-- /.box-body -->

			<div class="box-footer">
				<button type="submit" class="btn btn-success" >
					<i class="fa fa-save"></i>  Grabar
				</button
			</div>
		</div>

        {!! Form::Close() !!}
	</div>

@endsection
