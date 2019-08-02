<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductCollection;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['productsMenu'] = 1;
    	$data['title'] = 'Manage Products';
        $products = Product::with('categories')->get();

        if (request()->expectsJson()) {
            return response([
                'data' => new ProductCollection($products)
            ], 200);
        }

        $data['products'] = $products;
        
        return view('products.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $data['categories'] = Category::all();

        return view('products.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());

    	$rules = [
    	'name' => 'required',
    	'unit_price' => 'required',
    	'name' => 'required',
    	'name' => 'required',
    	];

    	$messages = [
    	'name.required' => 'Name is required',
    	];

        $this->validate($request, $rules, $messages);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('id', $id)->with('categories')->first();

        if(request()->expectsJson()) {
            return response([
                'data' => new ProductResource($product)
            ], 200);
        }

        $data['product'] = $product;

        return view('products.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
