<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $table = 'groups';
    
    protected $fillable = [
        'name',
        'privacy',
        'admin_id',
        'image',
        'description',
        'members_count'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function admin(){
        return $this->belongsTo(User::class);        
    }
}
