<div id="print-area">
    <table class="table table-bordered table-hover table-responsive">
        <thead>
            <tr>
                <th>@lang('site.name')</th>
                <th>@lang('site.quantity')</th>
                <th>@lang('site.price')</th>
            </tr>
        </thead>

        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{$product->name}}</td>
                    <td>{{$product->pivot->quantity}}</td>
                    <td>{{number_format($product->pivot->quantity * $product->sale_price, 2)}}</td>
                </tr>
            @endforeach
        </tbody>

    </table>

    <h3>@lang('site.total')</h3><span>{{number_format($order->total_price, 2)}}</span>
</div>

<button class="btn btn-primary btn-block print-btn"><i class="fa fa-print"></i> @lang('site.print')</button>
