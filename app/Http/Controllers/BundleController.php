<?php

namespace App\Http\Controllers;

use App\Bundle;
use Illuminate\Http\Request;
use App\Http\Resources\Bundle as BundleResource;
use App\Http\Resources\BundleCollection;

class BundleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['bundlesMenu'] = 1;
    	$data['title'] = 'Manage Bundles';

        if (request()->expectsJson()) {
            return response([
                'data' => new BundleCollection(Bundle::all())
            ], 200);
        }

    	$data['bundles'] = Bundle::with('products')->get();
        return view('bundles.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

    	$rules = [
    	'name' => 'required',
    	];

    	$messages = [
    	'name.required' => 'Name is required',
    	];

        $this->validate($request, $rules, $messages);

        $bundle                 = new Bundle;
        $bundle->name 		    = $request->name;
    	$bundle->description    = $request->description;
    	$bundle->price   	    = $request->price;
    	$bundle->is_active      = $request->is_active ? 1 : 0;
    	$bundle->save();

    	return redirect('bundles');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function show(Bundle $bundle)
    {
    	$data['title'] = 'Edit Bundles';
    	$data['bundlesMenu'] = 1;

        if (request()->expectsJson()) {
            return response([
                'data' => new BundleResource(Bundle::find($bundle->id))
            ], 200);
        }

    	$data['bundle'] = Bundle::with('products')->where('id', $bundle->id)->first();
    	return view('bundles.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function edit(Bundle $bundle)
    {
    	$data['title'] = 'Edit Bundles';
    	$data['bundlesMenu'] = 1;
    	$data['bundle'] = Bundle::find($bundle->id);

    	return view('bundles.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bundle $bundle)
    {
        // dd($request->all());

    	$rules = [
    	'name' => 'required',
    	];

    	$messages = [
    	'name.required' => 'Name is required',
    	];

        $this->validate($request, $rules, $messages);

        $bundle                 = Bundle::find($bundle->id);
        $bundle->name 		    = $request->name;
    	$bundle->description    = $request->description;
    	$bundle->price   	    = $request->price;
    	$bundle->is_active      = $request->is_active ? 1 : 0;
    	$bundle->save();

    	return redirect('bundles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bundle $bundle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $bundle = Bundle::find($id);

        if ($bundle) {
            $bundle->delete();
        }

        return redirect()->route('bundles.index');
    }
}
