
@extends('layouts.admin')
@section('content')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">


@endsection


    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">  {{__('admin/tags.tags')}}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('admin/content.home')}}</a>
                                </li>
                                <li class="breadcrumb-item active"> {{__('admin/tags.tags')}}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
             <a href="{{route('admin.products.general.create')}}"
               class="btn btn-outline-primary  box-shadow-2 mr-1 mb-1">
                <i class="la la-plus"></i></a>

            <div class="content-body">
                <!-- DOM - jQuery events table -->
                <section id="dom">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>

                                @include('dashboard.includes.alerts.success')
                                @include('dashboard.includes.alerts.errors')

                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <table
                                            class="table display nowrap table-striped table-bordered ">
                                            <thead class="">
                                            <tr>
                                                <th>{{__('admin/tags.name')}} </th>
                                                <th> {{__('admin/tags.slug')}}</th>
                                                <th>{{__('admin/tags.opration')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @isset($tags)
                                                @foreach($tags as $tag)
                                                    <tr>
                                                        <td>{{$tag -> name}}</td>
                                                        <td>{{$tag ->  slug}}</td>
                                                        <td>
                                                            
                     <div class="btn-group" role="group" aria-label="Basic example">
                      <a class="modal-effect btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1" data-effect="effect-scale"
                                                       data-id="{{ $tag->id }}" data-name="{{ $tag->name }}"
                                                       data-slug="{{ $tag->slug }}" data-toggle="modal" href="#exampleModal2"
                                                       >{{__('admin/tags.edit')}}</a>


                                                                
                        <div class="btn-group" role="group" aria-label="Basic example">
                        <a class="modal-effect btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1" data-effect="effect-scale"
                                                       data-id="{{ $tag->id }}" data-name="{{ $tag->name }}" data-toggle="modal"
                                                       href="#modaldemo9">{{__('admin/tags.delete')}}</a>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endisset


                                            </tbody>
                                        </table>
                                        <div class="justify-content-center d-flex">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>



<!-- edit -->
                        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{__('admin/tags.edit')}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <form class="form"
                                          action="{{route('admin.tags.update',$tag -> id)}}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input name="id" value="{{$tag -> id}}" type="hidden">

                                     <div class="form-group">
                                           
                                            
                                                <label for="recipient-name" class="col-form-label">{{__('admin/tags.name')}}</label>
                                                <input class="form-control" name="name" id="name" type="text">
                                                @error("name")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">{{__('admin/tags.slug')}}</label>
                                                <input class="form-control" name="slug" id="slug" type="text">
                                                 @error("slug")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">{{__('admin/tags.update')}}</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('admin/tags.back')}}</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <!-- delete -->
                    <div class="modal" id="modaldemo9">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h3 class="modal-title">{{__('admin/tags.delete')}}</h3><button aria-label="Close" class="close" data-dismiss="modal"   type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="{{route('admin.tags.delete',$tag -> id)}}"
                                  method="post">
                                   {{method_field('delete')}}

                                            @csrf
                                    <div class="modal-body">
                                        <p>{{__('admin/tags.are sure of the deleting process')}}</p><br>
  <input name="id" value="" id="id" type="hidden">
                                       
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('admin/tags.cancel')}}</button>
                                         <a href="{{route('admin.tags.delete',$tag -> id)}}"
                                                                   class="btn btn-danger">
                                                                    {{__('admin/tags.delete')}}</a>
                                       
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>




                <!-- row closed -->
            </div>
            <!-- Container closed -->
        </div>
        <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>

    <script>
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var slug = button.data('slug')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #slug').val(slug);
        })
    </script>

    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var slug = button.data('slug')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #slug').val(slug);
        })
    </script>

@endsection
