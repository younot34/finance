<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_id',
        'description',
        'account_id',
        'debit',
        'credit',
        'no_ref',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function journals()
    {
        return $this->belongsTo(Journal::class, 'journal_id');
    }
}
