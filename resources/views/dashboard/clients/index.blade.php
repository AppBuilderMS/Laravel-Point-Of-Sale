@extends('layouts.dashboard.app')
@section('content')
<section class="content-header" style="margin-bottom: 20px">
    <h1>
        @lang('site.clients')
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> <a href="{{route('dashboard.welcome')}}">@lang('site.dashboard')</a></li>
        <li class="active"> @lang('site.clients')</li>
    </ol>
</section>

<div class="box box-primary">
    <div class="box-header with-border">

        <h3 class="box-title" style="margin-bottom: 10px">@lang('site.clients') <small>{{$clients->total()}}</small></h3>

        <form action="{{route('dashboard.clients.index')}}" method="GET">

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" name="search" class="form-control" style="border-radius: 5px" placeholder="@lang('site.search')" value="{{request()->search}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                    @if(auth()->user()->hasPermission('create_clients'))
                        <a href="{{route('dashboard.clients.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                    @else
                        <a href="#" class="btn btn-primary disabled"><i class="fa fa-plus"></i> @lang('site.add')</a>
                    @endif
                </div>
            </div>
        </form>

    </div><!-- /end of box-header -->

    <div class="box-body">
        @if($clients->count() > 0)
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>@lang('site.name')</th>
                    <th>@lang('site.phone')</th>
                    <th>@lang('site.address')</th>
                    <th>@lang('site.add_orders')</th>
                    <th>@lang('site.actions')</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($clients as $index=>$client)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $client->name }}</td>
                    <td>{{ is_array($client->phone) ? implode(' - ', $client->phone) : $client->phone }}</td> {{--implode('-', array_filter($client->phone) moved to controller--}}
                    <td>{{ $client->address }}</td>
                    <td>
                        @if(auth()->user()->hasPermission('create_orders'))
                            <a href="{{route('dashboard.clients.orders.create', $client->id)}}" class="btn btn-primary btn-sm">@lang('site.add_orders')</a>
                        @else
                            <a href="#" class="btn btn-primary btn-sm disabled">@lang('site.add_orders')</a>
                        @endif
                    </td>
                    <td>
                        @if(auth()->user()->hasPermission('update_clients'))
                            <a href="{{route('dashboard.clients.edit', $client->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit fa-sm"></i> @lang('site.edit')</a>
                        @else
                            <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit fa-sm"></i> @lang('site.edit')</a>
                        @endif
                        @if(auth()->user()->hasPermission('delete_clients'))
                            <form action="{{route('dashboard.clients.destroy', $client->id)}}" method="post" style="display: inline-block">
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

        {{$clients->appends(request()->query())->links()}}
    </div><!-- /.box-body -->
</div>
@endsection
