<?php

// app/Http/Controllers/AccountController.php
namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::all();
        return view('accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'required|string',
            'subKlasifikasi' => 'required|string',
            'klasifikasi' => 'required|string',

        ]);

        Account::create($request->all());
        return redirect()->route('accounts.index')->with('success', 'Account created successfully.');
    }

    public function show($id)
    {
        $account = Account::findOrFail($id);
        return view('accounts.show', compact('account'));
    }

    public function edit($id)
    {
        $account = Account::findOrFail($id);
        return view('accounts.edit', compact('account'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'required|string',
            'subKlasifikasi' => 'required|string',
            'klasifikasi' => 'required|string',
        ]);

        $account = Account::findOrFail($id);
        $account->update($request->all());
        return redirect()->route('accounts.index')->with('success', 'Account updated successfully.');
    }

    public function destroy($id)
    {
        $account = Account::findOrFail($id);
        $account->delete();

        if($account){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->jason([
                'status' => 'error'
            ]);
        }
    }
}

