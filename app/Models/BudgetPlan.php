<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'amount',
        'start_date',
        'end_date',
        'description',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
