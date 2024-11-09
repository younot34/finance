<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_date',
        'amount',
        'description',
        'vendor_id',
        'account_id',
        'created_by',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
