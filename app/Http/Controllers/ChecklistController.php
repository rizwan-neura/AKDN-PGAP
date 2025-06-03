<?php

namespace App\Http\Controllers;
use App\Models\Checklist;
use App\Http\Requests\ChecklistRequest;
use App\Repositories\ChecklistRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Exception;

class ChecklistController extends Controller
{
    protected $checklistRepository;

    public function __construct(ChecklistRepository $checklistRepository)
    {
        $this->checklistRepository = $checklistRepository;
        //$this->middleware('signed')->only(['edit']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //dd('asdfasdfas');
        $data = $this->checklistRepository->getAll($request);
        dd($data);
        //return view('countries.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Checklist $checklist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checklist $checklist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Checklist $checklist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Checklist $checklist)
    {
        //
    }
}
