<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Reserva extends Model
{
    use HasFactory;

    use Notifiable;
    protected $table = 'reserva';

    protected $fillable = [
        'solicitante_id',
        'status',
        'color',
        'observacao',


        'data',
        'disciplina_id',
        'tipo_reserva_id',
        'usuario_id',
    ];

    static  $rules =
         [
           // 'start' => 'required|before:end',
           // 'end' => 'required',
        ];


    public function getDifferenceAttribute()
    {
        return Carbon::parse($this->hora_fim)->diffInMinutes($this->hora_inicio);
    }

    public function solicitante()
    {
        return $this->belongsTo(Solicitante::class);
    }

    public function laboratorios(){
        return $this->belongsTo(Laboratorio::class, 'laboratorio_id');
    }
}
