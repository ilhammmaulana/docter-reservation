<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDO;

class SavedDocter extends Model
{
    use HasFactory;
    protected $fillable = ['docter_id', 'created_by'];


    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function docter()
    {
        return $this->belongsTo(Docter::class, 'docter_Id');
    }
}
