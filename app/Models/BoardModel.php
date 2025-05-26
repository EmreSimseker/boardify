<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardModel extends Model
{
    use HasFactory;

    protected $table = 'borden';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $fillable = [
        'Titel',
        'Slug',
        'GebruikerId',
        'AangemaaktOp',
    ];
    

    //een bord mag meerdere lijsten hebben
    public function lists()
    {
        return $this->hasMany(ListModel::class, 'BordId'); 
    }
}
