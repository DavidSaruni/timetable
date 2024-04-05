<?php

namespace App\Http\Controllers;

use App\Models\Labtype;
use Illuminate\Http\Request;

class LabtypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labtypes = Labtype::orderBy('type', 'asc')->paginate(10);

        return view('labtypes.index')->with([
            'labtypes' => $labtypes,
        ]);
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
        // validate the request
        $request->validate([
            'type' => 'required|string|max:255|unique:labtypes,type',
        ]);
        
        $labtype = new Labtype();
        $labtype->type = $request->type;
        $labtype->save();

        toastr()->success('Labtype created successfully');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Labtype $labtype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Labtype $labtype)
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
            'labtype_id' => 'required|integer|exists:labtypes,labtype_id',
            'type' => 'required|string|max:255|unique:labtypes,type,'.$request->labtype_id.',labtype_id',
        ]);

        $labtype = Labtype::find($request->labtype_id);
        if(!$labtype) {
            toastr()->error('Labtype not found');
            return redirect()->back();
        }

        $labtype->type = $request->type;
        $labtype->save();

        toastr()->success('Labtype updated successfully');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $labtype = Labtype::find($request->labtype_id);

        $labtype->delete();

        toastr()->success('Labtype deleted successfully');

        return redirect()->back();
    }

    /**
     * Return labtype details as JSON on ajax request
     */
    public function labtypeRow(Request $request)
    {
        $id = $request->id;
        $labtype = Labtype::find($id);
        return response()->json($labtype);
    }
}
