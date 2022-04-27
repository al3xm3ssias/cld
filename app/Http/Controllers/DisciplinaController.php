<?php

namespace App\Http\Controllers;

use App\Models\Disciplinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DisciplinaController extends Controller
{
    //

    public function index(){

        $disciplinas = DB::select('select * from disciplinas where id > 2');

        return view('disciplina.index', ['disciplinas' => $disciplinas]);


        /*
        $disciplinas = new Disciplinas();

        return view('disciplina.index', ['disciplinas' => $disciplinas->select('disciplinas.*')
        ->get()]); */

    }

    public function create(){

        $disciplina = new Disciplinas();
        return view('disciplina.create', compact('disciplina'));

    }

    public function edit($id){

        $disciplina = Disciplinas::find($id);

        return view('disciplina.edit', compact('disciplina'));

    }

    public function show($id){

    }


    public function store(Request $request){

        request()->validate(Disciplinas::$rules);

            $disciplinas = Disciplinas::create($request->all());

            return redirect()->route('disciplinas.index')
                ->with('success', 'Laboratório criado com sucesso.');

    }
    public function update(Request $request, Disciplinas $disciplina){

        request()->validate(Disciplinas::$rules);

        $disciplina->update($request->all());

        return redirect()->route('disciplinas.index')->with('success','Disciplina editada com sucesso!!');

    }

    public function destroy(Request $request)
    {
        $id = $request->disciplina_id;

        //$id = Laboratorio::find($id);

        //$id = DB::table('laboratorio')->select('laboratorio.*')->where('laboratorio.id', '=', $id)->get();

        $SQL = DB::table('reserva')->select('reserva.*')->where('reserva.disciplina_id', '=', $id)->count();


       // $reservaLab = $id;

        if ($SQL == 0 ) {
            $reservaLab = Disciplinas::find($id)->delete();
            return redirect()->route('disciplinas.index')->with('success','Disciplina excluida com sucesso.');
        }elseif ($SQL != 0 ){
            return redirect()->route('disciplinas.index')->with('error','Existe reservas para esta disciplina.');
        }

    }
}


