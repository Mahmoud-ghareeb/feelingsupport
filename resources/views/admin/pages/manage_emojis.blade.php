@extends('layouts.admin')

@section('content')

<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> Manage Emojis
                    <a href="{{route('admin.add.emojis')}}" class="btn btn-outline-primary btn-rounded alignToTitle"><i class="mdi mdi-plus"></i>add emoji</a>
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title">Emojis</h4>
                <div class="table-responsive-sm mt-4">
                    <table id="basic-datatable" class="table table-striped table-centered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>emoji</th>
                                <th>name_en</th>
                                <th>name_ar</th>
                                <th>category</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($emojis as $key => $emoji)
                                <tr>
                                    <td>{{ $key + 1; }}</td>
                                    <td>
                                    <i class="fa-solid {{$emoji->css_class}} emmo-size " data-id="{{$emoji->id}}" style="-webkit-text-stroke: 0.5px white;font-size: 35px;color: <?php echo $emoji->color ?>"></i>   
                                    </td>
                                    <td>{{$emoji->type_en}}</td>
                                    <td>{{$emoji->type_ar}}</td>
                                    <td>{{$emoji->category}}</td>
                                    <td>
                                        <div class="dropright dropright">
                                            <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{route('admin.edit.emojis', $emoji->id)}}">edit</a></li>
                                                <li><a class="dropdown-item" href="{{ route('admin.delete.emojis', $emoji->id) }}">delete</a></li>
                                            </ul>
                                        </div>
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