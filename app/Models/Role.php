<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  use HasFactory;

  public $timestamps = false;
  protected $table = 'roles';

  protected $fillable = [
    'description'
  ];

  public function users()
  {
    return $this->belongsToMany(User::class, 'users_roles', 'role_id', 'user_id');
  }
}
