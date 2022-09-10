@extends('layouts.admin')

@section('content')

<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> Manage Admins
                    <a href="{{route('admin.add.admins')}}" class="btn btn-outline-primary btn-rounded alignToTitle"><i class="mdi mdi-plus"></i>add admin</a>
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title">admins</h4>
                <div class="table-responsive-sm mt-4">
                    <table id="basic-datatable" class="table table-striped table-centered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>photo</th>
                                <th>name</th>
                                <th>user name</th>
                                <th>role</th>
                                <th>email</th>
                                <th>actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $key => $user)
                                <tr>
                                    <td>{{ $key + 1; }}</td>
                                    <td>
                                        <img src="{{asset($user->picture)}}" alt="" height="50" width="50" class="img-fluid rounded-circle img-thumbnail">
                                    </td>
                                    <td>{{$user->first_name}} {{$user->last_name}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->role}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        @if($user->id != 3)
                                            <div class="dropright dropright">
                                                <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{route('admin.edit.admins', $user->id)}}">edit</a></li>
                                                    <li><a class="dropdown-item" href="{{ route('admin.delete.admins', $user->id) }}">delete</a></li>
                                                </ul>
                                            </div>
                                        @else
                                            <span class="badge badge-success">root admin</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

@endsection