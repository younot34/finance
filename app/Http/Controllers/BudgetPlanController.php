<?php

// app/Http/Controllers/BudgetPlanController.php
namespace App\Http\Controllers;

use App\Models\BudgetPlan;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class BudgetPlanController extends Controller
{
    public function index()
    {
        $currentUser = User::findOrFail(Auth()->id());
       if($currentUser->hasRole('admin')){
           $budgetPlans = BudgetPlan::latest()->when(request()->q, function($budgetPlans) {
               $budgetPlans = $budgetPlans->where('waktu', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('karyawan')){
           $budgetPlans = BudgetPlan::whereHas('users', function (Builder $query) {
               $query->where('user_id', Auth()->id());
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas1')){
            $budgetPlans = BudgetPlan::latest()->when(request()->q, function($budgetPlans) {
               $budgetPlans = $budgetPlans->where('waktu', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas2')){
           $budgetPlans = BudgetPlan::latest()->when(request()->q, function($budgetPlans) {
               $budgetPlans = $budgetPlans->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas3')){
           $budgetPlans = BudgetPlan::latest()->when(request()->q, function($budgetPlans) {
               $budgetPlans = $budgetPlans->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas4')){
           $budgetPlans = BudgetPlan::latest()->when(request()->q, function($budgetPlans) {
               $budgetPlans = $budgetPlans->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas5')){
           $budgetPlans = BudgetPlan::latest()->when(request()->q, function($budgetPlans) {
               $budgetPlans = $budgetPlans->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas6')){
           $budgetPlans = BudgetPlan::latest()->when(request()->q, function($budgetPlans) {
               $budgetPlans = $budgetPlans->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas7')){
           $budgetPlans = BudgetPlan::latest()->when(request()->q, function($budgetPlans) {
               $budgetPlans = $budgetPlans->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas8')){
           $budgetPlans = BudgetPlan::latest()->when(request()->q, function($budgetPlans) {
               $budgetPlans = $budgetPlans->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('petugas9')){
           $budgetPlans = BudgetPlan::latest()->when(request()->q, function($budgetPlans) {
               $budgetPlans = $budgetPlans->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }elseif($currentUser->hasRole('direktur')){
           $budgetPlans = BudgetPlan::latest()->when(request()->q, function($budgetPlans) {
               $budgetPlans = $budgetPlans->where('transaction_date', 'like', '%'. request()->q . '%');
           })->paginate(10);
       }
        $budgetPlans = BudgetPlan::with('account')->paginate(10);
        return view('budget-plans.index', compact('budgetPlans'));
    }

    public function create()
    {
        $accounts = Account::all();
        return view('budget-plans.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        BudgetPlan::create($request->all());
        return redirect()->route('budget-plans.index')->with('success', 'Budget Plan created successfully.');
    }

    public function show($id)
    {
        $budgetPlan = BudgetPlan::with('account')->findOrFail($id);
        return view('budget-plans.show', compact('budgetPlan'));
    }

    public function edit($id)
    {
        $budgetPlan = BudgetPlan::findOrFail($id);
        $accounts = Account::all();
        return view('budget-plans.edit', compact('budgetPlan', 'accounts'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        $budgetPlan = BudgetPlan::findOrFail($id);
        $budgetPlan->update($request->all());
        return redirect()->route('budget-plans.index')->with('success', 'Budget Plan updated successfully.');
    }

    public function destroy($id)
    {
        $budgetPlan = BudgetPlan::findOrFail($id);
        $budgetPlan->delete();
        if ($budgetPlan) {
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

