@extends(Config::get('entrust-gui.layout'))

@section('contentheader_title', 'Create User')
@section('main-content')
<form action="{{ route('entrust-gui::users.store') }}" method="post" role="form" autocomplete="off">

     <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="name" class="form-control" id="name" placeholder="Name" name="name" value="">
    </div>
    <h1>sdfgsd</h1>
    <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="">
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Password" name="password">
        @if(Route::currentRouteName() == 'entrust-gui::users.edit')
            <div class="alert alert-info">
              <span class="fa fa-info-circle"></span> Leave the password field blank if you wish to keep it the same.
            </div>
        @endif
    </div>
    @if(Config::get('entrust-gui.confirmable') === true)
    <div class="form-group">
        <label for="password">Confirm Password</label>
        <input type="password" class="form-control" id="password_confirmation" placeholder="Confirm Password" name="password_confirmation">
    </div>
    @endif
    <div class="form-group">
        <label for="roles">Roles</label>
        <select name="roles[]" id="roles" multiple class="form-control">
            @foreach($roles as $index => $role)
                <option value="{{ $index }}" >{{ $role }}</option>
            @endforeach
        </select>
    </div>









    <button type="submit" id="create" class="btn btn-labeled btn-primary"><span class="btn-label"><i class="fa fa-plus"></i></span>{{ trans('entrust-gui::button.create') }}</button>
    <a class="btn btn-labeled btn-default" href="{{ route('entrust-gui::users.index') }}"><span class="btn-label"><i class="fa fa-chevron-left"></i></span>{{ trans('entrust-gui::button.cancel') }}</a>
</form>
@endsection
