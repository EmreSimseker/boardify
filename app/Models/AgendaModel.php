<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; 

class AgendaModel extends Model
{
    use HasFactory;

    protected $table = 'agenda'; 

    protected $fillable = [
        'GebruikerId',
        'Titel',
        'Omschrijving',
        'Datum',
        'Type',
    ];

    public $timestamps = false; 

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'GebruikerId', 'Id');
    }
}
