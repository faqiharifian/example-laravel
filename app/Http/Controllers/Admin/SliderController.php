<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Response;
use File;
use Config;
use Validator;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::orderBy('order', 'asc')->get();
        return view('admin.slider.index', compact('sliders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $last = Slider::orderBy('order', 'desc')->first();
        $image = $request->file('file');
        $slider = new Slider();
        $slider->image = $image->getClientOriginalName();
        if($last != null)
            $slider->order = $last->order+1;
        else
            $slider->order = 1;
        $slider->save();

        $arrayName = explode('.', $image->getClientOriginalName());
        $filename = "";
        $extension = "";
        foreach($arrayName as $i => $name){
            if($i != (count($arrayName)-1))
                $filename .= $name;
            else
                $extension = $name;
        }
        $filename = str_slug($filename)."-".$slider->id.".".$extension;
        $image->move(Config::get('path.uploads').'/sliders', $filename);

        $slider->image = $filename;
        $slider->save();

        return Response::json(['id' => $slider->id, 'image' => '/'.Config::get('path.uploads').'/sliders/'.$slider->image, 'success', 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request)
    {
        if($request->get('slider') == '') {
            $order = explode(",", $request->order);
            $i = 0;
            foreach ($order as $id) {
                if ($id != "") {
                    $slider = Slider::whereId($id)->first();
                    $slider->order = ++$i;
                    $slider->save();
                }
            }
        }else{
            $slider = Slider::whereId($request->get('slider'))->first();

            $validator = Validator::make($request->all(), [
                'url' => 'url'
            ]);

            if ($validator->fails()) {
                return Response::json($validator->errors());
            }

            $slider->url = $request->url;
            $slider->save();

            return Response::json(['success' => true]);
        }
    }

    public function toggle(Request $request){
        $slider = Slider::whereId($request->get('slider'))->first();

        $slider->show = !$slider->show;
        $slider->save();

        return redirect()->action('Admin\SliderController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $slider = Slider::whereId($request->id)->first();

        File::delete(Config::get('path.uploads').'/sliders/'.$slider->image);

        $slider->delete();

        return redirect()->action('Admin\SliderController@index');
    }
}
