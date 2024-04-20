<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\County;
use App\Http\Requests\StoreCountyRequest;
use App\Http\Requests\UpdateCountyRequest;

class CountyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return County::all()->toArray();
    }

    public function getCitiesOfCounty($id) {
        return City::query()->where('countyId', $id)->get()->toArray();
    }
}
