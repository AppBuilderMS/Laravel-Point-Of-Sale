<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Models\Client;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        $title = trans('site.dashboard');
        $products_count = Product::count();
        $users_count = User::whereRoleIs('admin')->count();
        $clients_count = Client::count();
        $categories_count = Category::count();
        $orders_count = Order::count();

        $sales_data = Order::select([
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as sum')
        ])->groupBy('month')->get();

        return view('dashboard.welcome', compact('title', 'products_count', 'users_count', 'clients_count', 'categories_count', 'orders_count', 'sales_data'));
    }//end of index
}//end of controller
