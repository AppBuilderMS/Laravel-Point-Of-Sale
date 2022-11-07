@extends('layouts.dashboard.app')
@section('content')
<section class="content-header" style="margin-bottom: 20px">
    <h1>
        @lang('site.users')
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> <a href="{{route('dashboard.welcome')}}">@lang('site.dashboard')</a></li>
        <li class="active"> @lang('site.users')</li>
    </ol>
</section>

<div class="box box-primary">
    <div class="box-header with-border">

        <h3 class="box-title" style="margin-bottom: 10px">@lang('site.users') <small>{{$users->total()}}</small></h3>

        <form action="{{route('dashboard.users.index')}}" method="GET">

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" name="search" class="form-control" style="border-radius: 5px" placeholder="@lang('site.search')" value="{{request()->search}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                    @if(auth()->user()->hasPermission('create_users'))
                        <a href="{{route('dashboard.users.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                    @else
                        <a href="#" class="btn btn-primary disabled"><i class="fa fa-plus"></i> @lang('site.add')</a>
                    @endif
                </div>
            </div>
        </form>

    </div><!-- /end of box-header -->

    <div class="box-body">
        @if($users->count() > 0)
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>@lang('site.first_name')</th>
                    <th>@lang('site.last_name')</th>
                    <th>@lang('site.email')</th>
                    <th>@lang('site.image')</th>
                    <th>@lang('site.actions')</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $index=>$user)
                <tr>
                    <td>{{$index + 1}}</td>
                    <td>{{$user->first_name}}</td>
                    <td>{{$user->last_name}}</td>
                    <td>{{$user->email}}</td>
                    <th><img src="{{ $user->image_path }}" alt="" style="width: 50px" class="img-thumbnail"></th>
                    <td>
                        @if(auth()->user()->hasPermission('update_users'))
                            <a href="{{route('dashboard.users.edit', $user->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit fa-sm"></i> @lang('site.edit')</a>
                        @else
                            <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit fa-sm"></i> @lang('site.edit')</a>
                        @endif
                        @if(auth()->user()->hasPermission('delete_users'))
                            <form action="{{route('dashboard.users.destroy', $user->id)}}" method="post" style="display: inline-block">
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

        {{$users->appends(request()->query())->links()}}
    </div><!-- /.box-body -->
</div>
@endsection
