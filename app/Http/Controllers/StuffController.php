<?php

namespace App\Http\Controllers;

use App\Models\Stuff;
use Illuminate\Http\Request;

class StuffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stuff = Stuff::when(request()->search, function ($query) {
            $query->where('name', 'like', '%' . request()->search . '%');
        })->get();
        return inertia('Stuff/Index', [
            'all_stuff' => $stuff,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Stuff/Create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        Stuff::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => auth()->user()->id,
        ]);
        return redirect()->route('stuff.index')->with('message', 'Stuff created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Stuff $stuff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stuff $stuff)
    {
        return inertia('Stuff/Edit', [
            'stuff' => $stuff,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stuff $stuff)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $stuff->update([
            'name' => $request->name,
            'description' => $request->description,
            'updated_by' => auth()->user()->id,
        ]);
        return redirect()->route('stuff.index')->with('message', 'Stuff updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stuff $stuff, $id)
    {

        $stuff = Stuff::find($id);
        $stuff->is_deleted = true;
        $stuff->save();
        return redirect()->route('stuff.index')->with('message', 'Stuffစ deleted successfully.');
    }
}
