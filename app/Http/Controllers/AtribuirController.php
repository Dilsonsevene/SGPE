<?php

namespace App\Http\Controllers;

use App\Models\Atribuir;
use App\Models\Equipamento;
use Illuminate\Http\Request;

class AtribuirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function alocado($id){

        $problema = Atribuir::join('equipamentos', 'equipamentos.id_equipamento', '=', 'atribuirs.equip_id')
        //->join('sectors','users.sector_id','=','sectors.id_sector')
        ->where('equip_id', $id)->first();
        return response()->json($problema, 200);
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
     * @param  \App\Models\Atribuir  $atribuir
     * @return \Illuminate\Http\Response
     */
    public function show(Atribuir $atribuir)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Atribuir  $atribuir
     * @return \Illuminate\Http\Response
     */
    public function edit(Atribuir $atribuir)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Atribuir  $atribuir
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Atribuir $atribuir)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Atribuir  $atribuir
     * @return \Illuminate\Http\Response
     */
    public function destroy(Atribuir $atribuir)
    {
        //
    }
}
