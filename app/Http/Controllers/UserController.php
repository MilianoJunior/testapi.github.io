<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{
    /**
     * method autentic.
     *
     * @return \Illuminate\Http\Response
     */
    public function autentic(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        // $user = User::where('email', $request->email)->first()->get();
        // $token_a = $user->createToken()->plainTextToken;
        // echo $token_a;
        // Hash::check(Hash::make($request->senha), $user->senha)
        if($user){
            return response()->json(['1'=>$user->senha,
                                     '2'=>Hash::make($request->senha),
                                     '3'=>Hash::check($request->senha, $user->senha)],200);
        }
        if (! $user) {
            return response()->json($user,200);
        }
        // $token = $user->createToken('engesep')->plainTextToken;
        return response()->json('desconectado',401);
        // return $token;
        // foreach ($user as $value) {
        //     echo $value.'<br/>';
        // }
        // return response()->json('login',200);
    }
    /**
     * Logout User.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $user->tokens()->where('id', $request->id)->delete();
        return response()->json($user,200);
    }
    /**
     * Display a listing all users.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_users()
    {
        $users = User::all();
        return response()->json($users,200);
    }
    /**
     * get user from id.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_user(Request $request)
    {
        $user = User::find($request->id);
        if ($user){
            return response()->json($user,200);
        }
        return response()->json(['id'=>'usuário não está cadastrado'],200);
    }
    /**
     * get user from id.
     *
     * @return \Illuminate\Http\Response
     */

    public function create_user(Request $request)
    {
        $flight = User::create([
            'name' => 'London to Paris',
        ]);
        return response()->json($users,200);
    }
    /**
     * get user from id.
     *
     * @return \Illuminate\Http\Response
     */

    public function reset_password_user(Request $request)
    {
        $user = User::find($request->id);
        if ($user){
            $user->senha = Hash::make($request->senha);
            $user->save();
            return response()->json('senha alterada com sucesso',200);
        }
        return response()->json(['id'=>'usuário não está cadastrado'],200);
    }
    /**
     * get user from id.
     *
     * @return \Illuminate\Http\Response
     */

    public function update_user(Request $request)
    {
        foreach ($request as $value) {
            echo $value;
            // $user = User::where('id', $request->id)
        };

                            // ->update(['delayed' => 1]);
        // if ($user){

        //     return response()->json($user,200);
        // }
        // return response()->json(['id'=>'usuário não está cadastrado'],200);
    }
    /**
     * get user from id.
     *
     * @return \Illuminate\Http\Response
     */

    public function delete_user(Request $request)
    {
        return response()->json($users,200);
    }

}
