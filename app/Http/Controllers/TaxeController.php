<?php

// app/Http/Controllers/TaxController.php
namespace App\Http\Controllers;

use App\Models\Taxe;
use App\Models\User;
use App\Models\Account;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TaxeController extends Controller
{
    public function index()
    {
        $currentUser = User::findOrFail(Auth()->id());
       if($currentUser->hasRole('admin')){
           $taxes = Taxe::latest()->when(request()->q, function($taxes) {
               $taxes = $taxes->where('waktu', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('karyawan')){
           $taxes = Taxe::whereHas('users', function (Builder $query) {
               $query->where('user_id', Auth()->id());
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas1')){
            $taxes = Taxe::latest()->when(request()->q, function($taxes) {
               $taxes = $taxes->where('waktu', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas2')){
           $taxes = Taxe::latest()->when(request()->q, function($taxes) {
               $taxes = $taxes->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas3')){
           $taxes = Taxe::latest()->when(request()->q, function($taxes) {
               $taxes = $taxes->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas4')){
           $taxes = Taxe::latest()->when(request()->q, function($taxes) {
               $taxes = $taxes->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas5')){
           $taxes = Taxe::latest()->when(request()->q, function($taxes) {
               $taxes = $taxes->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas6')){
           $taxes = Taxe::latest()->when(request()->q, function($taxes) {
               $taxes = $taxes->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas7')){
           $taxes = Taxe::latest()->when(request()->q, function($taxes) {
               $taxes = $taxes->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas8')){
           $taxes = Taxe::latest()->when(request()->q, function($taxes) {
               $taxes = $taxes->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas9')){
           $taxes = Taxe::latest()->when(request()->q, function($taxes) {
               $taxes = $taxes->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('direktur')){
           $taxes = Taxe::latest()->when(request()->q, function($taxes) {
               $taxes = $taxes->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }
        $taxes = Taxe::paginate(10);
        return view('taxes.index', compact('taxes'));
    }

    public function create()
    {
        $accounts = Account::all();
        return view('taxes.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'rate' => 'required|numeric',
            'account_id' => 'required|string',
            'tax_date' => 'required|date',
        ]);

        Taxe::create($request->all());
        return redirect()->route('taxes.index')->with('success', 'Tax created successfully.');
    }

    public function show($id)
    {
        $tax = Taxe::findOrFail($id);
        return view('taxes.show', compact('tax'));
    }

    public function edit($id)
    {
        $tax = Taxe::findOrFail($id);
        $accounts = Account::all();
        return view('taxes.edit', compact('tax', 'accounts'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'rate' => 'required|numeric',
            'account_id' => 'required|string',
            'tax_date' => 'required|date',
        ]);

        $tax = Taxe::findOrFail($id);
        $tax->update([
            'description' => $request->description,
            'rate' => $request->rate,
            'account_id' => $request->account_id,
            'tax_date' => $request->tax_date,
        ]);
        return redirect()->route('taxes.index')->with('success', 'Tax updated successfully.');
    }

    public function destroy($id)
    {
        $tax = Taxe::findOrFail($id);
        $tax->delete();
        if ($tax) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }

    }
}

