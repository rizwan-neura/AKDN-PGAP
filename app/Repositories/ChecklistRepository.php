<?php

namespace App\Repositories;
use Carbon\Carbon;
use App\Models\Checklist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChecklistRepository
{
    public function getAll($request)
    {
        $limit = env('PER_PAGE_LIMIT',10);
        $checklist = Checklist::orderBy('id', 'DESC')->paginate($limit)->setPath('');
        $checklist->appends($request->all());
        return $checklist;
    }
    /*
    public function getAllChecklists()
    {
        $checklists = Checklist::orderBy('id', 'asc')->get();
        return $checklists;
    }
        */

    public function getById($id)
    {
        //
    }

    public function create($request)
    {
        //dd($request->country_name);
       
    }

    public function update($id, $request)
    {
        //
    }

    public function delete($id)
    {
        //
    }

    public function isActive($id, $request)
    {
        //
    }

    
}