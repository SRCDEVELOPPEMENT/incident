

@extends('layouts.main')

@section('content')


    <!-- Begin Page Content -->
    <div class="main-content">
        <div class="container-fluid" style="font-family: Century Gothic;">
                                                    <div class="row">
                                                            <div class="col-md-5 text-left my-2">
                                                                <a style="border-radius: 3em;" class="btn btn-outline-primary" href="{{ route('roles.index') }}">
                                                                    <span class="fe fe-corner-up-left fe-16 mr-2"></span>
                                                                    Retour
                                                                </a>
                                                            </div>
                                                            <div class="col-md-7 text-right my-4">
                                                                <h2 class="text-xl text-uppercase">
                                                                    <span class="fe fe-info mr-2"></span>
                                                                    Attribution De Permission
                                                                </h2>
                                                            </div>
                                                    </div>


                                                    {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
                                                    <div class="row">
                                                        <div class="col-xs-6 col-sm-6 col-md-6 my-4">
                                                                <div class="col-md-9 text-left">
                                                                    <strong class="text-uppercase text-xl mr-4">Rôle </strong>
                                                                    <span class="text-uppercase text-success text-xl">{{$role->name}}</span>
                                                                    <!-- {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!} -->
                                                                </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <table class="table table-hover border">
                                                                    <tr style="visibility: hidden;">
                                                                        <td>
                                                                            <label class="text-uppercase">
                                                                                {{ Form::checkbox('permission[]', '', true) }}
                                                                                <!-- <input type="checkbox" name="permission[]" checked disabled="true"> -->
                                                                                cochez la case
                                                                            </label>
                                                                        </td>
                                                                        <td>
                                                                                
                                                                        </td>
                                                                    </tr>
                                                                    <thead class="bg-light text-white">
                                                                        <tr>
                                                                            <th class="text-white"><span class="fe fe-unlock mr-2"></span> Permission</th>
                                                                            <th class="text-white">Description De La Permission</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="tbodys">
                                                                        @foreach($permission as $value)
                                                                        <tr>
                                                                            <td>
                                                                                <label class="text-uppercase text-xl">
                                                                                    {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                                                                    {{ $value->name }}
                                                                                </label></br>
                                                                            </td>
                                                                            <td class="text-uppercase">
                                                                                {{ $value->description }}
                                                                            </td>
                                                                        </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 text-xl text-left">
                                                            <button type="submit" class="btn btn-primary"><span class="fe fe-save mr-2"></span> Attribuer La(es) Permission(s)</button>
                                                        </div>
                                                    </div>
                                                    {!! Form::close() !!}

        </div>
    </div>
@endsection