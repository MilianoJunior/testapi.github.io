<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function __construct(){
        $this->acessos_consecutivos = 0;
        $this->user = null;
    }
    /**
     * method autentic.
     *
     * @return \Illuminate\Http\Response
     */
    public function autentic(Request $request)
    {
        // realizar 3 testes de autenticação
        // 1- email correto: OK , 2- email incorreto: OK, 3- sem email: OK
        // 1- senha errada - Ok, 2- senha correta: ok, 3: sem senha:
        // return response()->json(['nada'=>$request->email],400);
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'senha' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg'=>'todos os campos devem ser preenchidos',
                                     'status' => false,
                                     'data' =>null],400);
        }
        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response()->json(['msg'=>'e-mail não cadastrado',
                                     'status'=>false,
                                     'data'=>null],404);
        }
        if($user->status == 2){
            return response()->json(['msg'=>'Entre em contato com a EngeSEP, muito obrigado!',
                                     'status'=>false,
                                     'data'=>null],404);
        }
        if (!Hash::check($request->senha, $user->senha)){
            $this->register_acess($user, false);
            return response()->json(['msg'=>'senha incorreta, tentativa: ',
                                     'status' => false,
                                     'data'=>$this->acessos_consecutivos],401);
        }
        $token = $user->createToken($user->id)->plainTextToken;
        $this->user = $user;
        $resposta = [
            'msg' => 'Logado com sucesso',
            'status' => true,
            'data' =>$user,
            'token' =>$token,
        ];
        $this->register_acess($user, true);
        return response()->json($resposta,200);

    }
    /**
     * Logout User.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // ok testado
        $user = User::where('email', $request->email)->first();
        if(!$user){
            return response()->json(['msg'=>'Erro do sistema, reinicie o app!',
                                     'user'=>$user->nome],401);
        }
        $user->tokens()->where('tokenable_id', $request->id)->delete();
        return response()->json(['messagem'=>'Logout com sucesso',
                                 'user'=>$user->nome],200);
    }
    /**
     * Usuários logados.
     *
     * @return \Illuminate\Http\Response
     */
    public function users_logged(Request $request)
    {
        $id = Auth::user();
        echo $id;
        echo auth('sanctum')->check();
        // foreach ($users as $token) {
        //     echo $token->tokens();
        // }

        // return response()->json(['usuarios'=>'logados'],200);
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
        $user = User::findOrFail($request->id);
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
        $user = User::create($request->all());
        return response()->json($user,200);
    }
    /**
     * get user from id.
     *
     * @return \Illuminate\Http\Response
     */

    public function reset_password_user(Request $request)
    {
        $user = User::findOrFail($request->id);
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
        $user = User::findOrFail($request->id);
        if ($user){
            $request->senha = Hash::make($request->senha);
            $user->update($request->all());
            $user->save();
            return response()->json('usuário alterado com sucesso',200);
        }
        return response()->json(['id'=>'usuário não está cadastrado'],200);
    }
    /**
     * bloquear user from id.
     *
     * @return \Illuminate\Http\Response
     */

    public function bloquear_user($id)
    {
        $user = User::findOrFail($id);
        if ($user){
            $user->update(['status'=>2]);
            $user->save();
            return response()->json('usuário bloqueado com sucesso',200);
        }
        logout($user);
        return response()->json(['id'=>'usuário não está cadastrado'],200);
    }
    /**
     * desbloquear user from id.
     *
     * @return \Illuminate\Http\Response
     */

    public function desbloquear_user($id)
    {
        $user = User::findOrFail($request->id);
        if ($user){
            $user->update(['status'=>1]);
            $user->save();
            return response()->json('usuário desbloqueado com sucesso',200);
        }
        return response()->json(['id'=>'usuário não está cadastrado'],200);
    }
    /**
     * delete user from id.
     *
     * @return \Illuminate\Http\Response
     */

    public function register_acess($user, $state)
    {
        if ($state){
            $numero_acesso = $user->numero_de_acessos + 1;
            $user->update(['acessos_consecutivos' => 0]);
            $user->update(['numero_de_acessos' => $numero_acesso]);
        }else{
            $tentativas_acesso = $user->acessos_consecutivos + 1;
            $this->acessos_consecutivos = $tentativas_acesso;
            $user->update(['acessos_consecutivos'=>$tentativas_acesso]);
            if ($tentativas_acesso > 5){
                $this->bloquear_user($user->id);
            }
        }

    }



}
