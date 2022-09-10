@extends('layouts.admin')

@section('content')

<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> Change Emojis Order
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
                    <div class="card content-area p-4">
                        <div class="card-header border-0">
                        </div>
                        <div class="card-innr">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="subcategory_id" class="col-form-label">Products List</label>
                                        <div class="row font-weight-bold">
                                            <div class="col-md-1">No.</div>
                                            <div class="col-md-1">order</div>
                                            <div class="col-md-2">emoji</div>
                                            <div class="col-md-3">name_en</div>
                                            <div class="col-md-3">name_ar</div>
                                            <div class="col-md-2">category</div>
                                        </div>
                                        <ul class="list-group bg-grey move order-container" id="sortable">
                                        @foreach ($emojis as $key => $emoji)
                                            <li class="list-group-item d-flex bg-gray-light align-items-center h-25" id="product_id-{{$emoji->id}}">
                                                <div class="col-md-1"><span> {{ $key + 1; }} </span></div>
                                                <div class="col-md-1"><span> {{ $emoji->raw_order }} </span></div>
                                                <div class="col-md-2"><span><i class="fa-solid {{$emoji->css_class}} emmo-size " data-id="{{$emoji->id}}" style="-webkit-text-stroke: 0.5px white;font-size: 35px;color: <?php echo $emoji->color ?>"></i>   </span></div>
                                                <div class="col-md-3">
                                                    {{$emoji->type_en}}
                                                </div>
                                                <div class="col-md-3"><span>{{$emoji->type_ar}}</span></div>
                                                <div class="col-md-2"><span>{{$emoji->category}}</span></div>
                                            </li>
                                        @endforeach
                                        </ul>
                                        <button type="button" class="btn btn-block btn-success btn-lg mt-3" id="save_product_order">Save</button>
                                    </div>
                                </div>
                            </div><!-- .card-innr -->
                        </div><!-- .card -->
                    </div>

                </div>
</div>

@endsection
@section('scripts')
<script
  src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"
  integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0="
  crossorigin="anonymous"></script>
<script>
    
    $(document).ready(function(){
        $('#sortable').sortable({
            axis: 'y',
            opacity: 0.6,
            cursor: 'grab'
        });

        $(document).on('click', '#save_product_order', function() {
            var order = $('#sortable').sortable('serialize');
            console.log(order);
            $.ajax({   
                type:"get",
                url: "{{route('admin.update.emojis.order')}}",
                data: order,
                success: function(data){
                    console.log(data);
                },
                error: function(err){
                    console.log(err);
                }
                    
            });
        });
    });
</script>
@endsection