<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $products = Product::when($request->search, function ($q) use ($request) {
            return $q->whereTranslationLike('name', '%' . $request->search . '%');
        })->when($request->category_id, function ($q) use ($request) {
            return $q->where('category_id', $request->category_id);
        })->latest()->paginate(5);

        $categories = Category::all();
        $title = trans('site.products');
        return view('dashboard.products.index', compact('products', 'categories', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $title = trans('site.create');
        return view('dashboard.products.create', compact('categories', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'category_id' => 'required'
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => 'required|unique:product_translations,name'];
            $rules += [$locale . '.description' => 'required'];
        }
        $rules += [
            'image' => 'image',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required'
        ];

        $request->validate($rules);

        $request_data = $request->except(['image']);

        if ($request->image) {
            //http://image.intervention.io/api/resize & http://image.intervention.io/api/save
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
                ->save(public_path('uploads/products_images/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();
        }


        $product = Product::create($request_data);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.products.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $title = trans('site.edit');
        return view('dashboard.products.edit', compact('categories', 'title', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $rules = [
            'category_id' => 'required'
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('product_translations', 'name')->ignore($product->id, 'product_id')]];
            $rules += [$locale . '.description' => 'required'];
        }
        $rules += [
            'image' => 'image',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required'
        ];

        $request->validate($rules);

        $request_data = $request->except(['image']);

        if ($request->image) {
            if ($product->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/products_images/' . $product->image);
            }

            //http://image.intervention.io/api/resize & http://image.intervention.io/api/save
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
                ->save(public_path('uploads/products_images/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();
        }

        $product->update($request_data);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.products.index');
    }
}
