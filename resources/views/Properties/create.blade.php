@extends('adminlte::layouts.app')
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
	Editar
@endsection

@section('main-content')

<div class="main_container">
	<div class="box box-success">
        {!! Form::Open(['route' => 'Properties.store','method' => 'POST']) !!}
			<div class="box-body">

				<div class="col-md-3">
	                <div class="form-group">
	                    {!! Form::label('lot_number', 'Lote') !!}
	                    {!! Form::text('lot_number', null ,['class'=>'form-control','placeholder'=>'Número de lote','maxlength' => 3, 'requerid' ]) !!}
	                </div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
                        {!! Form::label('property_type_id', 'Tipo de Propiedad') !!}
                        {!! Form::select('property_type_id',$propertyTypes,null,['class'=>'select form-control','required', 'placeholder'=>'Seleccione Tipo']) !!}
                    </div>
				</div>


                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('address', 'Dirección') !!}
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon2">
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                            </span>
                            {!! Form::text('address',null,['class'=>'form-control','placeholder'=>'Dirección','maxlength' => 80, 'requerid' ]) !!}
                        </div>
                    </div>
                </div>

				<div class="col-md-6">
					<div class="form-group">
						{!! Form::label('note', 'Nota') !!}
						<div class="input-group">
							<span class="input-group-addon" id="sizing-addon2">
								<i class="fa fa-envelope-o" aria-hidden="true"></i>
							</span>
							{!! Form::text('note',null,['class'=>'form-control','placeholder'=>'Nota','maxlength' => 60, 'requerid' ]) !!}
						</div>
					</div>
				</div>

				{{ Form::hidden('active', '1') }}
                {{ Form::hidden('personId', $personId) }}

			</div>
			<!-- /.box-body -->
			<div class="box-footer">
                <div class="form-group">
                    {!! Form::submit('GRABAR',['class'=>'btn btn-primary']) !!}
                </div>
			</div>
        {!! Form::Close() !!}
	</div>
</div>
@endsection
