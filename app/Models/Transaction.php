<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'user_id',
        'total_amount',
        'payment_amount',
        'change',
        'payment_method',
        'notes',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (empty($transaction->invoice_number)) {
                $date = now()->format('Ymd');
                $lastTransaction = Transaction::whereDate('created_at', today())
                    ->latest()
                    ->first();
                
                if ($lastTransaction) {
                    $lastNumber = (int) substr($lastTransaction->invoice_number, -5);
                    $nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
                } else {
                    $nextNumber = '00001';
                }
                
                $transaction->invoice_number = 'INV-' . $date . '-' . $nextNumber;
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}