<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitanteRequest;
use App\Models\Solicitante;
use App\Models\TipoSolicitante;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;

class SolicitanteController extends Controller
{
    //
    public function index(Solicitante $model)
    {

        $solicitantes = new Solicitante();

        return view('solicitante.index', ['solicitantes' => $solicitantes->select('solicitantes.*',  'tipo_solicitante.nome as nomeTipo')
        ->join('tipo_solicitante', 'solicitantes.tipo_solicitante_id', '=', 'tipo_solicitante.id')->get()]);

    }







    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipoSolicitante = TipoSolicitante::all();

        $solicitante = new Solicitante();

        return view('solicitante.create', ['tipoSolicitante'=> $tipoSolicitante, 'solicitante' => $solicitante]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SolicitanteRequest $request ,Solicitante $model )
    {
        request()->validate(Solicitante::$rules);

        $model->create($request->all());

        return redirect(route('solicitante.index'))->withStatus(__('Solicitante criado com sucesso.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Solicitante  $solicitante
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Solicitante  $solicitante
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $solicitante = Solicitante::find($id);
        $tipoSolicitante = TipoSolicitante::all();

        return view ('solicitante.edit', ['solicitante'=>$solicitante, 'tipoSolicitante'=> $tipoSolicitante]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Solicitante  $solicitante
     * @return \Illuminate\Http\Response
     */
    public function update(SolicitanteRequest $request, Solicitante $solicitante)
    {
        $solicitante->update($request->all());

        return redirect(route('solicitante.index'))->withStatus(__('Dados de Solicitante Alterado com sucesso!'));
    }

    public function destroy(Request $request){

        $id = $request->solicitante_id;

        $SQL = DB::table('reserva')->select('reserva.*')->where('reserva.solicitante_id', '=', $id)->count();

        if ($SQL == 0 ) {
            $reservaLab = Solicitante::find($id)->delete();
            return redirect()->route('solicitante.index')->with('success','Solicitante Excluido com sucesso.');
        }elseif ($SQL != 0 ){
            return redirect()->route('solicitante.index')->with('error','Este cadastro possui agendamentos.');
        }

    }

    public function gerarcracha($id){

        $data = Solicitante::find($id);

        $qrcode =$data->ra;

        $pdf = Pdf::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);

        $pdf = Pdf::loadView('solicitante.cracha',compact('qrcode'));




        return $pdf->stream($data->nome.'.pdf');

   }
}
