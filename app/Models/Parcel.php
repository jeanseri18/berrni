<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'courier_id',
        'description',
        'departure_address',
        'destination_address',
        'departure_date',
        'recipient_name',
        'recipient_phone',
        'price',
        'weight',
        'status',
        'verification_code',
        'payment_status',
    ];

    protected $casts = [
        'departure_date' => 'datetime',
        'price' => 'decimal:2',
        'weight' => 'decimal:2',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function courier()
    {
        return $this->belongsTo(User::class, 'courier_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function sosAlerts()
    {
        return $this->hasMany(SosAlert::class);
    }
    
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
