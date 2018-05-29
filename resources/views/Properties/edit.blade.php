@extends('adminlte::layouts.app')
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
<div class="main_container">
    <div class="row">
            <div class="page-title">
              <div class="title_left">
                <h3>Editar </h3>
              </div>
            </div>
    </div>

	<div class="box box-success">

		<table class="table table-bordered table-hover">
    		<div class="box-body">


        {!! Form::Open(['route' => ['Properties.update',$property],'method' => 'PUT']) !!}

                <div class="form-group">
					<div class="col-md-4">
                    	<div class="form-group">
                    		{!! Form::label('lot_number', 'Lote') !!}
                    		{!! Form::text('lot_number', $property->lot_number ,['class'=>'form-control','placeholder'=>'Numero de Lote', 'requerid' ]) !!}
                		</div>
				   </div>
			 	</div>
                <div class="row">

                    <div class="col-md-5">
                        <div class="form-group">
                            {!! Form::label('note', 'Descripcion') !!}
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon2">
                                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                </span>
                                {!! Form::text('note',$property->note,['class'=>'form-control','placeholder'=>'Descripcion', 'requerid' ]) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('active', 'Estado') !!}
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon2">
                                    <i class="fa fa-phone"></i>
                                </span>
                                {!! Form::text('active',$property->active,['class'=>'form-control','placeholder'=>'Estado', 'requerid' ]) !!}
                            </div>
                        </div>
                    </div>

                <div class="form-group">
                    {!! Form::submit('Editar',['class'=>'btn btn-primary']) !!}
                </div>

                {!! Form::Close() !!}

    </div>

</div>
</table>
</div>

@endsection
