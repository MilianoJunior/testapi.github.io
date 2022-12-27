<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;



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
        // return response()->json('oi',200);
        $val = $this->validator_inputs($request, ['email' => 'required|email',
                                                  'senha' => 'required'],
                                                  'todas as entradas devem ser preenchidas.');
        if(!$val['status']){
            return $this->resposta_padrao(true,
                                          $this->response_code(10),
                                          $val);
        }
        $user = User::where('email', $request->email)->first();
        if(!$user){
            return $this->resposta_padrao(true,
                                          $this->response_code(6),
                                          null);
        }
        if($user->status == 2){
            return $this->resposta_padrao(true,
                                          $this->response_code(4),
                                          null);
        }
        if (!Hash::check($request->senha, $user->senha)){
            $this->register_acess($user, false);
            return $this->resposta_padrao(true,
                                          $this->response_code(3),
                                          $this->acessos_consecutivos);
        }
        $token = $user->createToken($user->id)->plainTextToken;
        $this->user = $user;
        $this->register_acess($user, true);
        return $this->resposta_padrao(false,
                                      $this->response_code(1),
                                      ['token'=>$token,'user'=>$user]);
    }
    /**
     * Usuários logados.
     *
     * @return \Illuminate\Http\Response
     */
    public function users_logged(Request $request)
    {
        // status: 1 ativado, 2 bloqueado, 3 logado
        try{
            $users = User::all();
            $data = [];
            foreach($users as $user){
                if($user->status == 3){
                    $data[$user->nome] = 'logado';
                }
            }
            return $this->resposta_padrao(false,
                                          $this->response_code(1),
                                          $data);
        }catch (Exception $e) {
            return $this->resposta_padrao(true,
                                          $this->response_code(11),
                                          $e);
        }
    }
    /**
     * Display a listing all users.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_users()
    {
        try{
            $users = User::all();
            $data = [];
            foreach($users as $user){
                $data[$user->nome] = true;
            }
            return $this->resposta_padrao(false,
                                          $this->response_code(1),
                                          $data);
        }catch (Exception $e) {
            return $this->resposta_padrao(true,
                                          $this->response_code(11),
                                          $e);
        }
    }
    /**
     * get user from id.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_user(Request $request)
    {
        $val = $this->validator_inputs($request, ['id' => 'required'], 'A variável id deve ser informada.');
        if(!$val['status']){
            return $this->resposta_padrao(true,
                                          $this->response_code(10),
                                          $val);
        }
        try{
            $user = $request->user();
            if (!$user){
                return $this->resposta_padrao(true,
                                                $this->response_code(6),
                                                null);
            }
            return $this->resposta_padrao(false,
                                            $this->response_code(1),
                                            $user);
        }catch (Exception $e) {
            return $this->resposta_padrao(true,
                                          $this->response_code(11),
                                          $e);
        }
    }
    /**
     * get user from id.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_user(Request $request)
    {
        $val = $this->validator_inputs($request, ['nome' => 'required',
                                                  'telefone' => 'required',
                                                  'nascimento' => 'required',
                                                  'email' => 'required|email',
                                                  'senha' => 'required',
                                                  'imagem' => 'required',
                                                  'usina' => 'required',
                                                  'status' => 'required'],
                                                  'todas as entradas devem ser preenchidas.');
        if(!$val['status']){
            return $this->resposta_padrao(true,
                                          $this->response_code(10),
                                          $val);
        }
        if (User::where('email', $request->email)->first()){
            return $this->resposta_padrao(true,
                                          $this->response_code(8),
                                          $val);
        }
        try{
            $new_user = new User;
            $new_user->nome = $request->nome;
            $new_user->telefone = $request->telefone;
            $new_user->nascimento = $request->nascimento;
            $new_user->email = $request->email;
            $new_user->senha = Hash::make($request->senha);
            $new_user->imagem = $request->imagem;
            $new_user->usina = $request->usina;
            $new_user->status = $request->status;
            $new_user->ultimo_acesso = date('Y-m-d H:i:s');
            $new_user->numero_acessos = 1;
            $new_user->acessos_consecutivos = 1;
            $new_user->remember_token =  Str::random(10);
            $new_user->save();
            return $this->resposta_padrao(false,
                                          $this->response_code(2),
                                          $new_user);
        }catch (Exception $e) {
            return $this->resposta_padrao(true,
                                          $this->response_code(11),
                                          $e);
        }
    }
    /**
     * get user from id.
     *
     * @return \Illuminate\Http\Response
     */
    public function reset_password_user(Request $request)
    {
        $val = $this->validator_inputs($request, ['senha' => 'required',
                                                  'id'=>'required'],'todas as entradas devem ser preenchidas.');
        if(!$val['status']){
            return $this->resposta_padrao(true,
                                          $this->response_code(10),
                                          $val);
        }
        try{
            $user = $request->user();
            if (!$user){
                return $this->resposta_padrao(true,
                                              $this->response_code(6),
                                              null);
            }
            $user->senha = Hash::make($request->senha);
            $user->save();
            return $this->resposta_padrao(false,
                                          $this->response_code(2),
                                          $user);
        }catch (Exception $e) {
            return $this->resposta_padrao(true,
                                          $this->response_code(11),
                                          $e);
        }
    }
    /**
     * Logout User.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $val = $this->validator_inputs($request, ['email' => 'required'],'todas as entradas devem ser preenchidas.');
        if(!$val['status']){
            return $this->resposta_padrao(true,
                                          $this->response_code(10),
                                          $val);
        }
        try{
            // $user = User::where('email', $request->email)->first();
            $user = $request->user();
            if(!$user){
                return response()->json('email não existe',404);
                return $this->resposta_padrao(true,
                                            $this->response_code(6),
                                            null);
            }
            if($user->id != auth()->user()->id){
                return $this->resposta_padrao(true,
                                              $this->response_code(4),
                                              null);
            }
            $user->tokens()->where('tokenable_id', $user->id)->delete();
            $user->update(['status' => 1]);
            return $this->resposta_padrao(false,
                                          $this->response_code(1),
                                          null);
        }catch (Exception $e) {
            return $this->resposta_padrao(true,
                                            $this->response_code(11),
                                            $e);
        }
    }
    /**
     * get user from id.
     *
     * @return \Illuminate\Http\Response
     */

    public function update_user(Request $request)
    {
        $val = $this->validator_inputs($request, ['id' => 'required','todas as entradas devem ser preenchidas.']);
        if(!$val['status']){
            return $this->resposta_padrao(true,
                                          $this->response_code(10),
                                          $val);
        }
        try{
            // $user = User::find($request->id);
            $user = $request->user();
            if (!$user){
                return $this->resposta_padrao(true,
                                            $this->response_code(6),
                                            null);
            }
            if($request->senha){
                $request->senha = Hash::make($request->senha);
            }
            $user->update($request->all());
            $user->save();
            return $this->resposta_padrao(false,
                                          $this->response_code(1),
                                          $user);
        }catch (Exception $e) {
            return $this->resposta_padrao(true,
                                          $this->response_code(11),
                                          $e);
        }
    }
    /**
     * bloquear user from id.
     *
     * @return \Illuminate\Http\Response
     */

    public function bloquear_user($id)
    {
        try{
            $user = User::findOrFail($id);
            if (!$user){
                return $this->resposta_padrao(true,
                                              $this->response_code(6),
                                              null);
            }
            $user->update(['status'=>2]);
            $user->save();
            return $this->resposta_padrao(false,
                                          $this->response_code(1),
                                          $user);
        }catch (Exception $e) {
            return $this->resposta_padrao(true,
                                          $this->response_code(11),
                                          $e);
        }
    }
    /**
     * desbloquear user from id.
     *
     * @return \Illuminate\Http\Response
     */

    public function desbloquear_user($id)
    {
        try{
            $user = User::find($id);
            if (!$user){
                return $this->resposta_padrao(true,
                                              $this->response_code(6),
                                              null);
            }
            $user->update(['status'=>1]);
            $user->save();
            return $this->resposta_padrao(false,
                                          $this->response_code(1),
                                          $user);
        }catch (Exception $e) {
            return $this->resposta_padrao(true,
                                          $this->response_code(11),
                                          $e);
        }
    }
    /**
     * register access api.
     *
     * @return \Illuminate\Http\Response
     */
    public function register_acess($user, $state)
    {
        if ($state){
            $numero_acesso = $user->numero_de_acessos + 1;
            $user->update(['acessos_consecutivos' => 0]);
            $user->update(['numero_de_acessos' => $numero_acesso]);
            $user->update(['status' => 3]);
        }else{
            $tentativas_acesso = $user->acessos_consecutivos + 1;
            $this->acessos_consecutivos = $tentativas_acesso;
            $user->update(['acessos_consecutivos'=>$tentativas_acesso]);
            if ($tentativas_acesso > 5){
                $this->bloquear_user($user->id);
            }
        }
    }
    /**
     * validator access api.
     *
     * @return \Illuminate\Http\Response
     */
    public function validator_inputs($request, $rules, $msg)
    {
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return ['msg'=>$msg,
                    'status' => false,
                    'rules' => $rules,
                    'request' => $request->all(),
                    'data' =>$validator->fails()];
        }
        return ['msg'=>'ok',
                'status' => true,
                'rules' => $rules,
                'request' => $request->all(),
                'data' =>$validator->fails()];
    }
     /**
     * pattern response api.
     *
     * @return \Illuminate\Http\Response
     */
    public function resposta_padrao($erro, $response, $data){
        return response()->json(['erro'=>$erro,
                                 'response'=>$response,
                                 'data'=>$data],$response["status_code"]);
    }

    public function response_code($index){
        $responses = [  1 => [
                                "message"=>"O recurso solicitado foi processado e retornado com sucesso.",
                                "status_code"=> 200,
                             ],
                        2 => [
                                "message"=>"O recurso informado foi criado com sucesso.",
                                "status_code"=> 201,
                             ],
                        3 => [
                                "message"=>"A senha não foi informada corretamente, são permetidos 5 tentativas consecutivas.",
                                "status_code"=> 401,
                            ],
                        4 => [
                                "message"=>"A conta foi desativada, entre em contato com a EngeSEP.",
                                "status_code"=> 402,
                             ],
                        5 => [
                                "message"=>"As configurações de perfil de acesso não permitem a ação desejada.",
                                "status_code"=> 403,
                             ],
                        6 => [
                                "message"=>"O recurso solicitado ou o endpoint não foi encontrado.",
                                "status_code"=> 404,
                            ],
                        7 => [
                                "message"=>"O formato enviado não é aceito.",
                                "status_code"=> 406,
                             ],
                        8 => [
                                "message"=>"A requisição foi recebida com sucesso, porém o e-mail está em uso.",
                                "status_code"=> 422,
                             ],
                        9 => [
                                "message"=>"O limite de requisições foi atingido.",
                                "status_code"=> 429,
                            ],
                        10 => [
                                "message"=>"Não foi possível interpretar a requisição. Verifique a sintaxe das informações enviadas.",
                                "status_code"=> 400,
                             ],
                        11 => [
                                "message"=>"Ocorreu uma falha na plataforma da EngeSEP. Por favor, entre em contato com o atendimento",
                                "status_code"=> 500,
                            ],
                        ];

        return $responses[$index];
    }
}
