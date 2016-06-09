<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\CustomProduct;
use App\Models\CustomProductImage;
use File;
use Config;

class CustomProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(session('pageSize') == "") session()->put('pageSize', 10);

        $query = explode(" ", $request->get('q'));

        if(count($query) > 0){
            $customProducts = CustomProduct::where(function($product) use($query){
                foreach($query as $q){
                    $product->orWhere('name', 'like', '%'.$q.'%');
                }
                foreach($query as $q){
                    $product->orWhere('email', 'like', '%'.$q.'%');
                }
                foreach($query as $q){
                    $product->orWhere('specification', 'like', '%'.$q.'%');
                }
                foreach($query as $q){
                    $product->orWhere('detail', 'like', '%'.$q.'%');
                }
            });
        }else{
            $customProducts = new CustomProduct();
        }

        $customProducts = $customProducts->orderBy('new', 'desc')->paginate(session('pageSize'));
        return view('admin.custom_product.index', compact('customProducts'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CustomProduct $customProduct)
    {
        $customProduct->new = false;
        $customProduct->save();
        return view('admin.custom_product.show', compact('customProduct'));
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
    public function destroy(CustomProduct $customProduct)
    {
        File::deleteDirectory(Config::get('path.uploads').'/custom_products/'.$customProduct->id);
        $customProduct->delete();

        $success = "Custom Furniture Deleted Successfully";
        return redirect()->action('Admin\CustomProductController@index')->withSuccess($success);
    }
}
