<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function loadUsers()
    {
        $users = User::join('sectors', 'sector_id', '=', 'sectors.id_sector')
            ->paginate(5);
        return response()->json($users, 200);
    }

    public function contagem(){
        $actividades = User::count();
        return response()->json($actividades,200);
     }

    public function permissao(Request $request,$id){

        $user = User::where('id', $id)->first();
        $user->role = $request->role;

        if($user->save()){
            return response()->json([
                'message' => 'Atribuido com sucesso !',
                'status_code' => 200
            ], 200);
        }else{
            return response()->json([
                'message' => 'Ocorreu um erro ao tentar Atualizar',
                'status_code' => 200
            ], 200);
        }
    }

    public function atualizarUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|min:3',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->role = $request->role;

        if ($user->save()) {
            return response()->json($user, 200);
        } else {
            return response()->json([
                'message' => 'Ocorreu Algum tente Novamente',
                'status_code' => 500
            ], 500);
        }
    }

    public function showUser($id){
        $user = User::where('id', $id)->first();
        return response()->json($user, 200);
    }

    public function meuperfil(Request $request){
        $user = User::
        join('sectors','users.sector_id','=','sectors.id_sector')
        ->where('id', $request->user()->id)->first();
        return response()->json($user, 200);
    }

    public function atulizarmeuperfil(Request $request){
       /* $user = User::where('id', $request->user()->id);

        $user->name = $request->name;
        $user->pass = $request->name;
        $user->name = $request->name;
        $user->name = $request->name;

        return response()->json($user, 200);*/
    }
}
