<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::when(request()->search, function ($query) {
            $query->where('name', 'like', '%' . request()->search . '%');
        })->get();
        return inertia('Customer/Index', [
            'customers' => $customers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Customer/Create');
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

        Customer::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => auth()->user()->id,
        ]);
        return redirect()->route('customer.index')->with('message', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return inertia('Customer/Edit', [
            'customer' => $customer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $customer->update([
            'name' => $request->name,
            'description' => $request->description,
            'updated_by' => auth()->user()->id,
        ]);
        return redirect()->route('customer.index')->with('message', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer, $id)
    {
        $customer = Customer::find($id);
        $customer->is_deleted = true;
        $customer->save();
        return redirect()->route('customer.index')->with('message', 'Customer deleted successfully.');
    }
}
