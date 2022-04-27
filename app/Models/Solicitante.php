<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Solicitante extends Model
{
    use HasFactory;

    use Notifiable;

    protected $fillable = [
        'nome', 'email', 'tipo_solicitante_id'
    ];
    protected $table = 'solicitantes';

    static  $rules = [

        'nome' => 'required| min:5| regex:/^[A-Za-z]/',


  ];
}
