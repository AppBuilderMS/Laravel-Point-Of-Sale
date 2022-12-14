@extends('layouts.dashboard.app')
@section('content')
<section class="content-header" style="margin-bottom: 20px">
    <h1>
        @lang('site.clients')
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> <a href="{{route('dashboard.welcome')}}">@lang('site.dashboard')</a></li>
        <li><a href="{{route('dashboard.clients.index')}}">@lang('site.clients')</a></li>
        <li class="active">@lang('site.add')</li>
    </ol>
</section>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title" style="margin-bottom: 10px">@lang('site.add')</h3>
    </div><!-- /end of box-header -->

    <div class="box-body">
        @include('partials._errors')

        <form action="{{route('dashboard.clients.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="form-group" style="margin-bottom: 10px">
                <label for="name">@lang('site.name')</label>
                <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}">
            </div>

            @for ($i = 0; $i < 2; $i++)
                <div class="form-group" style="margin-bottom: 10px">
                    <label for="phone">@lang('site.phone') {{$i+1}}</label>
                    <input type="text" name="phone[]" id="phone" class="form-control">
                </div>
            @endfor

            <div class="form-group" style="margin-bottom: 10px">
                <label for="address">@lang('site.address')</label>
                <textarea type="text" name="address" id="address" class="form-control">{{old('address')}}</textarea>
            </div>


            <div class="form-group" style="margin-bottom: 10px">
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>
            </div>
        </form>
    </div><!-- end of box-body -->
</div>
@endsection
