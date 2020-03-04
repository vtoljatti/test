<?php

namespace App\Http\Controllers;

use App\CasePlanner;
use Illuminate\Http\Request;

class CasePlannerController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $case_planners = CasePlanner::all();
        return view('case_planners.index', compact('case_planners'));
    }

    /**
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {
        $case_planners = new CasePlanner();
        $case_planners->name = $request->name;
        $case_planners->date_time = $request->date;
        $case_planners->description = $request->description;
        $case_planners->save();
    }
}
