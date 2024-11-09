<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxe extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'rate',
        'account_id',
        'tax_date',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
