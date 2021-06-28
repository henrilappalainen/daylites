<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Str;

class DaylitesController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Return Json Response
        return response()->json([
            'daylites' => 'Please provide latitude'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $latitude
     * @return \Illuminate\Http\Response
     */
    public function show($latitude)
    {
        echo "reading data...";

        return response()->json([
          'daylites' => []
        ], 200);
    }
}
