<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Http\Requests\CountryRequest;
use App\Repositories\CountryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Exception;

class CountryController extends Controller
{
    protected $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
        //$this->middleware('signed')->only(['edit']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //dd('asfaassdfasdf');
        $data = $this->countryRepository->getAll($request);
        return view('countries.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('countries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CountryRequest $request)
    {
       
       // dd($request->country_name);
       
       $this->countryRepository->create($request);

        return redirect()->to(route('countries.index'))->with(['message' => 'Country has been added successfully.']);
       
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
       // dd($id);
        $countryData =  $this->countryRepository->getById($id);
        //dd($countryData->country_name);
        return view('countries.edit', compact('countryData'));



    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, CountryRequest $request)
    {
        //dd($id);
        $this->countryRepository->update($id, $request);
        return redirect()->to(route('countries.index'))->with(['message' => 'Country has been updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       
        try {
            $this->countryRepository->delete($id);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 422);
        }
       
    }
}
