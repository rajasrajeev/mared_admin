<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id');
    }

    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'users');
    // }
    public function users()
    {
        return $this->hasMany(User::class, 'role_id'); // Fix: Use hasMany
    }
}
