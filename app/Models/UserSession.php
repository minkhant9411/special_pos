<?php
// app/Models/UserSession.php
namespace App\Models;


use App\Models\Scopes\NotDeletedScope;
use Illuminate\Database\Eloquent\Model;
class UserSession extends Model
{
    protected static function booted()
    {
        static::addGlobalScope(new NotDeletedScope);
    }
    protected $fillable = [
        'user_id',
        'session_id',
        'ip_address',
        'user_agent',
        'last_activity'
    ];
}
