@extends('layouts.main')


@section('content')


    <!-- Begin Page Content -->
    <div class="main-content">
        <div class="container-fluid">


                                                    <div class="row">
                                                        <div class="col-lg-12 margin-tb">
                                                            <div class="pull-left my-4">
                                                                <h2 class="text-xl">
                                                                    <span class="fe fe-info mr-2"></span>
                                                                    Edition Rôle
                                                                </h2>
                                                            </div>
                                                            <div class="pull-right my-4">
                                                                <a style="border-radius: 3em;" class="btn btn-outline-primary" href="{{ route('roles.index') }}">
                                                                    <span class="fe fe-corner-up-left fe-16 mr-2"></span>
                                                                    Retour
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
                                                    <div class="row">
                                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                                            <div class="form-group">
                                                                <strong>Nom Role :</strong>
                                                                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Permission:</strong>
                                                                <br/>
                                                                @foreach($permission as $value)
                                                                    <label style="font-size:25px;">{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                                                    {{ $value->name }}</label>
                                                                <br/>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 text-left">
                                                            <button type="submit" class="btn btn-primary">Enrégistrer</button>
                                                        </div>
                                                    </div>
                                                    {!! Form::close() !!}

        </div>
    </div>

    <!-- <script src="{{ url('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ url('js/sb-admin-2.min.js') }}"></script>
    <script src="{{ url('datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('js/demo/datatables-demo.js') }}"></script> -->
@endsection