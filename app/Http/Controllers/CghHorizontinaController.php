<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CghHorizontina;

class CghHorizontinaController extends Controller
{
    /**
     * get user from id.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_dados()
    {
        $data = ChhHorizontina::all();
        if ($data){
            return response()->json($data,200);
        }
        return response()->json(['data'=>'não existem dados cadastrados'],200);
    }
    /**
     * get user from id.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_find(Request $request)
    {
        $user = ChhHorizontina::where($request->colunas)
                                ->orderBy('id')
                                ->take($request->qtd)
                                ->get();
        if ($user){
            return response()->json($user,200);
        }
        return response()->json(['id'=>'usuário não está cadastrado'],200);
    }
}
