<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Laboratorio extends Model
{
    use HasFactory;

    use Notifiable;

    protected $table = 'laboratorio';

    protected $fillable = ['nome', 'restrito', 'apelido'];

    static  $rules = [

          'nome' => 'required| max:100, min:3',
          'apelido' => 'required',
          'restrito' => 'required|integer|in:0,1'
    ];
}
