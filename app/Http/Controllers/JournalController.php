<?php

// app/Http/Controllers/JournalController.php
namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\JournalEntry;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class JournalController extends Controller
{
    public function index()
    {
        $currentUser = User::findOrFail(Auth()->id());
       if($currentUser->hasRole('admin')){
           $journals = Journal::latest()->when(request()->q, function($journals) {
               $journals = $journals->where('waktu', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('karyawan')){
           $journals = Journal::whereHas('users', function (Builder $query) {
               $query->where('user_id', Auth()->id());
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas1')){
            $journals = Journal::latest()->when(request()->q, function($journals) {
               $journals = $journals->where('waktu', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas2')){
           $journals = Journal::latest()->when(request()->q, function($journals) {
               $journals = $journals->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas3')){
           $journals = Journal::latest()->when(request()->q, function($journals) {
               $journals = $journals->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas4')){
           $journals = Journal::latest()->when(request()->q, function($journals) {
               $journals = $journals->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas5')){
           $journals = Journal::latest()->when(request()->q, function($journals) {
               $journals = $journals->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas6')){
           $journals = Journal::latest()->when(request()->q, function($journals) {
               $journals = $journals->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas7')){
           $journals = Journal::latest()->when(request()->q, function($journals) {
               $journals = $journals->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas8')){
           $journals = Journal::latest()->when(request()->q, function($journals) {
               $journals = $journals->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas9')){
           $journals = Journal::latest()->when(request()->q, function($journals) {
               $journals = $journals->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('direktur')){
           $journals = Journal::latest()->when(request()->q, function($journals) {
               $journals = $journals->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }
        $journals = Journal::with('journal_entries')->paginate(10);
        $user = new User();
        return view('journals.index', compact('journals', 'user'));
    }

    public function create()
    {
        $accounts = Account::all();
        return view('journals.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'description' => 'array',
            'account_id' => 'array',
            'debit' => 'array',
            'credit' => 'array',
            'no_ref' => 'array',
        ]);

        try {
            $journals = Journal::create([
                'transaction_date' => $request->transaction_date,
            ]);

            foreach ($request->description as $index => $description){
                $data = [
                    'journal_id' => $journals->id,
                    'description' => $description,
                    'debit' => $request->debit[$index],
                    'credit' => $request->credit[$index],
                    'account_id' => $request->account_id[$index],
                    'no_ref' => $request->no_ref[$index],
                ];
                JournalEntry::create($data);
            }
            return redirect()->route('journals.index')->with(['success', 'Journal created successfully.']);
        }catch (\Exception $e){
            return redirect()->route('journals.index')->with('error', 'Failed to create journal entry: ' . $e->getMessage());
        }

    }

    // public function show($id)
    // {
    //     $journal = Journal::with('journal_entries')->findOrFail($id);
    //     return view('journals.show', compact('journal'));
    // }

    public function edit($id)
    {
        $journal = Journal::with('journal_entries')->findOrFail($id);
        $accounts = Account::all();
        return view('journals.edit', compact('journal', 'accounts'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'description' => 'array|nullable',
            'account_id' => 'array|nullable',
            'debit' => 'array|nullable',
            'credit' => 'array|nullable',
            'no_ref' => 'required|string',
        ]);

        try {
            $journal = Journal::findOrFail($id);
            $journal->update([
                'transaction_date' => $request->transaction_date,
            ]);

            $journal->journal_entries()->delete();

            foreach ($request->description as $index => $description){
                $data = [
                    'journal_id' => $journal->id,
                    'description' => $description,
                    'debit' => $request->debit[$index],
                    'credit' => $request->credit[$index],
                    'account_id' => $request->account_id[$index],
                    'no_ref' => $request->no_ref[$index],
                ];
                JournalEntry::create($data);
            }
            return redirect()->route('journals.index')->with(['success', 'Journal updated successfully.']);
        }catch (\Exception $e){
            return redirect()->route('journals.index')->with(['success', 'Journal updated successfully.']);
        }
    }

    public function destroy($id)
    {
        $journal = Journal::findOrFail($id);
        $journal->delete();

        if($journal){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }

    public function checkNoRef(Request $request)
    {
        $noRef = $request->input('no_ref');
        $exists = JournalEntry::where('no_ref', $noRef)->exists();
        return response()->json(['exists' => $exists]);
    }
}

