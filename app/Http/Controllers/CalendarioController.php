<?php

namespace App\Http\Controllers;

use App\Models\Laboratorio;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;
use Redirect,Response;

class CalendarioController extends Controller
{
    ///*

    public function index(){

        $laboratorios = Laboratorio::All();

        $dataHoje = date('d/m/Y');

        return view('reserva.calendario', ['laboratorios' => $laboratorios, 'dataHoje'=>$dataHoje]);

    }


    public function show(Request $reserva){

        $events = DB::select('SELECT reserva.*, solicitantes.nome as description, disciplinas.nome as title, laboratorio.nome as groupID from reserva join solicitantes on solicitantes.id =reserva.solicitante_id join disciplinas on disciplinas.id = reserva.disciplina_id join laboratorio on laboratorio.id = reserva.laboratorio_id');
        return response()->json($events);

    }

    public function loadEvents(){

        //$events = DB::select('SELECT `id`, `hora_inicio`, `hora_fim` FROM `reserva`');

       // return response()->json($events);
    }

    public function buscaReservasLab(Request $request){

        $idlab = $request->laboratorio_id;

        $events = DB::select('SELECT reserva.*, solicitantes.nome as `description`, disciplinas.nome as title, laboratorio.nome as laboratorio from reserva join solicitantes on solicitantes.id =reserva.solicitante_id join disciplinas on disciplinas.id = reserva.disciplina_id join laboratorios laboratorios.id = reserva.laboratorio_id where laboratorio_id = ?', [$idlab]);

        return response()->json($events);

    }
}
