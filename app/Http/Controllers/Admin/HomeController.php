<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Storage;
use File;
use Config;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dashboard = true;
        $count = [
            'products' => \App\Models\Product::all()->count(),
            'customProducts' => \App\Models\CustomProduct::all()->count(),
        ];
        $sliders = \App\Models\Slider::orderBy('order', 'asc')->get();
        $products = \App\Models\Product::orderBy('created_at', 'desc')->take(5)->get();
        $customProducts = \App\Models\CustomProduct::orderBy('new', 'desc')->take(5)->get();
        return view('admin.dashboard', compact('dashboard', 'sliders', 'count', 'products', 'customProducts'));
    }

    public function postCatalog(Request $request){
        $this->validate($request, ['file' => 'required']);

        $file = $request->file('file');
        if($request->filename != ""){
            $filename = str_slug($request->filename).".pdf";
        }else{
            $filename = explode('.', $file->getClientOriginalName());
            array_pop($filename);
            $filename = str_slug(implode('.', ($filename))) .".".$file->getClientOriginalExtension();
        }

        if(Storage::exists('public/catalog.json')) {
            $oldJson = json_decode(Storage::get('public/catalog.json'));
        }else{
            $oldJson = "";
        }
        if($oldJson != ""){
            $oldFilename = $oldJson->filename;
            File::delete(Config::get('path.uploads')."/".$oldFilename);
        }

        $file->move(Config::get('path.uploads'), $filename);
        $jsonContent = [
            'filename' => $filename,
            'lastModify' => Carbon::now()->timestamp,
        ];
        Storage::put('public/catalog.json', json_encode($jsonContent));

        $success = "Catalog has been updated";
        return redirect()->action('Admin\HomeController@index')->withStatus($success);
    }
}
