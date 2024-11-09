<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'account_number',
        'subKlasifikasi',
        'klasifikasi',
    ];

    public function journal_entries()
    {
        return $this->hasMany(JournalEntry::class);
    }
    public function journals()
    {
        return $this->hasMany(Journal::class);
    }
    public function expenses()
    {
        return $this->hasManys(Expense::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function budget_plans()
    {
        return $this->hasMany(BudgetPlan::class);
    }
    public function taxes()
    {
        return $this->hasMany(Taxe::class);
    }
}
