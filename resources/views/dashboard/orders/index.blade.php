@extends('layouts.dashboard.app')
@section('content')

    <style>
        .lds-ring {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }
        .lds-ring div {
            box-sizing: border-box;
            display: block;
            position: absolute;
            width: 64px;
            height: 64px;
            margin: 8px;
            border: 8px solid #3c8dbc;
            border-radius: 50%;
            animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
            border-color: #3c8dbc transparent transparent transparent;
        }
        .lds-ring div:nth-child(1) {
            animation-delay: -0.45s;
        }
        .lds-ring div:nth-child(2) {
            animation-delay: -0.3s;
        }
        .lds-ring div:nth-child(3) {
            animation-delay: -0.15s;
        }
        @keyframes lds-ring {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

    </style>

<section class="content-header" style="margin-bottom: 20px">
    <h1>
        @lang('site.orders')
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> <a href="{{route('dashboard.welcome')}}">@lang('site.dashboard')</a></li>
        <li class="active"> @lang('site.orders')</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-7">
            <div class="box box-primary">
                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 10px">@lang('site.orders') <small>{{$orders->total()}}</small></h3>

                    <form action="{{route('dashboard.orders.index')}}" method="GET">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="text" name="search" class="form-control" style="border-radius: 5px" placeholder="@lang('site.search')" value="{{request()->search}}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <button class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                            </div>
                        </div>
                    </form>

                </div><!-- /end of box-header -->

                <div class="box-body">
                    @if($orders->count() > 0)
                        <table class="table table-bordered table-hover table-responsive">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>@lang('site.client_name')</th>
                                <th>@lang('site.price')</th>
                                {{--                            <th>@lang('site.status')</th>--}}
                                <th>@lang('site.created_at')</th>
                                <th>@lang('site.actions')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($orders as $index=>$order)
                                <tr>
                                    <td>{{$index + 1}}</td>
                                    <td>{{$order->client->name}}</td>
                                    <td>{{number_format($order->total_price, 2)}}</td>
                                    <td>{{$order->created_at->toFormattedDateString()}}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm order-products"
                                                data-url="{{route('dashboard.orders.products', $order->id)}}"
                                                data-method ="get"
                                        >
                                            <i class="fa fa-list-alt fa-sm"></i>
                                            @lang('site.show')
                                        </button>
                                        @if(auth()->user()->hasPermission('update_products'))
                                            <a href="{{route('dashboard.clients.orders.edit', ['client'=>$order->client->id,'order'=>$order->id])}}" class="btn btn-warning btn-sm"><i class="fa fa-edit fa-sm"></i> @lang('site.edit')</a>
                                        @else
                                            <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit fa-sm"></i> @lang('site.edit')</a>
                                        @endif
                                        @if(auth()->user()->hasPermission('delete_orders'))
                                            <form action="{{route('dashboard.orders.destroy', $order->id)}}" method="post" style="display: inline-block">
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

                    {{$orders->appends(request()->query())->links()}}
                </div><!-- /.box-body -->
            </div>
        </div>

        <div class="col-md-5">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="box-header with-border">
                        <h3 class="box-title" style="margin-bottom: 10px">@lang('site.show_products')</h3>
                    </div>

                    <div class="box-body">

                        <div id="loader" style="display: none; flex-direction: column; align-items: center">
                            <div class="lds-ring" style="display: block; margin: auto"><div></div><div></div><div></div><div></div></div>
                            <p style="">@lang('site.loading')</p>
                        </div>

                        <div id="oder-product-list">

                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

@endsection
