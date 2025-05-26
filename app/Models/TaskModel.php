<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskModel extends Model
{
    use HasFactory;

    protected $table = 'taken';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $fillable = [
        'LijstId',     
        'Titel',        
        'Omschrijving', 
        'Status',       
        'AangemaaktOp', 
    ];

    //een taak hoort bij een lijst
    public function list()
    {
        return $this->belongsTo(ListModel::class, 'LijstId'); 
    }
}
