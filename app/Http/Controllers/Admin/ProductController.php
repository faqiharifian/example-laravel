<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Validator;
use DB;
use Config;
use File;
use League\CommonMark\CommonMarkConverter;
use App\Models\ProductTag;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(session('pageSize') == "") session()->put('pageSize', 10);
        if($request->get('materials') != "") {
            $materials = explode(",", $request->get('materials'));
            $productTags = ProductTag::where(function ($tag) use ($materials) {
                foreach ($materials as $material) {
                    $tag->orWhere('name', '=', $material);
                }
            })->groupBy('product_id')->get();
            $products = Product::where(function ($product) use ($productTags) {
                foreach ($productTags as $tag) {
                    $product->orWhere('id', '=', $tag->product_id);
                }
            });
        }else{
            $products = new Product();
        }

        $query = explode(" ", $request->get('q'));

        if($request->get('category') != ""){
            $category = Category::whereSlug($request->get('category'))->first();
            $products = $products->whereCategory_id($category->id);
        }

        if($request->get('type') != "")
            $products = $products->whereType($request->get('type'));

        if(count($query) > 0){
            $products = $products->where(function($product) use($query){
                foreach($query as $q){
                    $product->orWhere('name', 'like', '%'.$q.'%');
                }
                foreach($query as $q){
                    $product->orWhere('subtitle', 'like', '%'.$q.'%');
                }
                foreach($query as $q){
                    $product->orWhere('detail', 'like', '%'.$q.'%');
                }
                foreach($query as $q){
                    $product->orWhere('material', 'like', '%'.$q.'%');
                }
            });
        }
        $products = $products->orderBy('created_at', 'desc')->paginate(session('pageSize'));
        $products->appends([
            'q' => $request->get('q'),
            'type' => $request->get('type'),
            'category' => $request->get('category'),
            'materials' => $request->get('materials')
        ]);

        $materials = ProductTag::groupBy('name')->orderBy('name')->get();
        $categories = Category::all();
        return view('admin.product.index', compact('products', 'categories', 'materials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = true;
        $tags = ProductTag::groupBy('name')->get();
        return view('admin.product.create', compact('product', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:20',
            'subtitle' => 'max:30',
            'detail' => 'required',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'depth' => 'required|numeric',
            'weight' => 'required|numeric',
            'type' => 'required',
            'category' => 'required|exists:categories,slug',
            'images' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        $converter = new CommonMarkConverter();

        $category = Category::whereSlug($request->category)->first();

        $input = [
            'name' => $request->name,
            'subtitle' => $request->subtitle,
            'detail' => $request->detail,
            'detail_html' => e($converter->convertToHtml($request->detail)),
            'width' => $request->width,
            'height' => $request->height,
            'depth' => $request->depth,
            'weight' => $request->weight,
            'type' => $request->type,
            'status' => $request->status
        ];
        $product = new Product();
        $product->fill($input);

        $category->products()->save($product);

        foreach($request->file('images') as $key => $image){
            $arrayName = explode('.', $image->getClientOriginalName());
            $filename = "";
            $extension = "";
            foreach($arrayName as $i => $name){
                if($i != (count($arrayName)-1))
                    $filename .= $name;
                else
                    $extension = $name;
            }
            $filename = str_slug($filename).".".$extension;
            $image->move(Config::get('path.uploads').'/products/'.$product->id, $filename);

            $productImage = new ProductImage();
            $productImage->image = $filename;
            $productImage->order = ($key+1);
            $product->images()->save($productImage);
        }

        $materials = explode(",", $request->materials);
        foreach($materials as $material){
            $productTag = new ProductTag();
            $productTag->name = strtolower($material);
            $product->tags()->save($productTag);
        }

        DB::commit();

        $success = "New Product Added Successfully";

        return redirect()->action('Admin\ProductController@index')->withSuccess($success);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $tags = ProductTag::groupBy('name')->get();
        $materials = [];
        foreach($product->tags as $key => $tag){
            $materials[] = ucwords($tag->name);
        }
         $materials = implode(",", $materials);
        return view('admin.product.edit', compact('product', 'tags', 'materials'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:20',
            'subtitle' => 'max:30',
            'detail' => 'required',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'depth' => 'required|numeric',
            'weight' => 'required|numeric',
            'type' => 'required',
            'category' => 'required|exists:categories,slug',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        $converter = new CommonMarkConverter();

        $category = Category::whereSlug($request->category)->first();

        $input = [
            'name' => $request->name,
            'subtitle' => $request->subtitle,
            'detail' => $request->detail,
            'detail_html' => e($converter->convertToHtml($request->detail)),
            'width' => $request->width,
            'height' => $request->height,
            'depth' => $request->depth,
            'weight' => $request->weight,
            'type' => $request->type,
            'status' => $request->status
        ];
        $product->fill($input);

        $category->products()->save($product);

        if($request->file('images')[0] != null) {
            File::deleteDirectory(Config::get('path.uploads').'/products/'.$product->id);
            $product->images()->delete();

            foreach ($request->file('images') as $key => $image) {
                $arrayName = explode('.', $image->getClientOriginalName());
                $filename = "";
                $extension = "";
                foreach ($arrayName as $i => $name) {
                    if ($i != (count($arrayName) - 1))
                        $filename .= $name;
                    else
                        $extension = $name;
                }
                $filename = str_slug($filename) . "." . $extension;
                $image->move(Config::get('path.uploads') . '/products/' . $product->id, $filename);

                $productImage = new ProductImage();
                $productImage->image = $filename;
                $productImage->order = ($key + 1);
                $product->images()->save($productImage);
            }
        }

        $tags = $product->tags;
        $materials = explode(",", strtolower($request->materials));

        foreach($tags as $tag){
            $index = array_search($tag->name, $materials);
            if($index === false){
                $tag->delete();
            }else{
                unset($materials[$index]);
            }
        }

        foreach($materials as $material){
            $productTag = new ProductTag();
            $productTag->name = $material;
            $product->tags()->save($productTag);
        }

        DB::commit();

        $success = "Product Updated Successfully";

        return redirect()->action('Admin\ProductController@index')->withSuccess($success);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $id = $product->id;
        DB::beginTransaction();
        foreach($product->images as $image){
            $image->delete();
        }
        $product->delete();
        DB::commit();

        File::deleteDirectory(Config::get('path.uploads').'/products/'.$id);

        $success = "Product Deleted Successfully";
        return redirect()->action('Admin\ProductController@index')->withSuccess($success);
    }

    public function setPageSize(Request $request){
        session()->put('pageSize', $request->get('pageSize'));
        return redirect($request->get('redirect'));
    }
}
