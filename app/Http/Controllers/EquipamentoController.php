<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use App\Models\Atribuir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquipamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $equipamentos = Equipamento::orderBy('referencia', 'desc')
            ->join('sectors', 'sector_id', '=', 'sectors.id_sector')
            ->join('equipamento__tipos', 'tipo_id', '=', 'id_eptp')
            ->paginate(5);

        return response()->json($equipamentos, 200);
    }


    public function pesquisarEquipamento($pesquisar)
    {
            if($pesquisar == null ){
                $equipamentos = Equipamento::orderBy('referencia', 'desc')
                ->join('sectors', 'sector_id', '=', 'sectors.id_sector')
                ->join('equipamento__tipos', 'tipo_id', '=', 'id_eptp')
                ->paginate(5);

            return response()->json($equipamentos, 200);
            }else{
                $equipamentos = Equipamento::orderBy('referencia', 'desc')
                ->join('sectors', 'sector_id', '=', 'sectors.id_sector')
                ->join('equipamento__tipos', 'tipo_id', '=', 'id_eptp')
                ->where('codigo_equipamento', 'like', '%' . $pesquisar . '%')
                ->orWhere('referencia', 'like', '%' . $pesquisar . '%')
                ->orWhere('nome_tipo', 'like', '%' . $pesquisar . '%')
                ->orWhere('nome_sector', 'like', '%' . $pesquisar . '%')
                ->paginate(10);
            return response()->json($equipamentos, 200);
            }

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
        /* $request->validate([
            'nome_sector' => 'required|min:3',
            'edificio' => 'required'
        ]);*/

        $equipamento = new Equipamento();
        $equipamento->codigo_equipamento = $request->codigo_equipamento;
        $equipamento->referencia = $request->referencia;
        $equipamento->estado_conputador = $request->estado_conputador;
        $equipamento->necessario = $request->necessario;
        $equipamento->sector_id = $request->sector_id;
        $equipamento->tipo_id = $request->tipo_id;


        if ($equipamento->save()) {
            return response()->json($equipamento, 200);
        } else {
            return response()->json([
                'message' => 'Some error occurred, please try agian',
                'status_code' => 500
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Equipamento  $equipamento
     * @return \Illuminate\Http\Response
     */
    public function show(Equipamento $equipamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Equipamento  $equipamento
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    public function showEquipamento($id)
    {
        $equipamento = Equipamento::
        join('sectors', 'sector_id', '=', 'sectors.id_sector')
        ->join('equipamento__tipos', 'tipo_id', '=', 'id_eptp')
        //->join('atribuirs', 'atribuirs.equip_id', '=', 'id_equipamento')
        //->join('atribuirs', 'atribuirs.equip_id', '=', 'id_eptp')
        ->where('id_equipamento', $id)->first();
        return response()->json($equipamento, 200);
    }



    public function contagem(){
        $actividades = Equipamento::count();
        return response()->json($actividades,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Equipamento  $equipamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Equipamento $equipamento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Equipamento  $equipamento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $equipamento = Equipamento::where('id_equipamento', $id)->delete();

        if ($equipamento) {

            return response()->json([
                'message' => 'Category deleted successfully!',
                'status_code' => 200
            ], 200);
        } else {
            return response()->json([
                'message' => 'Some error occurred, please try again',
                'status_code' => 500
            ], 500);
        }
    }
}
