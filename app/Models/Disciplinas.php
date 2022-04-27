<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Disciplinas extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'disciplinas';

    protected $fillable = ['nome', 'turno'];

    static  $rules = [

        'nome' => 'required| min:5| regex:/^[A-Za-z]/',
        'turno' => 'required',

  ];
}

