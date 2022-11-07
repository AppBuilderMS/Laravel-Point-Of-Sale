@extends('layouts.dashboard.app')
@section('content')
<section class="content-header" style="margin-bottom: 20px">
    <h1>
        @lang('site.users')
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> <a href="{{route('dashboard.welcome')}}">@lang('site.dashboard')</a></li>
        <li><a href="{{route('dashboard.users.index')}}">@lang('site.users')</a></li>
        <li class="active">@lang('site.edit')</li>
    </ol>
</section>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title" style="margin-bottom: 10px">@lang('site.edit')</h3>
    </div><!-- /end of box-header -->

    <div class="box-body">
        @include('partials._errors')

        <form action="{{route('dashboard.users.update', $user->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group" style="margin-bottom: 10px">
                <label for="first_name">@lang('site.first_name')</label>
                <input type="text" name="first_name" class="form-control" value="{{$user->first_name}}">
            </div>

            <div class="form-group" style="margin-bottom: 10px" >
                <label for="last_name">@lang('site.last_name')</label>
                <input type="text" name="last_name" class="form-control" value="{{$user->last_name}}">
            </div>

            <div class="form-group" style="margin-bottom: 10px">
                <label for="email">@lang('site.email')</label>
                <input type="email" name="email" class="form-control" value="{{$user->email}}">
            </div>

            <div class="form-group" style="margin-bottom: 10px">
                <label for="image">@lang('site.image')</label>
                <input type="file" name="image" class="form-control image">
            </div>

            <div class="form-group" style="margin-bottom: 10px">
                <img src="{{ $user->image_path}}" class="img-thumbnail image-preview" style="width: 100px" alt="">
            </div>

            <div class="form-group" style="margin-bottom: 10px">
                <label for="permissions">@lang('site.permissions')</label>
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    @php
                        $models = ['users', 'categories', 'products', 'clients', 'orders'];
                        $maps = ['create', 'read', 'update', 'delete'];
                    @endphp
                    <ul class="nav nav-tabs">
                        @foreach ($models as $index=>$model)
                            <li class="{{$index == 0 ? 'active' : ''}}"><a href="#{{$model}}" data-toggle="tab">@lang('site.' . $model)</a></li>
                        @endforeach
                    </ul><!--end of nav tabs-->

                    <div class="tab-content">
                        @foreach ($models as $index=>$model)
                            <div class="tab-pane {{$index == 0 ? 'active' : ''}}" id="{{$model}}">
                                @foreach ($maps as $index=>$map)
                                    <label><input type="checkbox" name="permissions[]" {{$user->hasPermission($map . '_' . $model) ? 'checked' : ''}} value="{{$map}}_{{$model}}"> @lang('site.' . $map)</label>
                                @endforeach
                            </div>
                        @endforeach
                    </div><!-- end of tab-content -->

                </div><!--end of nav-tabs-custom -->
            </div>

            <div class="form-group" style="margin-bottom: 10px">
                <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.edit')</button>
            </div>
        </form>
    </div><!-- end of box-body -->
</div>
@endsection
