<?php

// app/Http/Controllers/TransactionController.php
namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class TransactionController extends Controller
{
    public function index()
    {
        $currentUser = User::findOrFail(Auth()->id());
       if($currentUser->hasRole('admin')){
           $transactions = Transaction::latest()->when(request()->q, function($transactions) {
               $transactions = $transactions->where('waktu', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('karyawan')){
           $transactions = Transaction::whereHas('users', function (Builder $query) {
               $query->where('user_id', Auth()->id());
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas1')){
            $transactions = Transaction::latest()->when(request()->q, function($transactions) {
               $transactions = $transactions->where('waktu', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas2')){
           $transactions = Transaction::latest()->when(request()->q, function($transactions) {
               $transactions = $transactions->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas3')){
           $transactions = Transaction::latest()->when(request()->q, function($transactions) {
               $transactions = $transactions->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas4')){
           $transactions = Transaction::latest()->when(request()->q, function($transactions) {
               $transactions = $transactions->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas5')){
           $transactions = Transaction::latest()->when(request()->q, function($transactions) {
               $transactions = $transactions->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas6')){
           $transactions = Transaction::latest()->when(request()->q, function($transactions) {
               $transactions = $transactions->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas7')){
           $transactions = Transaction::latest()->when(request()->q, function($transactions) {
               $transactions = $transactions->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas8')){
           $transactions = Transaction::latest()->when(request()->q, function($transactions) {
               $transactions = $transactions->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas9')){
           $transactions = Transaction::latest()->when(request()->q, function($transactions) {
               $transactions = $transactions->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('direktur')){
           $transactions = Transaction::latest()->when(request()->q, function($transactions) {
               $transactions = $transactions->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }
        $transactions = Transaction::with('account')->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $accounts = Account::all();
        return view('transactions.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'account_id' => 'required|exists:accounts,id',
        ]);

        Transaction::create([
            'transaction_date' => $request->transaction_date,
            'description' => $request->description,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'account_id' => $request->account_id,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $accounts = Account::all();
        return view('transactions.edit', compact('transaction', 'accounts'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'account_id' => 'required|exists:accounts,id',
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->update([
            'transaction_date' => $request->transaction_date,
            'description' => $request->description,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'account_id' => $request->account_id,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction uodated successfully.');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        if($transaction){
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

