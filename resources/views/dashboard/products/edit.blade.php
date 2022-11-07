@extends('layouts.dashboard.app')
@section('content')
<section class="content-header" style="margin-bottom: 20px">
    <h1>
        @lang('site.products')
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> <a href="{{route('dashboard.welcome')}}">@lang('site.dashboard')</a></li>
        <li><a href="{{route('dashboard.products.index')}}">@lang('site.products')</a></li>
        <li class="active">@lang('site.edit')</li>
    </ol>
</section>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title" style="margin-bottom: 10px">@lang('site.edit')</h3>
    </div><!-- /end of box-header -->

    <div class="box-body">
        @include('partials._errors')

        <form action="{{route('dashboard.products.update', $product->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-goup" style="margin-bottom: 10px">
                <label for="category_id">@lang('site.categories')</label>
                <select name="category_id" id="category_id" class="form-control">
                    <option value="">@lang('site.all_ctegories')</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}" {{$category->id == $product->category_id ? 'selected' : ''}}>{{$category->name}}</option>
                    @endforeach
                </select>
            </div>

            @foreach (config('translatable.locales') as $locale)
                <div class="form-goup" style="margin-bottom: 10px">
                    <label for="name">@lang('site.'.$locale.'.name')</label>
                    <input type="text" name="{{$locale}}[name]" class="form-control" value="{{$product->name}}">
                </div>

                <div class="form-goup" style="margin-bottom: 10px">
                    <label for="description">@lang('site.'.$locale.'.description')</label>
                    <textarea name="{{$locale}}[description]" class="form-control ckeditor" >{{$product->description}}</textarea>
                </div>
            @endforeach

            <div class="form-goup" style="margin-bottom: 10px">
                <label for="image">@lang('site.image')</label>
                <input type="file" name="image" class="form-control image">
            </div>

            <div class="form-goup" style="margin-bottom: 10px">
                <img src="{{$product->image_path}}" class="img-thumbnail image-preview" style="width: 100px" alt="">
            </div>

            <div class="form-goup" style="margin-bottom: 10px">
                <label for="purchase_price">@lang('site.purchase_price')</label>
                <input type="number" name="purchase_price" step="0.01" class="form-control" value="{{$product->purchase_price}}">
            </div>

            <div class="form-goup" style="margin-bottom: 10px">
                <label for="sale_price">@lang('site.sale_price')</label>
                <input type="number" name="sale_price" step="0.01" class="form-control" value="{{$product->sale_price}}">
            </div>


            <div class="form-goup" style="margin-bottom: 10px">
                <label for="stock">@lang('site.stock')</label>
                <input type="number" name="stock" class="form-control" value="{{$product->stock}}">
            </div>


            <div class="form-group" style="margin-bottom: 10px">
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.edit')</button>
            </div>
        </form>
    </div><!-- end of box-body -->
</div>
@endsection
