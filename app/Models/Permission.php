<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'route', 'menu_id', 'submenu_id'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    // Define the relationship to the submenu
    public function submenu()
    {
        return $this->belongsTo(Submenu::class);
    }
}
