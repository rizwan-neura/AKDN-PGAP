<?php

namespace App\Repositories;


use App\Models\Country;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CountryRepository
{
    public function getAll($request)
    {
       $limit = env('PER_PAGE_LIMIT',10);
        
      //  $countries = Country::onlyTrashed()->orderBy('id', 'DESC')->paginate($limit)->setPath('');
        $countries = Country::orderBy('id', 'DESC')->paginate($limit)->setPath('');

        $countries->appends($request->all());

        return $countries;
    }

    public function getById($id)
    {
        return Country::find($id);
    }

    public function create($request)
    {
        //dd($request->country_name);
        $country = new Country();
        $country->country_name = $request->country_name;
       

        DB::transaction(function () use ($country) {
            $country->save();
        });

        return $country;
    }

    public function update($id, $request)
    {
        $country = $this->getById($id);
        $country->country_name = $request->country_name;

        DB::transaction(function () use ($country) {
            $country->save();
        });

        return $country;
    }

    public function delete($id)
    {
        $country = $this->getById($id);

        //$country->checkRelation('states');

        DB::transaction(function () use ($country) {
            $country->delete();
            //$country->forceDelete();
        });

        return $country;
    }

    public function isActive($id, $request)
    {
        $country = $this->getById($id);
        $country->is_active = filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN);

        DB::transaction(function () use ($country) {
            $country->save();
        });

        return $country;
    }
}