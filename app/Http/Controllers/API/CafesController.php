<?php

namespace App\Http\Controllers\API;

use App\Utilities\GoogleMaps;
use App\Http\Requests\StoreCafeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cafe;

class CafesController extends Controller
{

    /*
    |-------------------------------------------------------------------------------
    | Get All Cafes
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/cafes
    | Method:         GET
    | Description:    Gets all of the cafes in the application
    */
    public function getCafes()
    {
        $cafes = Cafe::all();
        return response()->json($cafes);
    }

    /*
    |-------------------------------------------------------------------------------
    | Get An Individual Cafe
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/cafes/{id}
    | Method:         GET
    | Description:    Gets an individual cafe
    | Parameters:
    |   $id   -> ID of the cafe we are retrieving
    */
    public function getCafe($id)
    {
        $cafe = Cafe::where('id', '=', $id)->first();

        return response()->json($cafe);
    }

    /*
    |-------------------------------------------------------------------------------
    | Adds a New Cafe
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/cafes
    | Method:         POST
    | Description:    Adds a new cafe to the application
    */
    public function postNewCafe(StoreCafeRequest $request)
    {
        $coordinates = GoogleMaps::geocodeAddress(
            $request->get('address'),
            $request->get('city'),
            $request->get('state'),
            $request->get('zip')
        );

        $cafe = new Cafe();

        $cafe->name      = $request->get('name');
        $cafe->address   = $request->get('address');
        $cafe->city      = $request->get('city');
        $cafe->state     = $request->get('state');
        $cafe->zip       = $request->get('zip');
        $cafe->latitude  = $request->get('lat');
        $cafe->longitude = $request->get('lng');

        $cafe->save();

        return response()->json($cafe, 201);
    }
}
