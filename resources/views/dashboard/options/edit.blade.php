@extends('layouts.admin')
@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">{{__('admin/content.home')}} </a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{route('admin.options')}}"> {{__('admin/product.options')}}  </a>
                                </li>
                                <li class="breadcrumb-item active"> {{__('admin/product.edit')}}- {{$options -> name}}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">{{__('admin/product.edit_options')}}</h4>
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
                                    <div class="card-body">
                                        <form class="form"
                                              action="{{route('admin.options.update',$options -> id)}}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <input name="id" value="{{$options -> id}}" type="hidden">
                                                        <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">

                                                            <label for="projectinput1"> {{__('admin/product.name')}}
                                                            </label>
                                                            <input type="text" id="name"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   value="{{$options -> name}}"
                                                                   name="name">
                                                            @error("name")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                     <div class="col-md-6">
                                                        <div class="form-group">
                            <label for="projectinput1"> {{__('admin/product.price')}}
                                                            </label>
                                                            <input type="text" id="price"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   value="{{$options -> price}}"
                                                                   name="price">
                                                            @error("price")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                         </div>
                                                    </div>

                                                </div>


                                                       <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">

                                               <label for="projectinput1"> {{__('admin/product.select_produ')}}
                                                            </label>
                                                            <select name="product_id" class="select2 form-control" >
                                                                <optgroup label="{{__('admin/product.please_select_produ')}}">
 @if($products && $products -> count() > 0)
   @foreach($products as $product)<option  value="{{$product -> id }}">{{$product -> name}}</option> @endforeach   @endif
                                                                </optgroup>
                                                            </select>
                                                            @error('product_id')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>                                                     


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1"> {{__('admin/product.select_Attributes')}}
                                                            </label>
                                                            <select name="attribute_id" class="select2 form-control" >
                                                                <optgroup label="{{__('admin/product.please_select_Attributes')}}">
                                                                    @if($attributes && $attributes -> count() > 0)
                                                                        @foreach($attributes as $attribute)
                                                                            <option
                                                                                value="{{$attribute -> id }}">{{$attribute -> name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </optgroup>
                                                            </select>
                                                            @error('attribute_id')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                           </div>
                                                    </div>

                                                </div>

                                           

  
                                            <div class="form-actions">
                                                <button type="button" class="btn btn-warning mr-1"
                                                        onclick="history.back();">
                                                    <i class="ft-x"></i> {{__('admin/product.back')}}
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> {{__('admin/product.update')}}
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
         
</div></div></div>
    @stop