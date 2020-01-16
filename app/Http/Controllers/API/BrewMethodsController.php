<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BrewMethod;

class BrewMethodsController extends Controller
{
    /**
     * Gets all of the brew methods and the count of cafes
     * that have the brew method.
     *
     * URL: /api/v1/brew-methods
     * METHOD: GET
     */
    public function getBrewMethods() {
        /*
         * Gets all of the brew methods with the count of the cafes.
         */
        $brewMethods = BrewMethod::withCount('cafes')->get();

        /*
         * Returns the brew methods as JSON.
         */
        return response()->json($brewMethods);
    }
}
