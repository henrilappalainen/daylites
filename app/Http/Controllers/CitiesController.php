<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use Storage;
use App\Http\Requests\CityStoreRequest;
use Illuminate\Support\Str;

class CitiesController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // All Cities
        $cities = City::all();

        // Return Json Response
        return response()->json([
            'cities' => $cities
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        echo "create function fired...";
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityStoreRequest $request)
    {
        try {
            echo "trying...";
            // Create City
            City::create([
                'name' => $request->name,
                'latitude' => $request->latitude
            ]);

            // Return Json Response
            return response()->json([
                'message' => "City successfully created."
            ],200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ],500);
        }
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // City Detail 
        $city = City::find($id);

        if(!$city) {
            return response()->json([
                'message'=>'City Not Found.'
            ],404);
        }

        // Public storage
        $storage = Storage::disk('public');

        // Iamge delete
        if($storage->exists($city->image))
            $storage->delete($city->image);

        // Delete City
        $city->delete();

        // Return Json Response
        return response()->json([
            'message' => "City successfully deleted."
        ],200);
    }
}
