<?php

namespace App\Http\Controllers;

use App\Models\Solicitacoes;
use Illuminate\Http\Request;
use App\Models\User;

class SolicitacoesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function contagem(){
        $actividades = Solicitacoes::count();
        return response()->json($actividades,200);
    }

    public function index()
    {
        $users = Solicitacoes::join('users', 'users.id', '=', 'solicitacoes.user_id')
            ->join('sectors','users.sector_id','=','sectors.id_sector')
            ->orderBy('solicitacoes.created_at','desc')
            ->paginate(5);
        return response()->json($users, 200);
    }

    public function meu_problema(Request $request)
    {

        $users = Solicitacoes::join('users', 'users.id', '=', 'solicitacoes.user_id')
        ->join('sectors','users.sector_id','=','sectors.id_sector')
        ->orderBy('solicitacoes.created_at','desc')
            ->where('user_id', '=', $request->user()->id)
            ->paginate(5);
        return response()->json($users, 200);
    }

    public function cancelarProblema($id){
        $problema = Solicitacoes::where('id_problema', $id)->delete();
        if ($problema) {

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

    public function visualizarProblema($id){
        $problema = Solicitacoes::join('users', 'users.id', '=', 'solicitacoes.user_id')
        ->join('sectors','users.sector_id','=','sectors.id_sector')
        ->where('id_problema', $id)->first();
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
        $problema = new Solicitacoes();
        $problema->descricao = $request->descricao;
        $problema->status_problema = 'pendente';
        $problema->user_id = $request->user()->id;

        if ($problema->save()) {
            return response()->json($problema, 200);
        } else {
            return response()->json([
                'message' => 'Some error occurred, please try agian',
                'status_code' => 500
            ], 500);
        }
    }

    public function criarproblema(Request $request){

        $problema = new Solicitacoes();
        $problema->descricao = $request->descricao;
        $problema->status_problema = 'pendente';
        $problema->user_id = $request->user()->id;

        if ($problema->save()) {
            return response()->json($problema, 200);
        } else {
            return response()->json([
                'message' => 'Some error occurred, please try agian',
                'status_code' => 500
            ], 500);
        }
    }

    public function resolverproblema(Request $request,$id){

        $problema = Solicitacoes::where('id_problema', $id)->first();

        $problema->status_problema ='resolvido';

        if ($problema->save()) {
            return response()->json($problema, 200);
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
     * @param  \App\Models\Solicitacoes  $solicitacoes
     * @return \Illuminate\Http\Response
     */
    public function show(Solicitacoes $solicitacoes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Solicitacoes  $solicitacoes
     * @return \Illuminate\Http\Response
     */
    public function edit(Solicitacoes $solicitacoes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Solicitacoes  $solicitacoes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Solicitacoes $solicitacoes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Solicitacoes  $solicitacoes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Solicitacoes $solicitacoes)
    {
        //
    }
}
