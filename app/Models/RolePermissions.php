<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermissions extends Model
{
    use HasFactory;

    protected $table = 'role_permissions'; // Ensure this matches your database table name
    protected $fillable = ['role_id', 'permission_id'];

    // Relationship with Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // Relationship with Permission
    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
