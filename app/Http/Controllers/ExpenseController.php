<?php

// app/Http/Controllers/ExpenseController.php
namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Vendor;
use App\Models\Account;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $currentUser = User::findOrFail(Auth()->id());
       if($currentUser->hasRole('admin')){
           $expense = Expense::latest()->when(request()->q, function($expense) {
               $expense = $expense->where('waktu', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('karyawan')){
           $expense = Expense::whereHas('users', function (Builder $query) {
               $query->where('user_id', Auth()->id());
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas1')){
            $expense = Expense::latest()->when(request()->q, function($expense) {
               $expense = $expense->where('waktu', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas2')){
           $expense = Expense::latest()->when(request()->q, function($expense) {
               $expense = $expense->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas3')){
           $expense = Expense::latest()->when(request()->q, function($expense) {
               $expense = $expense->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas4')){
           $expense = Expense::latest()->when(request()->q, function($expense) {
               $expense = $expense->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas5')){
           $expense = Expense::latest()->when(request()->q, function($expense) {
               $expense = $expense->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas6')){
           $expense = Expense::latest()->when(request()->q, function($expense) {
               $expense = $expense->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas7')){
           $expense = Expense::latest()->when(request()->q, function($expense) {
               $expense = $expense->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas8')){
           $expense = Expense::latest()->when(request()->q, function($expense) {
               $expense = $expense->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas9')){
           $expense = Expense::latest()->when(request()->q, function($expense) {
               $expense = $expense->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('direktur')){
           $expense = Expense::latest()->when(request()->q, function($expense) {
               $expense = $expense->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }
        $expenses = Expense::with('vendor', 'account', 'user')->paginate(10);
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $vendors = Vendor::all();
        $accounts = Account::all();
        return view('expenses.create', compact('vendors', 'accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'vendor_id' => 'required|exists:vendors,id',
            'account_id' => 'required|exists:accounts,id',
        ]);

        Expense::create([
            'description' => $request->description,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'vendor_id' => $request->vendor_id,
            'account_id' => $request->account_id,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('expenses.index')->with('success', 'Expense created successfully.');
    }

    public function show($id)
    {
        $expense = Expense::with('vendor', 'account', 'user')->findOrFail($id);
        return view('expenses.show', compact('expense'));
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $vendors = Vendor::all();
        $accounts = Account::all();
        return view('expenses.edit', compact('expense', 'vendors', 'accounts'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'vendor_id' => 'required|exists:vendors,id',
            'account_id' => 'required|exists:accounts,id',
        ]);
        $expenses = Expense::findOrFail($id);
        $expenses->update([
            'description' => $request->description,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'vendor_id' => $request->vendor_id,
            'account_id' => $request->account_id,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();
        if($expense){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}

