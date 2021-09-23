<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInformation extends Model
{
    use HasFactory;

    protected $table = 'users_contact_informations';

    protected $fillable = [
        'user_id',
        'cellphone_number',
        'phone_number',
        'extra_email'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function demands()
    {
        return $this->hasMany(PartsDemand::class);
    }
}
