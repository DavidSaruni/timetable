<?php

namespace App\Http\Controllers;

use App\Models\Cohort;
use App\Models\Group;
use Illuminate\Http\Request;

class CohortController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Cohort $cohort)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cohort $cohort)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // validate the request
        $request->validate([
            'cohort_id' => 'required|integer|exists:cohorts,cohort_id',
            'student_count' => 'required|integer|min:0',
            'status' => 'required|string|in:NOTINSESSION,INSESSION',
        ]);

        // update the cohort
        $cohort = Cohort::find($request->cohort_id);
        $cohort->student_count = $request->student_count;
        $cohort->status = $request->status;
        $cohort->save();

        // delete all the groups of the cohort
        $cohort->groups()->delete();

        // check if grouping can be done
        if ($cohort->student_count > $cohort->program()->first()->max_group_size) {
            // get number of students in cohort
            $studentCount = $cohort->student_count;
            $maxGroupSize = $cohort->program()->first()->max_group_size;
            // get number of groups
            $groupCount = ceil($studentCount / $maxGroupSize);
            // get max number of students fair for each group
            $maxGroupSize = ceil($studentCount / $groupCount);
            // create groups
            for ($i = 0; $i < $groupCount; $i++) {
                // The group name is a letter from A to Z
                $groupName = chr(65 + $i);
                $group = new Group();
                $group->cohort_id = $cohort->cohort_id;
                $group->name = $groupName;
                $group->student_count = $maxGroupSize;
                $group->save();
            }
        }
        else {
            // create one group
            $group = new Group();
            $group->cohort_id = $cohort->cohort_id;
            $group->name = 'Default';
            $group->student_count = $cohort->student_count;
            $group->save();
        }

        toastr()->success('Cohort updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cohort $cohort)
    {
        //
    }

    public function cohortRow(Request $request)
    {
        $cohort = Cohort::find($request->id);
        return response()->json($cohort);
    }
}
