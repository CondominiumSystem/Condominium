@extends(Config::get('entrust-gui.layout'))

@section('contentheader_title','Usuarios')
@section('main-content')

<div class="models--actions">
    <a class="btn btn-labeled btn-primary" href="{{ route('entrust-gui::users.create') }}"><span class="btn-label"><i class="fa fa-plus"></i></span>{{ trans('entrust-gui::button.create-user') }}</a>
</div>
<table class="table table-striped">
  <tr>
    <th>Nombre</th>
    <th>Email</th>
    <th>Actions</th>
  </tr>

  @foreach($users as $userAdmin)
    <tr>
      <td>{{ $userAdmin->name }}</th>
      <td>{{ $userAdmin->email }}</th>

      <td class="col-xs-3">
        <form action="{{ route('entrust-gui::users.destroy', $userAdmin->id) }}" method="post">
          <input type="hidden" name="_method" value="DELETE">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <a class="btn btn-labeled btn-default" href="{{ route('entrust-gui::users.edit', $userAdmin->id) }}"><span class="btn-label"><i class="fa fa-pencil"></i></span>{{ trans('entrust-gui::button.edit') }}</a>
          <button type="submit" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="fa fa-trash"></i></span>{{ trans('entrust-gui::button.delete') }}</button>
        </form>
      </td>
    </tr>
  @endforeach
</table>
<div class="text-center">
  {!! $users->render() !!}
</div>
@endsection
