@extends('adminlte::layouts.app')
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
    Editar Persona 
@endsection

@section('contentheader_description')
    {{ $person->name }}
@endsection

@section('main-content')
<div class="main_container">


    <div class="box box-success">
        {!! Form::Open(['route' => ['Persons.update',$person],'method' => 'PUT']) !!}
            <div class="box-body">

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('name', 'Nombre') !!}
                        {!! Form::text('name', $person->name ,['class'=>'form-control','placeholder'=>'Nombre del Cliente', 'requerid' ]) !!}
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        {!! Form::label('document_number', 'Documento') !!}
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon2">
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                            </span>
                            {!! Form::text('email',$person->document_number,['class'=>'form-control','placeholder'=>'Documento', 'requerid' ]) !!}
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
                            {!! Form::text('phone',$person->phone,['class'=>'form-control','placeholder'=>'Teléfono', 'requerid' ]) !!}
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
                            {!! Form::text('cell_phone',$person->cell_phone,['class'=>'form-control','placeholder'=>'Celular', 'requerid' ]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('address', 'Dirección') !!}
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon2">
                                <i class="fal fa-address-card"></i>
                            </span>
                            {!! Form::text('address',$person->address,['class'=>'form-control','placeholder'=>'Dirección', 'requerid' ]) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="col-md-12">
                    <div class="form-group no-margin">
                        <button type="submit" class="btn btn-success">
                            <span class="fa fa-save"></span>
                            Editar
                        </button>
                    </div>
                </div>

            </div>
        {!! Form::Close() !!}
    </div>
</div>

@endsection
