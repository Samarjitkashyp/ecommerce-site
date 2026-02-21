<?php
// app/Models/Address.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'pincode',
        'address_line1',
        'address_line2',
        'landmark',
        'city',
        'state',
        'type',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Accessors
    public function getFullAddressAttribute()
    {
        $address = $this->address_line1;
        if ($this->address_line2) {
            $address .= ', ' . $this->address_line2;
        }
        if ($this->landmark) {
            $address .= ', Near ' . $this->landmark;
        }
        $address .= ', ' . $this->city . ' - ' . $this->pincode;
        return $address;
    }

    public function getFormattedTypeAttribute()
    {
        return ucfirst($this->type);
    }
}