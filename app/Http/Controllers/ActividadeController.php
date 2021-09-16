<?php

namespace App\Http\Controllers;

use App\Models\Actividade;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ActividadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function contagem(){
        $actividades = Actividade::count();
        return response()->json($actividades,200);
     }

    public function visualizarActividades(){
        $actividades = Actividade::
        join('sectors', 'actividades.sector_id', '=', 'sectors.id_sector')
        ->orderBy('actividades.created_at','desc')
        ->paginate(5);
        return response()->json($actividades,200);
    }

    public function showActividade($id){
        $actividade = Actividade::
        join('sectors', 'actividades.sector_id', '=', 'sectors.id_sector')
        ->where('id_actividade', $id);
        return response()->json($actividade, 200);
    }

    public function reomoverActividade($id){
        $actividade = Actividade::where('id_actividade', $id)->delete();
        if($actividade){
            return response()->json([
                'message' => 'Actividade removida com sucesso!',
                'status_code' => 200
            ], 200);
        }else{
            return response()->json([
                'message' => 'Ocorreu um erro ao tentar remover',
                'status_code' => 200
            ], 200);
        }
    }

    public function atualizarActividade(Request $request,$id){

        $actividade = Actividade::where('id_actividade', $id);
        $actividade->descricao = $request->descricao;
        $actividade->data_inicio = $request->data_inicio;
        $actividade->data_termino = $request->data_termino;
        $actividade->sector_id = $request->sector_id;
        $actividade->update();

        if($actividade){
            return response()->json([
                'message' => 'Actividade Finalizada com Sucesso!',
                'status_code' => 200
            ], 200);
        }else{
            return response()->json([
                'message' => 'Ocorreu um erro ao tentar Atualizar',
                'status_code' => 200
            ], 200);
        }
    }

    public function createActividade(Request $request, Actividade $actividade){

        $actividade->descricao = $request->descricao;
        $actividade->data_inicio = $request->data_inicio;
        $actividade->data_termino = $request->data_termino;
        $actividade->sector_id = $request->sector_id;
        $actividade->titulo = $request->titulo;
        $actividade->estado ="pendete";
        $actividade->save();

        if($actividade){
            return response()->json([
                'message' => 'Actividade criada com Sucesso!',
                'status_code' => 200
            ], 200);
        }else{
            return response()->json([
                'message' => 'Ocorreu um erro ao tentar Atualizar',
                'status_code' => 200
            ], 200);
        }

    }


    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Actividade  $actividade
     * @return \Illuminate\Http\Response
     */
    public function show(Actividade $actividade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Actividade  $actividade
     * @return \Illuminate\Http\Response
     */
    public function edit(Actividade $actividade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Actividade  $actividade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Actividade $actividade)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Actividade  $actividade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Actividade $actividade)
    {
        //
    }
}
