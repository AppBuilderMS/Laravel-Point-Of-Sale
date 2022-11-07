<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Models\Category;
use App\Models\Client;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Client $client)
    {
        $title = trans('site.add_orders');
        $categories = Category::with('products')->get();
        $orders = $client->orders()->with('products')->paginate(5);
        return view('dashboard.clients.order.create', compact('client', 'title', 'categories', 'orders'));
    }//end of create

    public function store(Request $request, Client $client)
    {
        $request->validate([
           'products'   => 'required|array',
        ]);

        $this->attach_order($client, $request);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.orders.index');

    }//end of store

    public function edit(Client $client, Order $order)
    {
        $title = trans('site.edit');
        $categories = Category::with('products')->get();
        $orders = $client->orders()->with('products')->paginate(5);
        return view('dashboard.clients.order.edit ', compact('title', 'categories', 'client', 'order', 'orders'));
    }//end of edit

    public function update(Request $request, Client $client, Order $order)
    {

        $request->validate([
            'products' => 'sometimes|required|array',
        ]);

        $this->detach_order($order);
        $this->attach_order($client, $request);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.orders.index');
    }//end of update

    private function attach_order($client, $request)
    {
        $order = $client->orders()->create([]);

        $order->products()->attach($request->products);

        $total_price = 0;

        if(!empty($request->products)){
            foreach ($request->products as $id=>$quantity)
            {
                $product = Product::findOrFail($id);

                $total_price += $product->sale_price * $quantity['quantity'];

                $product->update([
                    'stock' => $product->stock - $quantity['quantity']
                ]);
            }//end of foreach
        }
        $order->update([
            'total_price'    =>  $total_price
        ]);

        if($order->total_price == 0.0){
            $order->delete();
        }
    }//end of attach_product

    private function detach_order($order)
    {
        foreach ($order->products as $product){

            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);

        }

        $order->delete();
    }//end of detach_product

}//end of controller
