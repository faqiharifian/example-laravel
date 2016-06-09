<?php

namespace App\Http\Controllers;

use App\Models\ProductTag;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Product;
use App\Models\Category;
use Response;

use App\Models\CustomProduct;
use App\Models\CustomProductImage;
use Mail;
use DB;
use Config;
use Carbon\Carbon;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        dd(Product::paginate(5));
        $productPage = true;
        $products = new Product();
//        dd($request->all());
        if($request->get('category') != ""){
            $products = Category::whereSlug($request->get('category'))->first()->products();
        }else{
            $products = Product::where('name', 'like', '%%');
        }
        if($request->get('type') != ""){
            $products = $products->whereType($request->get('type'));
        }
        $products = $products->whereStatus('published')->orderBy('created_at', 'desc')->paginate(12);
        $products->appends([
            'type' => $request->get('type'),
            'category' => $request->get('category')
        ]);
//        dd($products);
        return view('products', compact('productPage', 'products'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        if($product->status != 'published'){
            return redirect()->back();
        }
        $productPage = false;
        $category = $product->category;
        $similars = $category->products()->where('id', '!=', $product->id)->whereStatus('published')->orderBy('created_at', 'desc')->limit(4)->get();
        return view('detail', compact('productPage', 'product', 'similars'));
    }

    public function search(Request $request){
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
            $products = $products->whereType($request->get('type'))->whereCategory_id($category->id);
        }

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
        if($request->get('new-add') != ''){
            $last = new Carbon('last '.$request->get('new-add'));
            $products = $products->where('created_at', '>', $last);
        }
        $products = $products->whereStatus('published')->orderBy('created_at', 'desc')->paginate(8);
        $products->appends([
            'q' => $request->get('q'),
            'type' => $request->get('type'),
            'category' => $request->get('category'),
            'materials' => $request->get('materials')
        ]);

        $materials = ProductTag::groupBy('name')->orderBy('name')->get();

        return view('search', compact('products', 'materials'));
    }

    public function custom(){
        $custom = true;
        $products = Product::whereStatus('published')->orderBy('created_at', 'desc')->limit(4)->get();
        return view('custom', compact('custom', 'products'));
    }

    public function postCustomImage(Request $request){
        $file = $request->file('file');
        $response = [
            'id' => 1,
            'custom_product_id' => 3,
            'success' => true,
            'key' => $request->key,
            'filename' => $file->getClientOriginalName(),
        ];
        return Response::json($response);
    }

    public function removeCustomImage(Request $request){
        dd($request->all());
        return Response::json(['success' => true]);
    }

    public function postCustom(Request $request){

        $this->validate($request, [
//            'id' => 'required|exists:custom_products:id',
            'specification' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        DB::beginTransaction();
        $custom = new CustomProduct();
//        $custom = CustomProduct::whereId($request->id)->first();
        $input = [
            'specification' => $request->specification,
            'detail' => $request->detail,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'new' => true,
        ];

        $custom->fill($input)->save();

        foreach($request->file('images') as $image){
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

            $customImage = new CustomProductImage();
            $customImage->image = $filename;
            $custom->images()->save($customImage);

            $image->move(Config::get('path.uploads').'/custom_products/'.$custom->id, $filename);
        }
        DB::commit();

        $images = $custom->images;
        $data = [
            'name' => $custom->name,
            'email' => $custom->email,
            'phone' => $custom->phone,
            'specification' => $custom->specification,
            'detail' => $custom->detail
        ];

        Mail::send('emails.custom-furniture', $data, function($message) use ($custom, $images) {
            $message->to(env('MAIL_NOTIFICATION'))->subject('New Custom Furniture Request');
            foreach($images as $image){
                $message->attach(Config::get('path.uploads').'/custom_products/'.$custom->id.'/'.$image->image);
            }
        });

        $success = "Your Custom Furniture Has Been Sent.";
        return redirect()->action('ProductController@custom')->withSuccess($success);
    }
}
