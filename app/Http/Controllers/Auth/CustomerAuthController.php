<?php

namespace App\Http\Controllers\Auth;
use App\CentralLogics\Helpers;

use App\Http\Controllers\Controller;

use App\Models\Pays;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class CustomerAuthController extends Controller
{




     public function login(Request $request)
    {

        if($request->email!=null){


            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required|min:6'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => Helpers::error_processor($validator)], 403);
            }

            $data = [
                'email' => $request->email,
                'password' => $request->password
            ];


        }else{

            $validator = Validator::make($request->all(), [
                'telephone' => 'required',
                'password' => 'required|min:6'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => Helpers::error_processor($validator)], 403);
            }

            $data = [
                'telephone' => $request->telephone,
                'password' => $request->password
            ];


        }


//        $data = [
//            'phone' => $request->phone,
//            'password' => $request->password
//        ];
//         return response()->json(['a'=>$data],200);
        if (auth()->attempt($data)) {
            //auth()->user() is coming from laravel auth:api middleware
            $token = auth()->user()->createToken('TalentCustomerAuth')->plainTextToken;
//            if(!auth()->user()->status)
//            {
//                $errors = [];
//                array_push($errors, ['code' => 'auth-003', 'message' => trans('messages.your_account_is_blocked')]);
//                return response()->json([
//                    'errors' => $errors
//                ], 403);
//            }

            return response()->json(['token' => $token, 'is_phone_verified'=>auth()->user()->is_phone_verified], 200);
        }
        else {
            $errors = [];
            array_push($errors, ['code' => 'auth-001', 'message' => 'Connexion impossible, veuillez vérifier vos informations de connexion.']);
            return response()->json([
                'errors' => $errors
            ], 401);
        }
    }

//nom: nom  ,
//prenom: prenom  ,
//email:  email  ,
//telephone: telephone  ,
//password: password ,
//pays: pays ,
//genre: genre

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|unique:users',
            'telephone' => 'required|unique:users',
            'password' => 'required|min:6',
        ], [
            'nom.required' => 'Le champ prénom est obligatoire.',
            'prenom.required' => 'Le champ prénom est obligatoire.',
            'email.required' => 'Le champ email est obligatoire.',
            'telephone.required' => 'Le champ telephone est obligatoire.',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'data' =>[
                'nom' => 'Le champ prénom est obligatoire.',
                'prenom' => 'Le champ prénom est obligatoire.',
                'email' => 'Le champ email est obligatoire.',
                'telephone' => 'Le champ telephone est obligatoire.',
                ]], 422);
//            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $user = User::create([
            'name' => $request->nom,
            'first_name' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => bcrypt($request->password),
            'sexe' =>  $request->genre,
            'role' => "user",
            'pay_id' =>  $request->pays,
        ]);

        // Send email verification
        $user->sendEmailVerificationNotification();

      $token = $user->createToken('TalentCustomerAuth')->plainTextToken;
//        $token="test-token";


        return response()->json(['token' => $token,'is_phone_verified' => 0, 'phone_verify_end_url'=>"api/auth/verify-phone" ], 200);
    }


    public function getPays(Request $request){

         $pays=Pays::all();
         return response()->json($pays);

    }

}
