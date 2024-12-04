<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['updateID', 'type', 'filename'];

    public function updateRecord() // Rename this method to avoid conflict
    {
        return $this->belongsTo(Update::class, 'updateID');
    }
}
