<?php

namespace App\Http\Controllers;


use App\Models\Disciplinas;
use App\Models\Laboratorio;
use App\Models\Reserva;
use App\Models\Solicitante;
use App\Models\TipoReserva;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use phpDocumentor\Reflection\PseudoTypes\False_;

class ReservaController extends Controller
{
    //
    public function index(Reserva $model){

        $reservas = new Reserva();

        $date = date('Y');

        return view('reserva.index', ['reservas' => $reservas->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio','tipo_reserva.tipo_reserva as tipo', 'disciplinas.nome as disciplinaNome')
        ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
        ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
        ->join('users', 'users.id', '=', 'reserva.usuario_id')
        ->join('disciplinas', 'disciplinas.id','=','disciplina_id')
        ->join('tipo_reserva', 'tipo_reserva.id', '=', 'tipo_reserva_id')
        ->where('data','>',$date)->get()]);

    }


    public function create()
    {
        $dadosErro = array();
        $dadosReserva = array();
        $dadosReserva2 = array();
        $solicitantes_professores = DB::select('select * from solicitantes where tipo_solicitante_id = 1');
        $solicitantes_externo = DB::select('select * from solicitantes where tipo_solicitante_id = 4');
        $solicitantes_academicos = DB::select('select * from solicitantes where tipo_solicitante_id = 2');
        $laboratorios = DB::select('select * from laboratorio where restrito = 0 ');
        $disciplinas = DB::select('select *from disciplinas where id > 2');
        $tipo_reserva = DB::select('select * from tipo_reserva where id = 1 or id = 2');

        return view('reserva.create', ['dadosErro' =>$dadosErro,'dadosReserva' =>$dadosReserva,'dadosReserva2' =>$dadosReserva2,'solicitantes_professores'=> $solicitantes_professores,'solicitantes_externos' => $solicitantes_externo,'solicitantes_academicos'=>$solicitantes_academicos, 'tipo_reserva' =>$tipo_reserva , 'disciplinas' =>$disciplinas, 'laboratorios'=>$laboratorios]);
    }

    public function store(Request $request, Reserva $reserva){


        //$termino = Carbon::createFromFormat('d/m/Y H:i', $request->hora_fim)->format('Y-m-d H:i');

        //echo date($data);

        $disciplina = $request->disciplinas_id;

        request()->validate(Reserva::$rules);
        $tipo_reserva_disciplina = 1;
        $tipo_reserva_externo = 2;
        $tipo_reserva_academico = 3;
        $dadosErro = 0;

        if($request->tipo_reserva == $tipo_reserva_disciplina){

            $data = Carbon::createFromFormat('d/m/Y H:i', $request->hora_inicio)->format('Y-m-d');

            $inicio = Carbon::createFromFormat('d/m/Y H:i', $request->hora_inicio)->format('Y-m-d H:i');

            $cor_reserva = "#2757c6";
            $turnos = DB::table('disciplinas')->select('disciplinas.turno')->where('disciplinas.id', '=', $request->disciplinas_id)->first();

                $turnoManha = "M";
                $turnoTarde = "T";
                $turnoNoite = "N";

            if($request->opcaoReserva == 1){ //uma vez


                $terminoAula =  date('Y-m-d H:i', strtotime('+' . 50*($request->QtdAulas) . 'minutes', strtotime($inicio)));
                $terminoAulaN =  date('Y-m-d H:i', strtotime('+' . 55*($request->QtdAulas) . 'minutes', strtotime($inicio)));

                foreach($turnos as $turno){

                if(strstr($turnoManha, $turno) !== False){

                    $dadosReserva = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                    ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                    ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                    ->join('users', 'users.id', '=', 'reserva.usuario_id')
                    ->where('start','<=',$inicio)
                    ->where('end','>=', $terminoAula)
                    ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                    ->orderBy('start', 'asc')
                    ->get();



                    $dadosReserva2 = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                    ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                    ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                    ->join('users', 'users.id', '=', 'reserva.usuario_id')
                    ->whereBetween('start', [$inicio, $terminoAula])
                    ->orwhereBetween('end', [$inicio, $terminoAula])
                    ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                    ->orderBy('start', 'desc')
                    ->get();

                    //return response()->json($dadosReserva2);

                        if ($dadosReserva == '[]' && $dadosReserva2 == '[]') {
                            $reserva = new Reserva();
                            $reserva->laboratorio_id = $request->laboratorio_id;
                            $reserva->usuario_id = $request->usuario_id;
                            $reserva->data = $data;
                            $reserva->start = $inicio;
                            $reserva->end = $terminoAula;
                            $reserva->solicitante_id = $request->solicitante_id_professor;
                            $reserva->observacao = $request->observacao;
                            $reserva->tipo_reserva_id = $request->tipo_reserva;
                            $reserva->disciplina_id = $request->disciplinas_id;
                            $reserva->color = $cor_reserva;
                            $reserva->save();

                            $idReserva = $reserva->id;


                        }else
                        {
                            $dadosErro = $dadosErro + 1;
                            $solicitantes_professores = DB::select('select * from solicitantes where tipo_solicitante_id = 1');
                            $solicitantes_externos = DB::select('select * from solicitantes where tipo_solicitante_id = 4');
                            $laboratorios = DB::select('select * from laboratorio where restrito = 0 ');
                            $disciplinas = DB::select('select *from disciplinas where id > 2');
                            $tipo_reserva = DB::select('select * from tipo_reserva where id = 1 or id = 2');
                            $solicitantes_academicos = DB::select('select * from solicitantes where tipo_solicitante_id = 2');


                            //return response()->json($dadosErro);
                            return view('reserva.create',['solicitantes_academicos'=>$solicitantes_academicos,'dadosReserva'=> $dadosReserva,'dadosReserva2'=> $dadosReserva2,'dadosErro'=>$dadosErro, 'laboratorios' => $laboratorios, 'disciplinas' => $disciplinas, 'solicitantes_professores'=>$solicitantes_professores, 'solicitantes_externos'=>$solicitantes_externos]);
                        }
                        return redirect()->route('reservas.index')->with('success', 'Reserva criada com sucesso.');






                }elseif(strstr($turnoTarde, $turno) !== False){

                    $dadosReserva = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                    ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                    ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                    ->join('users', 'users.id', '=', 'reserva.usuario_id')
                    ->where('start','<=',$inicio)
                    ->where('end','>=', $terminoAula)
                    ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                    ->orderBy('start', 'asc')
                    ->get();



                    $dadosReserva2 = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                    ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                    ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                    ->join('users', 'users.id', '=', 'reserva.usuario_id')
                    ->whereBetween('start', [$inicio, $terminoAula])
                    ->orwhereBetween('end', [$inicio, $terminoAula])
                    ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                    ->orderBy('start', 'desc')
                    ->get();

                    //return response()->json($dadosReserva2);

                        if ($dadosReserva == '[]' && $dadosReserva2 == '[]') {
                            $reserva = new Reserva();
                            $reserva->laboratorio_id = $request->laboratorio_id;
                            $reserva->usuario_id = $request->usuario_id;
                            $reserva->data = $data;
                            $reserva->start = $inicio;
                            $reserva->end = $terminoAulaN;
                            $reserva->solicitante_id = $request->solicitante_id_professor;
                            $reserva->observacao = $request->observacao;
                            $reserva->tipo_reserva_id = $request->tipo_reserva;
                            $reserva->disciplina_id = $request->disciplinas_id;
                            $reserva->color = $cor_reserva;
                            $reserva->save();

                            $idReserva = $reserva->id;


                        }else
                        {
                            $dadosErro = $dadosErro + 1;
                            $solicitantes_professores = DB::select('select * from solicitantes where tipo_solicitante_id = 1');
                            $solicitantes_externos = DB::select('select * from solicitantes where tipo_solicitante_id = 4');
                            $laboratorios = DB::select('select * from laboratorio where restrito = 0 ');
                            $disciplinas = DB::select('select *from disciplinas where id > 2');
                            $tipo_reserva = DB::select('select * from tipo_reserva where id = 1 or id = 2');
                            $solicitantes_academicos = DB::select('select * from solicitantes where tipo_solicitante_id = 2');


                            //return response()->json($dadosErro);
                            return view('reserva.create',['solicitantes_academicos'=>$solicitantes_academicos,'dadosReserva'=> $dadosReserva,'dadosReserva2'=> $dadosReserva2,'dadosErro'=>$dadosErro, 'laboratorios' => $laboratorios, 'disciplinas' => $disciplinas, 'solicitantes_professores'=>$solicitantes_professores, 'solicitantes_externos'=>$solicitantes_externos]);
                        }
                        return redirect()->route('reservas.index')->with('success', 'Reserva criada com sucesso.');

                }

                elseif(strstr($turnoNoite, $turno) !== False){
                    $dadosReserva = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                    ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                    ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                    ->join('users', 'users.id', '=', 'reserva.usuario_id')
                    ->where('start','<=',$inicio)
                    ->where('end','>=', $terminoAula)
                    ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                    ->orderBy('start', 'asc')
                    ->get();



                    $dadosReserva2 = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                    ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                    ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                    ->join('users', 'users.id', '=', 'reserva.usuario_id')
                    ->whereBetween('start', [$inicio, $terminoAula])
                    ->orwhereBetween('end', [$inicio, $terminoAula])
                    ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                    ->orderBy('start', 'desc')
                    ->get();

                    //return response()->json($dadosReserva2);

                        if ($dadosReserva == '[]' && $dadosReserva2 == '[]') {
                            $reserva = new Reserva();
                            $reserva->laboratorio_id = $request->laboratorio_id;
                            $reserva->usuario_id = $request->usuario_id;
                            $reserva->data = $data;
                            $reserva->start = $inicio;
                            $reserva->end = $terminoAulaN;
                            $reserva->solicitante_id = $request->solicitante_id_professor;
                            $reserva->observacao = $request->observacao;
                            $reserva->tipo_reserva_id = $request->tipo_reserva;
                            $reserva->disciplina_id = $request->disciplinas_id;
                            $reserva->color = $cor_reserva;
                            $reserva->save();

                            $idReserva = $reserva->id;


                        }else
                        {
                            $dadosErro = $dadosErro + 1;
                            $solicitantes_professores = DB::select('select * from solicitantes where tipo_solicitante_id = 1');
                            $solicitantes_externos = DB::select('select * from solicitantes where tipo_solicitante_id = 4');
                            $laboratorios = DB::select('select * from laboratorio where restrito = 0 ');
                            $disciplinas = DB::select('select *from disciplinas where id > 2');
                            $tipo_reserva = DB::select('select * from tipo_reserva where id = 1 or id = 2');
                            $solicitantes_academicos = DB::select('select * from solicitantes where tipo_solicitante_id = 2');


                            //return response()->json($dadosErro);
                            return view('reserva.create',['solicitantes_academicos'=>$solicitantes_academicos,'dadosReserva'=> $dadosReserva,'dadosReserva2'=> $dadosReserva2,'dadosErro'=>$dadosErro, 'laboratorios' => $laboratorios, 'disciplinas' => $disciplinas, 'solicitantes_professores'=>$solicitantes_professores, 'solicitantes_externos'=>$solicitantes_externos]);
                        }
                        return redirect()->route('reservas.index')->with('success', 'Reserva criada com sucesso.');
                    }

                }
            }




                elseif ($request->opcaoReserva == 2) { //SEMANAL

                //$data = \Carbon\Carbon::createFromFormat('Y-m-d H:i',$request->hora_inicio)->format('Y-m-d');


                $horaInicio =  Carbon::createFromFormat('d/m/Y H:i', $request->hora_inicio)->format('Y-m-d H:i');
               // $horaFim =  Carbon::createFromFormat('d/m/Y H:i', $request->hora_fim)->format('H:i');

                $dataInicio = $data;
                $dataFim =  $request->dataFim;

                $diferencaData = (strtotime($dataFim) - strtotime($dataInicio))/86400;

                $diferencaData = $diferencaData + 1;
                $semanas = $diferencaData / 7;

                $reservasCadastradas = array();

                foreach($turnos as $turno){

                    if(strstr($turnoManha, $turno) !== False){


                        for ($i = 0; $i < $semanas; $i++) {

                            $dataReserva = date('Y-m-d H:i', strtotime('+' . $i . 'weeks', strtotime($dataInicio)));


                            $terminoAula =  date('Y-m-d H:i', strtotime('+' . 50*($request->QtdAulas) . 'minutes', strtotime($horaInicio)));


                            $horaIniReserva = date('Y-m-d H:i', strtotime('+' . $i . 'weeks', strtotime($horaInicio)));

                            $horaFimReserva =date('Y-m-d H:i', strtotime('+' . $i . 'weeks', strtotime($terminoAula)));






                        $dadosReserva = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                        ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                        ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                        ->join('users', 'users.id', '=', 'reserva.usuario_id')
                        ->where('start','<=',$horaIniReserva)
                        ->where('end','>=', $horaFimReserva)
                        ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                        ->orderBy('start', 'asc')
                        ->get();



                        $dadosReserva2 = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                        ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                        ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                        ->join('users', 'users.id', '=', 'reserva.usuario_id')
                        ->whereBetween('start', [$horaIniReserva, $horaFimReserva])
                        ->orwhereBetween('end', [$horaIniReserva, $horaFimReserva])
                        ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                        ->orderBy('start', 'desc')
                        ->get();

                        //return response()->json($horaInicio);

                            if ($dadosReserva == '[]' && $dadosReserva2 == '[]') {
                            $reserva = new Reserva();
                            $reserva->laboratorio_id = $request->laboratorio_id;
                            $reserva->usuario_id = $request->usuario_id;
                            $reserva->data = $dataReserva;
                            $reserva->start =  $horaIniReserva;
                            $reserva->end = $horaFimReserva;
                            $reserva->disciplina_id = $request->disciplinas_id;
                            $reserva->solicitante_id = $request->solicitante_id_professor;
                            $reserva->tipo_reserva_id = $request->tipo_reserva;
                            $reserva->observacao = $request->observacao;
                            $reserva->color = $cor_reserva;
                            $reserva->save();

                            $reservasCadastradas[] = $reserva;
                        }else
                        {
                            $dadosErro = $dadosErro + 1;
                            $solicitantes_professores = DB::select('select * from solicitantes where tipo_solicitante_id = 1');
                            $solicitantes_externos = DB::select('select * from solicitantes where tipo_solicitante_id = 4');
                            $laboratorios = DB::select('select * from laboratorio where restrito = 0 ');
                            $disciplinas = DB::select('select *from disciplinas where id > 2');
                            $tipo_reserva = DB::select('select * from tipo_reserva where id = 1 or id = 2');
                            $solicitantes_academicos = DB::select('select * from solicitantes where tipo_solicitante_id = 2');


                            //return response()->json($dadosErro);
                            return view('reserva.create',['solicitantes_academicos'=>$solicitantes_academicos,'dadosReserva'=> $dadosReserva,'dadosReserva2'=> $dadosReserva2,'dadosErro'=>$dadosErro, 'laboratorios' => $laboratorios, 'disciplinas' => $disciplinas, 'solicitantes_professores'=>$solicitantes_professores, 'solicitantes_externos'=>$solicitantes_externos]);
                        }

                }
                return redirect()->route('reservas.index')->with('success', 'Reserva criada com sucesso.');

            }
            elseif(strstr($turnoTarde, $turno) !== False){
                for ($i = 0; $i < $semanas; $i++) {

                    $dataReserva = date('Y-m-d H:i', strtotime('+' . $i . 'weeks', strtotime($dataInicio)));


                    $terminoAula =  date('Y-m-d H:i', strtotime('+' . 50*($request->QtdAulas) . 'minutes', strtotime($horaInicio)));


                    $horaIniReserva = date('Y-m-d H:i', strtotime('+' . $i . 'weeks', strtotime($terminoAula)));

                    $horaFimReserva =date('Y-m-d H:i', strtotime('+' . $i . 'weeks', strtotime($terminoAula)));

                    $dadosReserva = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                        ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                        ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                        ->join('users', 'users.id', '=', 'reserva.usuario_id')
                        ->where('start','<=',$horaIniReserva)
                        ->where('end','>=', $horaFimReserva)
                        ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                        ->orderBy('start', 'asc')
                        ->get();



                        $dadosReserva2 = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                        ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                        ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                        ->join('users', 'users.id', '=', 'reserva.usuario_id')
                        ->whereBetween('start', [$horaIniReserva, $horaFimReserva])
                        ->orwhereBetween('end', [$horaIniReserva, $horaFimReserva])
                        ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                        ->orderBy('start', 'desc')
                        ->get();

                        //return response()->json($horaInicio);

                            if ($dadosReserva == '[]' && $dadosReserva2 == '[]') {
                            $reserva = new Reserva();
                            $reserva->laboratorio_id = $request->laboratorio_id;
                            $reserva->usuario_id = $request->usuario_id;
                            $reserva->data = $dataReserva;
                            $reserva->start =  $horaIniReserva;
                            $reserva->end = $horaFimReserva;
                            $reserva->disciplina_id = $request->disciplinas_id;
                            $reserva->solicitante_id = $request->solicitante_id_professor;
                            $reserva->tipo_reserva_id = $request->tipo_reserva;
                            $reserva->observacao = $request->observacao;
                            $reserva->color = $cor_reserva;
                            $reserva->save();

                            $reservasCadastradas[] = $reserva;
                        }else
                        {
                            $dadosErro = $dadosErro + 1;
                            $solicitantes_professores = DB::select('select * from solicitantes where tipo_solicitante_id = 1');
                            $solicitantes_externos = DB::select('select * from solicitantes where tipo_solicitante_id = 4');
                            $laboratorios = DB::select('select * from laboratorio where restrito = 0 ');
                            $disciplinas = DB::select('select *from disciplinas where id > 2');
                            $tipo_reserva = DB::select('select * from tipo_reserva where id = 1 or id = 2');
                            $solicitantes_academicos = DB::select('select * from solicitantes where tipo_solicitante_id = 2');


                            //return response()->json($dadosErro);
                            return view('reserva.create',['solicitantes_academicos'=>$solicitantes_academicos,'dadosReserva'=> $dadosReserva,'dadosReserva2'=> $dadosReserva2,'dadosErro'=>$dadosErro, 'laboratorios' => $laboratorios, 'disciplinas' => $disciplinas, 'solicitantes_professores'=>$solicitantes_professores, 'solicitantes_externos'=>$solicitantes_externos]);
                        }

                }
                return redirect()->route('reservas.index')->with('success', 'Reserva criada com sucesso.');

            }


        elseif(strstr($turnoNoite, $turno) !== False){
            for ($i = 0; $i < $semanas; $i++) {

                $dataReserva = date('Y-m-d H:i', strtotime('+' . $i . 'weeks', strtotime($dataInicio)));


                    $terminoAula =  date('Y-m-d H:i', strtotime('+' . 55*($request->QtdAulas) . 'minutes', strtotime($horaInicio)));


                    $horaIniReserva = date('Y-m-d H:i', strtotime('+' . $i . 'weeks', strtotime($terminoAula)));

                    $horaFimReserva =date('Y-m-d H:i', strtotime('+' . $i . 'weeks', strtotime($terminoAula)));

                    $dadosReserva = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                        ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                        ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                        ->join('users', 'users.id', '=', 'reserva.usuario_id')
                        ->where('start','<=',$horaIniReserva)
                        ->where('end','>=', $horaFimReserva)
                        ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                        ->orderBy('start', 'asc')
                        ->get();



                        $dadosReserva2 = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                        ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                        ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                        ->join('users', 'users.id', '=', 'reserva.usuario_id')
                        ->whereBetween('start', [$horaIniReserva, $horaFimReserva])
                        ->orwhereBetween('end', [$horaIniReserva, $horaFimReserva])
                        ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                        ->orderBy('start', 'desc')
                        ->get();

                        //return response()->json($horaInicio);

                        if ($dadosReserva == '[]' && $dadosReserva2 == '[]') {
                        $reserva = new Reserva();
                        $reserva->laboratorio_id = $request->laboratorio_id;
                        $reserva->usuario_id = $request->usuario_id;
                        $reserva->data = $dataReserva;
                        $reserva->start =  $horaIniReserva;
                        $reserva->end = $horaFimReserva;
                        $reserva->disciplina_id = $request->disciplinas_id;
                        $reserva->solicitante_id = $request->solicitante_id_professor;
                        $reserva->tipo_reserva_id = $request->tipo_reserva;
                        $reserva->observacao = $request->observacao;
                        $reserva->color = $cor_reserva;
                        $reserva->save();

                        $reservasCadastradas[] = $reserva;
                    }else
                    {
                        $dadosErro = $dadosErro + 1;
                        $solicitantes_professores = DB::select('select * from solicitantes where tipo_solicitante_id = 1');
                        $solicitantes_externos = DB::select('select * from solicitantes where tipo_solicitante_id = 4');
                        $laboratorios = DB::select('select * from laboratorio where restrito = 0 ');
                        $disciplinas = DB::select('select *from disciplinas where id > 2');
                        $tipo_reserva = DB::select('select * from tipo_reserva where id = 1 or id = 2');
                        $solicitantes_academicos = DB::select('select * from solicitantes where tipo_solicitante_id = 2');


                        //return response()->json($dadosErro);
                        return view('reserva.create',['solicitantes_academicos'=>$solicitantes_academicos,'dadosReserva'=> $dadosReserva,'dadosReserva2'=> $dadosReserva2,'dadosErro'=>$dadosErro, 'laboratorios' => $laboratorios, 'disciplinas' => $disciplinas, 'solicitantes_professores'=>$solicitantes_professores, 'solicitantes_externos'=>$solicitantes_externos]);
                    }

            }
            return redirect()->route('reservas.index')->with('success', 'Reserva criada com sucesso.');

        }
      }

    }

            elseif ($request->opcaoReserva == 3) {
                    //CRIA UMA RESERVA DIARIA PARA UM PROFESSOR ESPECIFICO

                    $data = Carbon::createFromFormat('d/m/Y H:i', $request->hora_inicio)->format('Y-m-d');

                    $inicio = Carbon::createFromFormat('d/m/Y H:i', $request->hora_inicio)->format('Y-m-d H:i');



                    $dataInicio = $data;
                    $dataFim =  $request->dataFim;


                    $diferencaData = (strtotime($dataFim) - strtotime($dataInicio)) / 86400;

                    $diferencaData = $diferencaData + 1;
                    $reservasCadastradas = array();

                    $horaInicio =  Carbon::createFromFormat('d/m/Y H:i', $request->hora_inicio)->format('H:i');

                    foreach($turnos as $turno){

                        if(strstr($turnoManha, $turno) !== False){


                    for ($i = 0; $i < $diferencaData; $i++) {

                        $dataReserva = date('Y-m-d', strtotime('+' . $i . 'days', strtotime($data)));
                        $terminoAula =  date('Y-m-d H:i', strtotime('+' . 50*($request->QtdAulas) . 'minutes', strtotime($horaInicio)));

                       // $terminoAulaN =  date('Y-m-d H:i', strtotime('+' . 55*($request->QtdAulas) . 'minutes', strtotime($request->hora_inicio)));


                        $horaIniReserva = date('Y-m-d H:i', strtotime('+' . $i . 'days', strtotime($inicio)));
                        $horaFimReserva =date('Y-m-d H:i', strtotime('+' . $i . 'days', strtotime($terminoAula)));

                        $dadosReserva = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                        ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                        ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                        ->join('users', 'users.id', '=', 'reserva.usuario_id')
                        ->where('start','<=',$horaIniReserva)
                        ->where('end','>=', $horaFimReserva)
                        ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                        ->orderBy('start', 'asc')
                        ->get();



                        $dadosReserva2 = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                        ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                        ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                        ->join('users', 'users.id', '=', 'reserva.usuario_id')
                        ->whereBetween('start', [$horaIniReserva, $horaFimReserva])
                        ->orwhereBetween('end', [$horaIniReserva, $horaFimReserva])
                        ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                        ->orderBy('start', 'desc')
                        ->get();

                        //return response()->json($horaInicio);

                            if ($dadosReserva == '[]' && $dadosReserva2 == '[]') {
                            $reserva = new Reserva();
                            $reserva->laboratorio_id = $request->laboratorio_id;
                            $reserva->usuario_id = $request->usuario_id;
                            $reserva->data = $dataReserva;
                            $reserva->start =  $horaIniReserva;
                            $reserva->end = $horaFimReserva;
                            $reserva->solicitante_id = $request->solicitante_id_professor;
                            $reserva->disciplina_id = $request->disciplinas_id;
                            $reserva->tipo_reserva_id = $request->tipo_reserva;
                            $reserva->observacao = $request->observacao;
                            $reserva->color = $cor_reserva;
                            $reserva->save();
                            $reservasCadastradas[] = $reserva;

                        }else
                        {
                            $dadosErro = $dadosErro + 1;
                            $solicitantes_professores = DB::select('select * from solicitantes where tipo_solicitante_id = 1');
                            $solicitantes_externos = DB::select('select * from solicitantes where tipo_solicitante_id = 4');
                            $laboratorios = DB::select('select * from laboratorio where restrito = 0 ');
                            $disciplinas = DB::select('select *from disciplinas where id > 2');
                            $tipo_reserva = DB::select('select * from tipo_reserva where id = 1 or id = 2');
                            $solicitantes_academicos = DB::select('select * from solicitantes where tipo_solicitante_id = 2');


                            //return response()->json($dadosErro);
                            return view('reserva.create',['solicitantes_academicos'=>$solicitantes_academicos,'dadosReserva'=> $dadosReserva,'dadosReserva2'=> $dadosReserva2,'dadosErro'=>$dadosErro, 'laboratorios' => $laboratorios, 'disciplinas' => $disciplinas, 'solicitantes_professores'=>$solicitantes_professores, 'solicitantes_externos'=>$solicitantes_externos]);
                        }
                    }
                    return redirect()->route('reservas.index')->with('success', 'Reserva criada com sucesso.');

                }
                elseif(strstr($turnoTarde, $turno) !== False){

                    for ($i = 0; $i < $diferencaData; $i++) {

                        $dataReserva = date('Y-m-d', strtotime('+' . $i . 'days', strtotime($data)));
                        $terminoAula =  date('Y-m-d H:i', strtotime('+' . 50*($request->QtdAulas) . 'minutes', strtotime($horaInicio)));

                       // $terminoAulaN =  date('Y-m-d H:i', strtotime('+' . 55*($request->QtdAulas) . 'minutes', strtotime($request->hora_inicio)));


                        $horaIniReserva = date('Y-m-d H:i', strtotime('+' . $i . 'days', strtotime($inicio)));
                        $horaFimReserva =date('Y-m-d H:i', strtotime('+' . $i . 'days', strtotime($terminoAula)));

                        $dadosReserva = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                        ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                        ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                        ->join('users', 'users.id', '=', 'reserva.usuario_id')
                        ->where('start','<=',$horaIniReserva)
                        ->where('end','>=', $horaFimReserva)
                        ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                        ->orderBy('start', 'asc')
                        ->get();



                        $dadosReserva2 = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                        ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                        ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                        ->join('users', 'users.id', '=', 'reserva.usuario_id')
                        ->whereBetween('start', [$horaIniReserva, $horaFimReserva])
                        ->orwhereBetween('end', [$horaIniReserva, $horaFimReserva])
                        ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                        ->orderBy('start', 'desc')
                        ->get();

                        //return response()->json($horaInicio);

                            if ($dadosReserva == '[]' && $dadosReserva2 == '[]') {
                            $reserva = new Reserva();
                            $reserva->laboratorio_id = $request->laboratorio_id;
                            $reserva->usuario_id = $request->usuario_id;
                            $reserva->data = $dataReserva;
                            $reserva->start =  $horaIniReserva;
                            $reserva->end = $horaFimReserva;
                            $reserva->solicitante_id = $request->solicitante_id_professor;
                            $reserva->disciplina_id = $request->disciplinas_id;
                            $reserva->tipo_reserva_id = $request->tipo_reserva;
                            $reserva->observacao = $request->observacao;
                            $reserva->color = $cor_reserva;
                            $reserva->save();
                            $reservasCadastradas[] = $reserva;

                        }else
                        {
                            $dadosErro = $dadosErro + 1;
                            $solicitantes_professores = DB::select('select * from solicitantes where tipo_solicitante_id = 1');
                            $solicitantes_externos = DB::select('select * from solicitantes where tipo_solicitante_id = 4');
                            $laboratorios = DB::select('select * from laboratorio where restrito = 0 ');
                            $disciplinas = DB::select('select *from disciplinas where id > 2');
                            $tipo_reserva = DB::select('select * from tipo_reserva where id = 1 or id = 2');
                            $solicitantes_academicos = DB::select('select * from solicitantes where tipo_solicitante_id = 2');


                            //return response()->json($dadosErro);
                            return view('reserva.create',['solicitantes_academicos'=>$solicitantes_academicos,'dadosReserva'=> $dadosReserva,'dadosReserva2'=> $dadosReserva2,'dadosErro'=>$dadosErro, 'laboratorios' => $laboratorios, 'disciplinas' => $disciplinas, 'solicitantes_professores'=>$solicitantes_professores, 'solicitantes_externos'=>$solicitantes_externos]);
                        }
                    }
                    return redirect()->route('reservas.index')->with('success', 'Reserva criada com sucesso.');

                }

                elseif(strstr($turnoNoite, $turno) !== False){

                    for ($i = 0; $i < $diferencaData; $i++) {

                        $dataReserva = date('Y-m-d', strtotime('+' . $i . 'days', strtotime($data)));
                        $terminoAula =  date('Y-m-d H:i', strtotime('+' . 55*($request->QtdAulas) . 'minutes', strtotime($horaInicio)));

                       // $terminoAulaN =  date('Y-m-d H:i', strtotime('+' . 55*($request->QtdAulas) . 'minutes', strtotime($request->hora_inicio)));


                        $horaIniReserva = date('Y-m-d H:i', strtotime('+' . $i . 'days', strtotime($inicio)));
                        $horaFimReserva =date('Y-m-d H:i', strtotime('+' . $i . 'days', strtotime($terminoAula)));

                        $dadosReserva = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                        ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                        ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                        ->join('users', 'users.id', '=', 'reserva.usuario_id')
                        ->where('start','<=',$horaIniReserva)
                        ->where('end','>=', $horaFimReserva)
                        ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                        ->orderBy('start', 'asc')
                        ->get();



                        $dadosReserva2 = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                        ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                        ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                        ->join('users', 'users.id', '=', 'reserva.usuario_id')
                        ->whereBetween('start', [$horaIniReserva, $horaFimReserva])
                        ->orwhereBetween('end', [$horaIniReserva, $horaFimReserva])
                        ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                        ->orderBy('start', 'desc')
                        ->get();

                        //return response()->json($horaInicio);

                            if ($dadosReserva == '[]' && $dadosReserva2 == '[]') {
                            $reserva = new Reserva();
                            $reserva->laboratorio_id = $request->laboratorio_id;
                            $reserva->usuario_id = $request->usuario_id;
                            $reserva->data = $dataReserva;
                            $reserva->start =  $horaIniReserva;
                            $reserva->end = $horaFimReserva;
                            $reserva->solicitante_id = $request->solicitante_id_professor;
                            $reserva->disciplina_id = $request->disciplinas_id;
                            $reserva->tipo_reserva_id = $request->tipo_reserva;
                            $reserva->observacao = $request->observacao;
                            $reserva->color = $cor_reserva;
                            $reserva->save();
                            $reservasCadastradas[] = $reserva;

                        }else
                        {
                            $dadosErro = $dadosErro + 1;
                            $solicitantes_professores = DB::select('select * from solicitantes where tipo_solicitante_id = 1');
                            $solicitantes_externos = DB::select('select * from solicitantes where tipo_solicitante_id = 4');
                            $laboratorios = DB::select('select * from laboratorio where restrito = 0 ');
                            $disciplinas = DB::select('select *from disciplinas where id > 2');
                            $tipo_reserva = DB::select('select * from tipo_reserva where id = 1 or id = 2');
                            $solicitantes_academicos = DB::select('select * from solicitantes where tipo_solicitante_id = 2');


                            //return response()->json($dadosErro);
                            return view('reserva.create',['solicitantes_academicos'=>$solicitantes_academicos,'dadosReserva'=> $dadosReserva,'dadosReserva2'=> $dadosReserva2,'dadosErro'=>$dadosErro, 'laboratorios' => $laboratorios, 'disciplinas' => $disciplinas, 'solicitantes_professores'=>$solicitantes_professores, 'solicitantes_externos'=>$solicitantes_externos]);
                        }
                    }
                    return redirect()->route('reservas.index')->with('success', 'Reserva criada com sucesso.');

                }
            }
        }
    }


                                //APARTIR DAQUI É CRIADO RESERVAS PARA USUÁRIOS EXTERNOS
                                elseif ($request->tipo_reserva == $tipo_reserva_externo){


                                    $cor_reserva = "#a31826";


                                    if($request->opcaoReserva == 1){ // UM DIA SÓ


                                        $data = Carbon::createFromFormat('d/m/Y H:i', $request->hora_inicio_ext)->format('Y-m-d');

                                    $inicio = Carbon::createFromFormat('d/m/Y H:i', $request->hora_inicio_ext)->format('Y-m-d H:i');

                                    $termino = Carbon::createFromFormat('d/m/Y H:i', $request->hora_fim_ext)->format('Y-m-d H:i');


                                    $dadosReserva = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                        ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                        ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                        ->join('users', 'users.id', '=', 'reserva.usuario_id')
                        ->where('start','<=',$inicio)
                        ->where('end','>=', $termino)
                        ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                        ->orderBy('start', 'asc')
                        ->get();



                        $dadosReserva2 = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                        ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                        ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                        ->join('users', 'users.id', '=', 'reserva.usuario_id')
                        ->whereBetween('start', [$inicio, $termino])
                        ->orwhereBetween('end', [$inicio, $termino])
                        ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                        ->orderBy('start', 'desc')
                        ->get();

                        //return response()->json($horaInicio);

                            if ($dadosReserva == '[]' && $dadosReserva2 == '[]') {
                                            $reserva = new Reserva();
                                            $reserva->laboratorio_id = $request->laboratorio_id;
                                            $reserva->usuario_id = $request->usuario_id;
                                            $reserva->data = $data;
                                            $reserva->start = $inicio;
                                            $reserva->end = $termino;
                                            $reserva->solicitante_id = $request->solicitante_id_externo;
                                            $reserva->observacao = $request->observacao;
                                            $reserva->color = $cor_reserva;
                                            $reserva->tipo_reserva_id = $request->tipo_reserva;

                                            $reserva->save();

                                            return redirect()->route('reservas.index')->with('success', 'Reserva para usuário externo criada com sucesso.');

                                        }else
                                        {
                                            $dadosErro = $dadosErro + 1;
                                            $solicitantes_academicos = DB::select('select * from solicitantes where tipo_solicitante_id = 2');
                                            $solicitantes_professores = DB::select('select * from solicitantes where tipo_solicitante_id = 1');
                                            $solicitantes_externos = DB::select('select * from solicitantes where tipo_solicitante_id = 4');
                                            $laboratorios = DB::select('select * from laboratorio where restrito = 0 ');
                                            $disciplinas = DB::select('select *from disciplinas where id > 2');
                                            $tipo_reserva = DB::select('select * from tipo_reserva where id = 1 or id = 2');
                                            $solicitantes_academicos = DB::select('select * from solicitantes where tipo_solicitante_id = 2');


                                            //return response()->json($dadosErro);
                                            return view('reserva.create',['solicitantes_academicos'=>$solicitantes_academicos,'solicitantes_academicos'=>$solicitantes_academicos,'dadosReserva'=> $dadosReserva,'dadosErro'=>$dadosErro, 'laboratorios' => $laboratorios, 'disciplinas' => $disciplinas, 'solicitantes_professores'=>$solicitantes_professores, 'solicitantes_externos'=>$solicitantes_externos]);
                                        }

                                }

                                elseif ($request->opcaoReserva == 2) {

                                    $data = Carbon::createFromFormat('d/m/Y H:i', $request->hora_inicio_ext)->format('Y-m-d');

                                    //SEMANALMENTE


                                $dataInicio = $data;

                                $dataFim =  $request->dataFim_ext;

                                $diferencaData = (strtotime($dataFim) - strtotime($dataInicio)) / 86400;

                                $diferencaData = $diferencaData + 1;
                                $semanas = $diferencaData / 7;


                                for ($i = 0; $i < $semanas; $i++) {

                                    $dataReserva = date('Y-m-d', strtotime('+' . $i . 'weeks', strtotime($dataInicio)));

                                    $horaIniReserva = date('Y-m-d H:i', strtotime('+' . $i . 'weeks', strtotime($request->hora_inicio_ext)));
                                    $horaFimReserva =date('Y-m-d H:i', strtotime('+' . $i . 'weeks', strtotime($request->hora_fim_ext)));


                                    $dadosReserva = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                        ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                        ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                        ->join('users', 'users.id', '=', 'reserva.usuario_id')
                        ->where('start','<=',$horaIniReserva)
                        ->where('end','>=', $horaFimReserva)
                        ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                        ->orderBy('start', 'asc')
                        ->get();



                        $dadosReserva2 = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                        ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                        ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                        ->join('users', 'users.id', '=', 'reserva.usuario_id')
                        ->whereBetween('start', [$horaIniReserva, $horaFimReserva])
                        ->orwhereBetween('end', [$horaIniReserva, $horaFimReserva])
                        ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                        ->orderBy('start', 'desc')
                        ->get();

                        //return response()->json($horaInicio);

                            if ($dadosReserva == '[]' && $dadosReserva2 == '[]') {
                                        $reserva = new Reserva();
                                        $reserva->laboratorio_id = $request->laboratorio_id;
                                        $reserva->usuario_id = $request->usuario_id;
                                        $reserva->data = $dataReserva;
                                        $reserva->start = $horaIniReserva;
                                        $reserva->end = $horaFimReserva;
                                        $reserva->solicitante_id = $request->solicitante_id_externo;
                                        $reserva->tipo_reserva_id = $request->tipo_reserva;
                                        $reserva->observacao = $request->observacao;
                                        $reserva->color = $cor_reserva;
                                        $reserva->save();

                                    }else
                                    {
                                        $dadosErro = $dadosErro + 1;
                                        $solicitantes_professores = DB::select('select * from solicitantes where tipo_solicitante_id = 1');
                                        $solicitantes_externos = DB::select('select * from solicitantes where tipo_solicitante_id = 4');
                                        $laboratorios = DB::select('select * from laboratorio where restrito = 0 ');
                                        $disciplinas = DB::select('select *from disciplinas where id > 2');
                                        $tipo_reserva = DB::select('select * from tipo_reserva where id = 1 or id = 2');
                                        $solicitantes_academicos = DB::select('select * from solicitantes where tipo_solicitante_id = 2');


                                        //return response()->json($dadosErro);
                                        return view('reserva.create',['solicitantes_academicos'=>$solicitantes_academicos,'dadosReserva'=> $dadosReserva,'dadosReserva2'=> $dadosReserva2,'dadosErro'=>$dadosErro, 'laboratorios' => $laboratorios, 'disciplinas' => $disciplinas, 'solicitantes_professores'=>$solicitantes_professores, 'solicitantes_externos'=>$solicitantes_externos]);
                                    }

                                }
                                return redirect()->route('reservas.index')->with('success', 'Reserva externa diaria criada com sucesso.');
                            }


                            elseif ($request->opcaoReserva == 3) {
                                //DIARIAMENTE
                                $data = Carbon::createFromFormat('d/m/Y H:i', $request->hora_inicio_ext)->format('Y-m-d');

                                $inicio = Carbon::createFromFormat('d/m/Y H:i', $request->hora_inicio_ext)->format('Y-m-d H:i');

                                $termino = Carbon::createFromFormat('d/m/Y H:i', $request->hora_fim_ext)->format('Y-m-d H:i');

                                $dataInicio = $data;
                                $dataFim =  $request->dataFim_ext;


                                $diferencaData = (strtotime($dataFim) - strtotime($dataInicio)) / 86400;

                                $diferencaData = $diferencaData + 1;
                                $reservasCadastradas = array();

                                for ($i = 0; $i < $diferencaData; $i++) {

                                    $dataReserva = date('Y-m-d', strtotime('+' . $i . 'days', strtotime($dataInicio)));

                                    $horaIniReserva = date('Y-m-d H:i:s', strtotime('+' . $i . 'days', strtotime($inicio)));
                                    $horaFimReserva =date('Y-m-d H:i:s', strtotime('+' . $i . 'days', strtotime($termino)));


                                    $dadosReserva = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                                    ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                                    ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                                    ->join('users', 'users.id', '=', 'reserva.usuario_id')
                                    ->where('start','<=',$horaIniReserva)
                                    ->where('end','>=', $horaFimReserva)
                                    ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                                    ->orderBy('start', 'asc')
                                    ->get();



                                    $dadosReserva2 = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                                    ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                                    ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                                    ->join('users', 'users.id', '=', 'reserva.usuario_id')
                                    ->whereBetween('start', [$horaIniReserva, $horaFimReserva])
                                    ->orwhereBetween('end', [$horaIniReserva, $horaFimReserva])
                                    ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                                    ->orderBy('start', 'desc')
                                    ->get();

                                    //return response()->json($horaInicio);

                                        if ($dadosReserva == '[]' && $dadosReserva2 == '[]') {
                                        $reserva = new Reserva();
                                        $reserva->laboratorio_id = $request->laboratorio_id;
                                        $reserva->usuario_id = $request->usuario_id;
                                        $reserva->data = $dataReserva;
                                        $reserva->start = $horaIniReserva;
                                        $reserva->end = $horaFimReserva;
                                        $reserva->solicitante_id = $request->solicitante_id_externo;
                                        $reserva->tipo_reserva_id = $request->tipo_reserva;
                                        $reserva->observacao = $request->observacao;
                                        $reserva->color = $cor_reserva;
                                        $reserva->save();
                                        $reservasCadastradas[] = $reserva;

                                    }else
                                    {
                                        $dadosErro = $dadosErro + 1;
                                        $solicitantes_professores = DB::select('select * from solicitantes where tipo_solicitante_id = 1');
                                        $solicitantes_externos = DB::select('select * from solicitantes where tipo_solicitante_id = 4');
                                        $laboratorios = DB::select('select * from laboratorio where restrito = 0 ');
                                        $disciplinas = DB::select('select *from disciplinas where id > 2');
                                        $tipo_reserva = DB::select('select * from tipo_reserva where id = 1 or id = 2');
                                        $solicitantes_academicos = DB::select('select * from solicitantes where tipo_solicitante_id = 2');


                                        //return response()->json($dadosErro);
                                        return view('reserva.create',['solicitantes_academicos'=>$solicitantes_academicos,'dadosReserva'=> $dadosReserva,'dadosReserva2'=> $dadosReserva2,'dadosErro'=>$dadosErro, 'laboratorios' => $laboratorios, 'disciplinas' => $disciplinas, 'solicitantes_professores'=>$solicitantes_professores, 'solicitantes_externos'=>$solicitantes_externos]);
                                    }
                                    }
                                    return redirect()->route('reservas.index')->with('success', 'Reserva externa diaria criada com sucesso.');
                        }
                            }
                                elseif($request->tipo_reserva == 3){

                                    $inicio = Carbon::now();

                                    echo date($inicio);
                                    $data = Carbon::createFromFormat('Y-m-d H:i:s', $inicio)->format('Y-m-d');

                                //$inicio = Carbon::createFromFormat('d/m/Y H:i', $request->hora_inicio)->format('Y-m-d H:i');
                                //uma vez para alunos
                                //$termino = Carbon::createFromFormat('d/m/Y H:i', $request->hora_fim)->format('Y-m-d H:i');
                                    $cor_reserva = '#1ca317';



                                $termino = date('Y-m-d H:i', strtotime('+' . 60 . 'minutes', strtotime($inicio)));



                                $dadosReserva = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                                ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                                ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                                ->join('users', 'users.id', '=', 'reserva.usuario_id')
                                ->where('start','<=',$inicio)
                                ->where('end','>=', $termino)
                                ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                                ->orderBy('start', 'asc')
                                ->get();



                                $dadosReserva2 = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                                ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                                ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                                ->join('users', 'users.id', '=', 'reserva.usuario_id')
                                ->whereBetween('start', [$inicio, $termino])
                                ->orwhereBetween('end', [$inicio, $termino])
                                ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
                                ->orderBy('start', 'desc')
                                ->get();

                                //return response()->json($horaInicio);

                                    if ($dadosReserva == '[]' && $dadosReserva2 == '[]') {
                                    $reserva = new Reserva();
                                    $reserva->laboratorio_id = $request->laboratorio_id;
                                    $reserva->usuario_id = $request->usuario_id;
                                    $reserva->data = $data;
                                    $reserva->start = $inicio;
                                    //$reserva->end = $termino;
                                    $reserva->solicitante_id = $request->solicitante_id_academicos;
                                    $reserva->observacao = $request->observacao;
                                    $reserva->tipo_reserva_id = $request->tipo_reserva;
                                    $reserva->disciplina_id = '2';
                                    $reserva->color = $cor_reserva;
                                    $reserva->save();

                                    $idReserva = $reserva->id;


                                }else
                                {
                                    $dadosErro = $dadosErro + 1;
                                    $solicitantes_professores = DB::select('select * from solicitantes where tipo_solicitante_id = 1');
                                    $solicitantes_externos = DB::select('select * from solicitantes where tipo_solicitante_id = 4');
                                    $laboratorios = DB::select('select * from laboratorio where restrito = 0 ');
                                    $disciplinas = DB::select('select *from disciplinas where id > 2');
                                    $tipo_reserva = DB::select('select * from tipo_reserva where id = 1 or id = 2');
                                    $solicitantes_academicos = DB::select('select * from solicitantes where tipo_solicitante_id = 2');


                                    //return response()->json($dadosErro);
                                    return view('reserva.create',['solicitantes_academicos'=>$solicitantes_academicos,'dadosReserva'=> $dadosReserva,'dadosReserva2'=> $dadosReserva2,'dadosErro'=>$dadosErro, 'laboratorios' => $laboratorios, 'disciplinas' => $disciplinas, 'solicitantes_professores'=>$solicitantes_professores, 'solicitantes_externos'=>$solicitantes_externos]);
                                }
                                return redirect()->route('reservas.index')->with('success', 'Reserva criada com sucesso.');



                        }







}





public function alterarStatus(Reserva $reservas, $idReserva){


    $reservas = DB::table('reserva')->select('reserva.*')->where('reserva.id', '=', $idReserva)->get();
    $status_reserva = DB::table('reserva')->select('reserva.status')->where('reserva.id', '=', $idReserva)->value('status');


    if ($reservas == null) {
        return redirect()->route('reservas.index')->with('error','Ocorreu um erro interno no sistema, tente mais tarde.');

    } elseif ($reservas !== null) {
        if ($status_reserva == 1) {
            DB::table('reserva')
                ->where('id', $idReserva)
                ->update(['status' => 0, 'end' =>Carbon::now()]);
                return redirect()->route('reservas.index')->with('success', 'O Laboratorio está livre para o uso.');
        } elseif ($status_reserva == 0) {

            DB::table('reserva')
                ->where('id', $idReserva)
                ->update(['status' => 1]);
                return redirect()->route('reservas.index')->with('info', 'O Laboratorio está reservado novamente".');

        }
    }
}

    public function edit($id){

        $solicitantes_professores = DB::select('select * from solicitantes where tipo_solicitante_id = 1');
        $solicitantes_externo = DB::select('select * from solicitantes where tipo_solicitante_id = 4');
        $solicitantes_academicos = DB::select('select * from solicitantes where tipo_solicitante_id = 2');
        $laboratorios = Laboratorio::all();
        $disciplinas = DB::select('select *from disciplinas where id > 2');
        $tipo_reserva = TipoReserva::all();
        $dados =array();
        $dados = DB::select('select reserva.start from reserva where id = ?',[$id]);
        $dadosErro = 0;
        $reserva = Reserva::find($id);

        // return response()->json($dados);
        return view('reserva.edit', ['dadosErro'=>$dadosErro,'reserva'=>$reserva,'solicitantes_academicos'=>$solicitantes_academicos,'solicitantes_professores'=> $solicitantes_professores,'solicitantes_externos' => $solicitantes_externo, 'tipo_reserva' =>$tipo_reserva , 'disciplinas' =>$disciplinas, 'laboratorios'=>$laboratorios]);

    }

    public function update(Request $request, Reserva $reserva){

        $tipo_reserva_disciplina = 1;
        $tipo_reserva_externo = 2;
        $tipo_reserva_academico = 3;

        $dadosErro =0;

        $inicio = Carbon::createFromFormat('d/m/Y H:i', $request->hora_inicio)->format('Y-m-d H:i');
        $termino = Carbon::createFromFormat('d/m/Y H:i', $request->hora_fim)->format('Y-m-d H:i');




        if ($request->tipo_reserva == $tipo_reserva_disciplina){

            $data = Carbon::createFromFormat('Y-m-d H:i', $request->hora_inicio)->format('Y-m-d');

        $horaInicio =  $request->hora_inicio;
        $hora_fim = $request->hora_fim;

        $dadosReserva3 = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                    ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                    ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                    ->join('users', 'users.id', '=', 'reserva.usuario_id')
                    ->where('reserva.end', '>', $termino)
                    ->where('reserva.start', '<', $inicio)
                    ->where('data', '=', $request->data)
                    ->where('reserva.laboratorio_id', '=', $request->laboratorio_id);

        $dadosReserva = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
            ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
            ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
            ->join('users', 'users.id', '=', 'reserva.usuario_id')
            ->whereBetween('reserva.end',  [$inicio, $termino])
            ->where('data', '=', $request->data)
            ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
            ->whereNotIn('reserva.id', [$request->reserva_id]);

        $dadosReserva = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
            ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
            ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
            ->join('users', 'users.id', '=', 'reserva.usuario_id')
            ->whereBetween('reserva.start', [$inicio, $termino])
            ->where('data', '=', $request->data)
            ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
            ->whereNotIn('reserva.id', [$request->reserva_id])
            ->union($dadosReserva)
            ->union($dadosReserva3)
            ->orderBy('start', 'asc')
            ->get();

        $idReserva = $request->reserva_id;

        if($dadosReserva == '[]'){
            $reserva->tipo_reserva_id =  $request->tipo_reserva;
            $reserva->data = $data;
            $reserva->start = $inicio;
            $reserva->end = $termino;
            $reserva->laboratorio_id = $request->laboratorio_id;
            $reserva->disciplina_id = $request->disciplinas_id;
            $reserva->solicitante_id = $request->solicitante_id_professor;
            $reserva->color = '#2757c6';


            $reserva->update();


            return redirect()->route('reservas.index', $request->laboratorio_id)->with('success','Reserva Atualizada com sucesso.');
        }else
        {
            $dadosErro = $dadosErro + 1;
            $solicitantes_professores = DB::select('select * from solicitantes where tipo_solicitante_id = 1');
            $solicitantes_externos = DB::select('select * from solicitantes where tipo_solicitante_id = 4');
            $laboratorios = DB::select('select * from laboratorio where restrito = 0 ');
            $disciplinas = DB::select('select *from disciplinas where id > 2');
            $tipo_reserva = DB::select('select * from tipo_reserva where id = 1 or id = 2');
            $solicitantes_academicos = DB::select('select * from solicitantes where tipo_solicitante_id = 2');


            //return response()->json($dadosErro);
            return view('reserva.edit',['solicitantes_academicos'=>$solicitantes_academicos,'dadosReserva'=> $dadosReserva,'dadosErro'=>$dadosErro, 'laboratorios' => $laboratorios, 'disciplinas' => $disciplinas, 'solicitantes_professores'=>$solicitantes_professores, 'solicitantes_externos'=>$solicitantes_externos]);
        }

        }

        elseif ($request->tipo_reserva == $tipo_reserva_externo){

        $data = Carbon::createFromFormat('Y-m-d H:i', $request->hora_inicio)->format('Y-m-d');

        $horaInicio =  $request->hora_inicio;
        $hora_fim = $request->hora_fim;

        $dadosReserva3 = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                    ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                    ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                    ->join('users', 'users.id', '=', 'reserva.usuario_id')
                    ->where('reserva.end', '>', $termino)
                    ->where('reserva.start', '<', $inicio)
                    ->where('data', '=', $request->data)
                    ->where('reserva.laboratorio_id', '=', $request->laboratorio_id);

        $dadosReserva = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
            ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
            ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
            ->join('users', 'users.id', '=', 'reserva.usuario_id')
            ->whereBetween('reserva.end',  [$inicio, $termino])
            ->where('data', '=', $request->data)
            ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
            ->whereNotIn('reserva.id', [$request->reserva_id]);

        $dadosReserva = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
            ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
            ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
            ->join('users', 'users.id', '=', 'reserva.usuario_id')
            ->whereBetween('reserva.start', [$inicio, $termino])
            ->where('data', '=', $request->data)
            ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
            ->whereNotIn('reserva.id', [$request->reserva_id])
            ->union($dadosReserva)
            ->union($dadosReserva3)
            ->orderBy('start', 'asc')
            ->get();

        $idReserva = $request->reserva_id;

        if($dadosReserva == '[]'){
            $reserva->tipo_reserva_id =  $request->tipo_reserva;
            $reserva->data = $data;
            $reserva->start = $inicio;
            $reserva->end = $termino;
            $reserva->laboratorio_id = $request->laboratorio_id;
            $reserva->disciplina_id = '1';
            $reserva->solicitante_id = $request->solicitante_id_externo;
            $reserva->color = '#a31826';

            $reserva->update();


            return redirect()->route('reservas.index', $request->laboratorio_id)->with('success','Reserva Atualizada com sucesso.');
        }else
        {
            $dadosErro = $dadosErro + 1;
            $solicitantes_professores = DB::select('select * from solicitantes where tipo_solicitante_id = 1');
            $solicitantes_externos = DB::select('select * from solicitantes where tipo_solicitante_id = 4');
            $laboratorios = DB::select('select * from laboratorio where restrito = 0 ');
            $disciplinas = DB::select('select *from disciplinas where id > 2');
            $tipo_reserva = DB::select('select * from tipo_reserva where id = 1 or id = 2');
            $solicitantes_academicos = DB::select('select * from solicitantes where tipo_solicitante_id = 2');


            //return response()->json($dadosErro);
            return view('reserva.edit',['solicitantes_academicos'=>$solicitantes_academicos,'dadosReserva'=> $dadosReserva,'dadosErro'=>$dadosErro, 'laboratorios' => $laboratorios, 'disciplinas' => $disciplinas, 'solicitantes_professores'=>$solicitantes_professores, 'solicitantes_externos'=>$solicitantes_externos]);
        }

    }
    elseif ($request->tipo_reserva == $tipo_reserva_academico){

        $data = Carbon::createFromFormat('Y-m-d H:i', $request->hora_inicio)->format('Y-m-d');

        $horaInicio =  $request->hora_inicio;
        $hora_fim = $request->hora_fim;

        $dadosReserva3 = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
                    ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
                    ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
                    ->join('users', 'users.id', '=', 'reserva.usuario_id')
                    ->where('reserva.end', '>', $termino)
                    ->where('reserva.start', '<', $inicio)
                    ->where('data', '=', $request->data)
                    ->where('reserva.laboratorio_id', '=', $request->laboratorio_id);

        $dadosReserva = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
            ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
            ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
            ->join('users', 'users.id', '=', 'reserva.usuario_id')
            ->whereBetween('reserva.end',  [$inicio, $termino])
            ->where('data', '=', $request->data)
            ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
            ->whereNotIn('reserva.id', [$request->reserva_id]);

        $dadosReserva = DB::table('reserva')->select('reserva.*', 'users.nome as nomeUsuario', 'solicitantes.nome as nomeSolicitante', 'laboratorio.nome as nomeLaboratorio')
            ->join('laboratorio', 'laboratorio.id', '=', 'reserva.laboratorio_id')
            ->join('solicitantes', 'solicitantes.id', '=', 'reserva.solicitante_id')
            ->join('users', 'users.id', '=', 'reserva.usuario_id')
            ->whereBetween('reserva.start', [$inicio, $termino])
            ->where('data', '=', $request->data)
            ->where('reserva.laboratorio_id', '=', $request->laboratorio_id)
            ->whereNotIn('reserva.id', [$request->reserva_id])
            ->union($dadosReserva)
            ->union($dadosReserva3)
            ->orderBy('start', 'asc')
            ->get();

        $idReserva = $request->reserva_id;

        if($dadosReserva == '[]'){
            $reserva->tipo_reserva_id =  $request->tipo_reserva;
            $reserva->data = $data;
            $reserva->start = $inicio;
            $reserva->end = $termino;
            $reserva->laboratorio_id = $request->laboratorio_id;
            $reserva->disciplina_id = '2';
            $reserva->solicitante_id = $request->solicitante_id_externo;
            $reserva->color = '#1ca317';

            $reserva->update();


            return redirect()->route('reservas.index', $request->laboratorio_id)->with('success','Reserva Atualizada com sucesso.');
        }else{

            return redirect()->route('reservas.index', $request->laboratorio_id)->with('error','Erro ao atualizar a reserva.');
        }

    }
}

    public function destroy(Request $request){

        $id = $request->reserva_id;

        $id = Reserva::find($id);

        $delete= $id->delete();

        if($delete){

            return redirect()->route('reservas.index')->with('success', 'Reserva escludida com sucesso');
        }
            else
            return redirect()->route('reservas.index')->with('error', 'Erro, existe alguma pendencia que não foi possivel excluir a reserva');


    }

    public function show(){


    }

}
