@extends('admin.layout')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <form action="/changeUserPassword" method="post">
                    @csrf
                    @method('patch')
                    <input type="text" name="user_id" id="" value="{{$user->id}}" hidden>
                    <div class="mb-3">
                        <label for="" class="form-label">Nueva contraseña</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder=""
                            aria-describedby="helpId"
                        />
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Confirme contraseña</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="form-control"
                            placeholder=""
                            aria-describedby="helpId"
                        />
                    </div>
                    <button type="submit" class="btn btn-primary">Cambiar contraseña</button>

                </form>
            </div>
        </div>
    </div>
@endsection
