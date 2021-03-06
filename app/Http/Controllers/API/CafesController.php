<?php

namespace App\Http\Controllers\API;

use App\Utilities\Tagger;
use App\Utilities\GoogleMaps;
use App\Http\Requests\StoreCafeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cafe;
use Auth;
use DB;

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
        /**
         * When we load the cafes, we also want to load the brew methods associated with the Cafe.
         * We want to do this by calling the relationship method on the model when we retrieve our data.
         */
        $cafes = Cafe::with('brewMethods')->get();
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
        $cafe = Cafe::where('id', '=', $id)
            ->with('brewMethods')
            ->with('userLike')
            ->first();

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
        $addedCafes = array();
        $locations = $request->get('locations');

        /*
         * Create a parent cafe and grab the first location
         */
        $parentCafe = new Cafe();

        $address      = $locations[0]['address'];
        $city         = $locations[0]['city'];
        $state        = $locations[0]['state'];
        $zip          = $locations[0]['zip'];
        $locationName = $locations[0]['name'];
        // $brewMethods  = $locations[0]['methodsAvailable'];
        $tags = $locations[0]['tags'];

        /*
         * Get the Latitude and Longitude returned from the Google Maps Address.
         */
        $coordinates = GoogleMaps::geocodeAddress( $address, $city, $state, $zip );

        $parentCafe->name          = $request->get('name');
        $parentCafe->location_name = $locationName != '' ? $locationName : '';
        $parentCafe->address       = $address;
        $parentCafe->city          = $city;
        $parentCafe->state         = $state;
        $parentCafe->zip           = $zip;
        $parentCafe->latitude      = $coordinates['lat'];
        $parentCafe->longitude     = $coordinates['lng'];
        $parentCafe->roaster       = $request->get('roaster') != '' ? 1 : 0;
        $parentCafe->website       = 'www2.placeholder.com';
        $parentCafe->description   = $request->get('description') != '' ? $request->get('description') : '';
        $parentCafe->added_by      = Auth::user()->id;

        /*
         * Save parent cafe
         */
        $parentCafe->save();

        /*
         * Attach the brew methods
         */
        // $parentCafe->brewMethods()->sync($brewMethods);

        /*
         * Tags the cafe
         */
        Tagger::tagCafe($parentCafe, $tags);

        array_push($addedCafes, $parentCafe->toArray());

        /*
         * Now that we have the parent cafe, we add all of the other
         * locations. We have to see if other locations are added.
         */
        if (count($locations) > 1) {

            /*
             * We off set the counter at 1 since we already used the
             * first location.
             */
            for($i = 1; $i < count($locations); $i++){

                /*
                 * Create a cafe and grab the location
                 */
                $cafe = new Cafe();

                $address      = $locations[$i]['address'];
                $city         = $locations[$i]['city'];
                $state        = $locations[$i]['state'];
                $zip          = $locations[$i]['zip'];
                $locationName = $locations[$i]['name'];
                $brewMethods  = $locations[$i]['methodsAvailable'];
                $tags         = $locations[$i]['tags'];

                /*
                 * Get the Latitude and Longitude returned from the Google Maps Address.
                 */
                $coordinates = GoogleMaps::geocodeAddress($address, $city, $state, $zip);

                $cafe->parent        = $parentCafe->id;
                $cafe->name          = $request->get('name');
                $cafe->location_name = $locationName != '' ? $locationName : '';
                $cafe->address       = $address;
                $cafe->city          = $city;
                $cafe->state         = $state;
                $cafe->zip           = $zip;
                $cafe->latitude      = $coordinates['lat'];
                $cafe->longitude     = $coordinates['lng'];
                $cafe->roaster       = $request->get('roaster') != '' ? 1 : 0;
                $cafe->website       = $request->get('website');
                $cafe->description   = $request->get('description') != '' ? $request->get('description') : '';
                $cafe->added_by      = Auth::user()->id;

                /*
                 * Save cafe
                 */
                $cafe->save();

                /*
                 * Attach the brew methods
                 */
                $cafe->brewMethods()->sync($brewMethods);

                /*
                 * Tags the cafe
                 */
                Tagger::tagCafe( $cafe, $tags );

                array_push($addedCafes, $cafe->toArray());
            }
        }

        /*
         * Return the added cafes as JSON
         */
        return response()->json($addedCafes, 201);
    }

    /**
     *
     */
    public function postLikeCafe($cafeID)
    {
        $cafe = Cafe::where('id', '=', $cafeID)->first();

        if (!$cafe->likes->contains(Auth::user()->id)) {
            $cafe->likes()->attach(Auth::user()->id, [
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     *
     */
    public function deleteLikeCafe( $cafeID )
    {
        $cafe = Cafe::where('id', '=', $cafeID)->first();
        $cafe->likes()->detach( Auth::user()->id );
        return response(null, 204);
    }

    /*
    |-------------------------------------------------------------------------------
    | Adds Tags To A Cafe
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/cafes/{id}/tags
    | Controller:     API\CafesController@postAddTags
    | Method:         POST
    | Description:    Adds tags to a cafe for a user
    */
    public function postAddTags($cafeID)
    {
        /*
          Grabs the tags array from the request
        */
        $tags = Request::get('tags');

        /*
          Gets the cafe
        */
        $cafe = Cafe::where('id', '=', $cafeID)->first();

        /*
          Tags the cafe
        */
        Tagger::tagCafe( $cafe, $tags );

        /*
          Grabs the cafe with the brew methods, user like and tags
        */
        $cafe = Cafe::where('id', '=', $cafeID)
                    ->with('brewMethods')
                    ->with('userLike')
                    ->with('tags')
                    ->first();

        /*
          Returns the cafe response as JSON.
        */
        return response()->json($cafe, 201);
    }

    /*
    |-------------------------------------------------------------------------------
    | Deletes A Cafe Tag
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/cafes/{id}/tags/{tagID}
    | Method:         DELETE
    | Description:    Deletes a tag from a cafe for a user
    */
    public function deleteCafeTag($cafeID, $tagID)
    {
        DB::statement('DELETE FROM cafes_users_tags WHERE cafe_id = `'.$cafeID.'` AND tag_id = `'.$tagID.'` AND user_id = `'.Auth::user()->id.'`');

        /*
         * Return a proper response code for successful untagging
         */
        return response(null, 204);
    }

}
