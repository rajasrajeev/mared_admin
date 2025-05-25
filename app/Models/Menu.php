<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Submenu;


class Menu extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    // Define the relationship to permissions
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    // Define the relationship to submenus
    public function submenus()
    {
        return $this->hasMany(Submenu::class);
    }

    // Method to check if there are submenus associated with this menu
    public function hasSubmenus()
    {
        return $this->submenus()->exists();
    }

    public function userPermissions($user)
    {
        return $this->permissions()->where('user_id', $user->id)->get();
    }
}
