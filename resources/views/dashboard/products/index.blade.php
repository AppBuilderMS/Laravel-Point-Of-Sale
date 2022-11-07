@extends('layouts.dashboard.app')
@section('content')
<section class="content-header" style="margin-bottom: 20px">
    <h1>
        @lang('site.products')
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> <a href="{{route('dashboard.welcome')}}">@lang('site.dashboard')</a></li>
        <li class="active"> @lang('site.products')</li>
    </ol>
</section>

<div class="box box-primary">
    <div class="box-header with-border">

        <h3 class="box-title" style="margin-bottom: 10px">@lang('site.products') <small>{{$products->total()}}</small></h3>

        <form action="{{route('dashboard.products.index')}}" method="GET">

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" name="search" class="form-control" style="border-radius: 5px" placeholder="@lang('site.search')" value="{{request()->search}}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <select name="category_id" id="" class="form-control" style="border-radius: 5px">
                            <option value="">@lang('site.all_ctegories')</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}" {{request()->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <button class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>

                    @if(auth()->user()->hasPermission('create_products'))
                        <a href="{{route('dashboard.products.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                    @else
                        <a href="#" class="btn btn-primary disabled"><i class="fa fa-plus"></i> @lang('site.add')</a>
                    @endif
                </div>
            </div>
        </form>

    </div><!-- /end of box-header -->

    <div class="box-body">
        @if($products->count() > 0)
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>@lang('site.name')</th>
                    <th>@lang('site.description')</th>
                    <th>@lang('site.image')</th>
                    <th>@lang('site.category')</th>
                    <th>@lang('site.purchase_price')</th>
                    <th>@lang('site.sale_price')</th>
                    <th>@lang('site.profit_percent')</th>
                    <th>@lang('site.stock')</th>
                    <th>@lang('site.actions')</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($products as $index=>$product)
                <tr>
                    <td>{{$index + 1}}</td>
                    <td>{{$product->name}}</td>
                    <td>{!! $product->description !!}</td>
                    <td><img src="{{$product->image_path}}" class="img-thumbnail" style="width: 50px" alt=""></td>
                    <td>{{$product->category->name}}</td>
                    <td>{{$product->purchase_price}}</td>
                    <td>{{$product->sale_price}}</td>
                    <td>{{$product->profit_percent}} %</td>
                    <td>{{$product->stock}}</td>
                    <td>
                        @if(auth()->user()->hasPermission('update_products'))
                            <a href="{{route('dashboard.products.edit', $product->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit fa-sm"></i> @lang('site.edit')</a>
                        @else
                            <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit fa-sm"></i> @lang('site.edit')</a>
                        @endif
                        @if(auth()->user()->hasPermission('delete_products'))
                            <form action="{{route('dashboard.products.destroy', $product->id)}}" method="post" style="display: inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm delete"><i class="fa fa-trash fa-sm"></i> @lang('site.delete')</button>
                            </form>
                        @else
                            <button class="btn btn-danger btn-sm disabled"><i class="fa fa-trash fa-sm"></i> @lang('site.delete')</button>
                        @endif
                    </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <h2>@lang('site.no_data_found')</h2>
        @endif

        {{$products->appends(request()->query())->links()}}
    </div><!-- /.box-body -->
</div>
@endsection
