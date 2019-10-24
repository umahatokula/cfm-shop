<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\CategoryProduct;
use App\Category;
use App\Preacher;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductCollection;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Illuminate\Support\Arr;
use Spatie\Searchable\Search;
use Illuminate\Contracts\Filesystem\Filesystem;

use Image;
use URL;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($category_slug = null)
    {
        $data['productsMenu'] = 1;
        $data['title'] = 'Manage Products';
        if ($category_slug) {
            $category = Category::where('slug', $category_slug)->first();
            $categoryProducts = CategoryProduct::select('product_id')->where('category_id', $category->id)->get()->toArray();

            // flatten muli dimenasional array
            $productIDs = Arr::flatten($categoryProducts);

            $products = Product::with('categories', 'preacher')->orderBy('date_preached', 'desc')->get();

            $products = $products->whereIn('id', $productIDs)->paginate(24);

            // dd($products->count());
        } else {
            $products = Product::with('categories', 'preacher')->orderBy('date_preached', 'desc')->paginate(24);
        }        

        if (request()->expectsJson()) {
            return $products;
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
        $data['categories'] = Category::pluck('name', 'id');
        $data['preachers'] = Preacher::pluck('name', 'id');

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
        // dd($request->all());

    	$rules = [
    	'name' => 'required',
    	'unit_price' => 'required',
    	'categories' => 'required',
    	'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    	];

    	$messages = [
    	'name.required' => 'Product Name is required',
    	];

        $this->validate($request, $rules, $messages);

        // prepare and upload product image
        $image = $request->file('image');
        $img = Image::make($image->getRealPath());
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
     
        $destinationPath = 'products-images/';

        $originalImageDestinationPath = public_path($destinationPath);
        $originalImg = $img->save($originalImageDestinationPath.'/'.$input['imagename']);
        

        $thumbnailDestinationPath = public_path($destinationPath.'thumbnail');

        // $thumbnail = $img->resize(300, 200, function ($constraint) {
		//     $constraint->aspectRatio();
        // })->save($thumbnailDestinationPath.'/'.$input['imagename']);

        $thumbnail = $img
                    ->resize(250, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->text('WordShop', 20, 0, function($font) {
                        // $font->file('foo/bar.ttf');
                        $font->size(24);
                        $font->color('#fdf6e3');
                        $font->align('center');
                        $font->valign('top');
                        $font->angle(45);
                    })
                    ->save($thumbnailDestinationPath.'/'.$input['imagename']);

        // upload downloadable file
        $download_link = '';
        if ($request->hasFile('downloadable_file')) {
            $downloadableFile = $request->file('downloadable_file');
            $downloadableFileName = time() . '.' . $downloadableFile->getClientOriginalExtension();
            $s3 = \Storage::disk('s3');
            $filePath = date('Y') .'/'. date('m') .'/'. $downloadableFileName;
            $s3->put($filePath, file_get_contents($downloadableFile), 'public');
            $download_link = env('AWS_URL').$filePath;
        }

        $product  = new Product;
        $product->name  = $request->name;      
        $product->sku  = $request->sku;      
        $product->description  = $request->description;
        $product->unit_price  = $request->unit_price;
        $product->discount_price  = $request->discount_price;
        $product->quantity_per_unit  = $request->has('quantity_per_unit') ? $request->quantity_per_unit : 0;
        $product->units_in_stock  = $request->has('units_in_stock') ? $request->units_in_stock : 0;
        $product->is_digital  = $request->has('is_digital') ? 1 : 0;
        $product->is_audio  = $request->has('is_audio') ? 1 : 0;
        $product->is_taxable  = $request->has('is_taxable') ? 1 : 0;
        $product->is_available  = $request->has('is_available') ? 1 : 0;
        $product->is_discountable  = $request->has('is_discountable') ? 1 : 0;
        $product->reorder_level  = $request->reorder_level;
        $product->download_link  = $request->download_link ? $request->download_link : $download_link;
        $product->preacher_id  = $request->preacher_id;
        $product->date_preached  = $request->date_preached;
        $product->size  = $image->getSize();
        $product->format  = $image->getMimeType();
        $product->large_image_path  = URL::to('/').'/'.$destinationPath.$originalImg->basename;
        $product->thumbnail_image_path  = URL::to('/').'/'.$destinationPath.'thumbnail/'.$thumbnail->basename;
        $product->save();

        foreach ($request->categories as $category_id) {
            $cp = new CategoryProduct;
            $cp->product_id = $product->id;
            $cp->category_id = $category_id;
            $cp->save();
        }

        return redirect()->route('products.index');

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


    public function download($product_id) {
                
        $s3Client = \Storage::disk('s3')->getDriver()->getAdapter()->getClient();

        $signedUrl = $s3Client->getObjectUrl('cfm-media-audio', 'https://cfm-media-audio.s3.amazonaws.com/Shedding+scales.mp3', '+10 minutes');
        dd($signedUrl);

        // secret: nW/SMC1lsYQyA/jlQt72rMGdx+/hWwC4Sq1/zICp
        // key: AKIATYSMHYAZ6FCHR522

        return response();
        

    }

    public function search(Request $request) {

        // $results = (new Search())
        // ->registerModel(Product::class, ['name', 'slug'])
        // ->search($request->input('query'));

        // return response()->json($results);

        $results = Product::search($request->input('query'))
                    // ->with('posts')
                    ->get();

        return response()->json($results->orderBy('date_preached', 'desc')->paginate(20));

    }

}
