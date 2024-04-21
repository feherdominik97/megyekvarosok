<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;

class CityController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCityRequest $request)
    {
        $countyId = $request->input('countyId', false);
        $name = $request->input('name', false);
        if(!$countyId || !$name)
            return [
                'errorMessage' => 'Hibás adatok!'
            ];

        if(!City::query()->insert($request->all()))
            return false;

        return CountyController::getCitiesOfCounty($countyId);
    }

    public function show($id) {
        return City::query()->where(compact('id'))->get()->first();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCityRequest $request, $id)
    {
        $name = $request->input('name', false);
        if(!$name)
            return [
                'errorMessage' => 'Írd be a város nevét!'
            ];

        return City::query()->where('id', $id)->update(compact('name'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return City::query()->where('id', $id)->delete();
    }
}
