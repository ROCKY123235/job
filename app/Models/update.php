<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Update extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'user_id'];

    public function media()
    {
        return $this->hasMany(Media::class, 'updateID');
    }
    public function user()
    {
        return $this->belongsTo(User::class); 
    }
}

    
