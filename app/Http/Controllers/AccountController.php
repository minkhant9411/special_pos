<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Stuff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->date ? $date = Carbon::parse($request->date) : $date = Carbon::today('Asia/Yangon');


        $stuff = Stuff::get();
        $type = "I";

        if ($request->is_income) {
            $request->is_income == 'true' ? $type = "I" : $type = 'E';
        }
        $accounts = Account::where(function ($query) use ($type) {
            $query->where('type', $type);
        })
            ->when($request->search, function ($query) use ($request) {
                $query->where('stuff_id', '=', $request->search);
            })
            ->where(function ($query) use ($date) {
                // dd($date->year, $date->month);
                $query->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month);
            })
            ->with('stuff');
        $totalAmount = $accounts->sum('amount');
        $accounts = $accounts
            ->paginate(20)->withQueryString();


        // dd($grand_total);
        return Inertia('Account/Index', [
            'accounts' => inertia()->merge(fn() => $accounts->items()),
            'accountPagination' => $accounts->toArray(),
            'totalAmount' => $totalAmount,
            'Stuff' => $stuff,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stuff = Stuff::get();
        return Inertia('Account/Create', [
            'stuff' => $stuff,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'description' => 'nullable|string|max:255',
            'type' => 'required|in:I,E',
            'amount' => 'required|numeric|min:0',
            'stuff_id' => 'required|exists:stuffs,id',
        ]);

        $account = Account::create([
            'description' => $validate['description'],
            'type' => $validate['type'],
            'amount' => $validate['amount'],
            'stuff_id' => $validate['stuff_id'],
            'created_by' => auth()->user()->id,
        ]);
        return redirect()->route('account.index', ['is_income' => $account->type == 'I' ? 'true' : 'false'])->with('message', 'Account created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $account = Account::find($id);
        $stuff = Stuff::where('is_deleted', '=', false)->get();
        return Inertia::render('Account/Edit', [
            'stuff' => $stuff,
            'account' => $account
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Account $account)
    {
        $validate = $request->validate([
            'description' => 'nullable|string|max:255',
            'type' => 'required|in:I,E',
            'amount' => 'required|numeric|min:0',
            'stuff_id' => 'required|exists:stuffs,id',
        ]);
        $account->fill($validate);
        if ($account->isClean()) {
            return redirect()->route('account.index')->with('message', 'Nothing has been changed.');
        }
        $account = $account->update([
            'description' => $validate['description'],
            'type' => $validate['type'],
            'amount' => $validate['amount'],
            'stuff_id' => $validate['stuff_id'],
            'created_by' => auth()->user()->id,
        ]);
        return redirect()->route('account.index')->with('message', 'Account updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account, $id)
    {
        $account = Account::find($id);
        $account->is_deleted = true;
        $account->save();
        return redirect()->route('account.index')->with('message', 'Account deleted successfully.');

    }
}
