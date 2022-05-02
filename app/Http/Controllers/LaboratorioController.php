<?php

namespace App\Http\Controllers;

use App\Http\Requests\LaboratorioRequest;
use App\Models\Laboratorio;
use App\Models\Reserva;

use App\Models\TipoLaboratorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaboratorioController extends Controller
{
    public function index(Laboratorio $model)
    {
        $laboratorios = Laboratorio::paginate();
        return view('laboratorio.index', compact('laboratorios'))
        ->with('i', (request()->input('page', 1) - 1) * $laboratorios->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $laboratorio = new Laboratorio();
        return view('laboratorio.create', compact('laboratorio'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request  $request)
    {
        request()->validate(Laboratorio::$rules);

            $laboratorios = Laboratorio::create($request->all());

            return redirect()->route('laboratorios.index')
                ->with('success', 'Laboratório criado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function edit($id)
    {
        $laboratorio = Laboratorio::find($id);

        return view('laboratorio.edit', compact('laboratorio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Laboratorio $laboratorio)
    {
        request()->validate(Laboratorio::$rules);

        $laboratorio->update($request->all());

        return redirect()->route('laboratorios.index')->withStatus(__('Laboratório Editado com sucesso!!'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->laboratorio_id;

        //$id = Laboratorio::find($id);

        //$id = DB::table('laboratorio')->select('laboratorio.*')->where('laboratorio.id', '=', $id)->get();

        $SQL = DB::table('reserva')->select('reserva.*')->where('reserva.laboratorio_id', '=', $id)->count();


       // $reservaLab = $id;

        if ($SQL == 0 ) {
            $reservaLab = Laboratorio::find($id)->delete();
            return redirect()->route('laboratorios.index')->with('success','Laboratório Excluido com sucesso.');
        }elseif ($SQL != 0 ){
            return redirect()->route('laboratorios.index')->with('error','Existe reservas neste laboratorio.');
        }



    }
}
