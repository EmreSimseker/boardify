<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListModel extends Model
{
    use HasFactory;

    protected $table = 'lijsten';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $fillable = [
        'BordId',       
        'Titel',        
        'AangemaaktOp', 
    ];

    public function board()
    {
        return $this->belongsTo(BoardModel::class, 'BordId'); 
    }

    //lijst mag meerdere tken hebben
    public function tasks()
    {
        return $this->hasMany(TaskModel::class, 'LijstId'); 
    }
}
