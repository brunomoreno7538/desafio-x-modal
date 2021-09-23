<?php

namespace App\Models;

use App\Models\Address\Address;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartsDemand extends Model
{
    use HasFactory;

    protected $table = 'parts_demands';

    protected $fillable = [
        'user_id',
        'address_id',
        'contact_info_id',
        'part_description',
        'demand_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function contactInfo()
    {
        return $this->belongsTo(ContactInformation::class);
    }
}
