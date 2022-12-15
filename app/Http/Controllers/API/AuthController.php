<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class AuthController extends BaseController
{

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'mot_de_passe' => 'required',
            'phone' => 'required',
            'typeuser' => 'required',
            'link_img' => 'required',
            'num_contribuable' => 'required',
            'typeentreprise' => 'required',
            'heure_open' => 'required',
            'heure_deliver' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = new User();

        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = $input['password'];
        $user->mot_de_passe = $input['mot_de_passe'];
        $user->phone = $input['phone'];
        $user->typeuser = $input['typeuser'];
        $saveUser = $user->save();

        $entreprise = new Entreprise();

        $entreprise->iduser = $user->id;
        $entreprise->link_img = $input['link_img'];
        $entreprise->num_contribuable = $input['num_contribuable'];
        $entreprise->typeentreprise = $input['typeentreprise'];
        $entreprise->heure_open = $input['heure_open'];
        $entreprise->heure_deliver = $input['heure_deliver'];
        $saveEntreprise = $entreprise->save();

        if ($saveUser && $saveEntreprise) {
            $success['token'] =  $user->createToken('BabdraEatsClient')->plainTextToken;
            $success['id'] =  $user->id;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User register successfully.');
        } else {
            return $this->sendError('Registration Error.', '$saveUser->errors()$saveEntreprise->errors()');
        }

    }



    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = User::where('email', $request->email)->first();
            if($user->typeuser == 'entreprise'){
                $success['token'] =  $user->createToken('BabdraEatsClient')->plainTextToken;
                $success['id'] =  $user->id;
                $success['name'] =  $user->name;

                return $this->sendResponse($success, 'User login successfully.');
            }else{
                return $this->sendError("Vous n'êtes pas une entreprise !", ['error'=>"Vous n'êtes pas une entreprise !"]);
            }
        }
        else{
            return $this->sendError('User not recognized !', ['error'=>'User not recognized !']);
        }
    }




    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function signin(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'mot_de_passe' => 'required',
            'phone' => 'required',
            'typeuser' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = new User();

        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = $input['password'];
        $user->mot_de_passe = $input['mot_de_passe'];
        $user->phone = $input['phone'];
        $user->typeuser = $input['typeuser'];
        $saveUser = $user->save();


        if ($saveUser) {
            $success['token'] =  $user->createToken('BabdraEatsClient')->plainTextToken;
            $success['id'] =  $user->id;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User register successfully.');
        } else {
            return $this->sendError('Registration Error.', '$saveUser->errors()$saveEntreprise->errors()');
        }

    }

    /**
     * Auth api
     *
     * @return \Illuminate\Http\Response
     */
    public function auth(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = User::where('email', $request->email)->first();
            if($user->typeuser == 'client'){
                $success['token'] =  $user->createToken('BabdraEatsClient')->plainTextToken;
                $success['id'] =  $user->id;
                $success['name'] =  $user->name;

                return $this->sendResponse($success, 'User login successfully.');
            }else{
                return $this->sendError("Vous n'êtes pas un client !", ['error'=>"Vous n'êtes pas un client !"]);
            }

        }
        else{
            return $this->sendError('User not recognized !', ['error'=>'User not recognized !']);
        }
    }
}
