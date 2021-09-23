<?php

namespace App\Models\Address;

use App\Models\PartsDemand;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'users_addresses';

    protected $fillable = [
        'user_id',
        'address_line_1',
        'address_line_2',
        'postal_code',
        'city',
        'state_id',
        'active'
    ];

    public static $snakeAttributes = false;

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function demands()
    {
        return $this->hasMany(PartsDemand::class);
    }
}
