<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Entry extends Model
{
    protected $fillable = [
        'date',
        'description',
        'compte_debit',
        'compte_credit',
        'montant',
        'journal',
    ];

    // Define the relationships with debit and credit accounts
    public function debitAccount()
    {
        return $this->belongsTo(Account::class, 'compte_debit');
    }

    public function creditAccount()
    {
        return $this->belongsTo(Account::class, 'compte_credit');
    }
}
