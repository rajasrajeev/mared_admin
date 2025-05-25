<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Menu;

class Submenu extends Model
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
        'menu_id',
    ];

    // Define the relationship to permissions
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    // Define the relationship to the menu
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    // Method to check if there are permissions associated with this submenu
    public function hasPermissions()
    {
        return $this->permissions()->exists();
    }
}
