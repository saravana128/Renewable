<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use App\Solaruser;
use Hash;


class SolarsController extends Controller
{
     public function details(Request $request)
    {
    	$validator=Validator::make($request->all(), [
    	's_user_id' => 'required|exists|integer',
    	's_user_name' => 'required|exists|string',
    	's_password' => 'required|string'] ,
         [
    	's_user_id.required' => 'user id is required',
    	's_user_id.exists' => 'user id already exists',
    	's_user_name.required' => 'user name is required',
    	's_user_name.exists' => 'user already exists',
    	's_password.required' => 'password is required',
    	]);
    	if($validator->fails())
    	{ 
    		$response = ['message' =>$validator->messages()->all()[0],'validations' => $validator->messages()->all()];
    		return response($response,422);
    	}
    	$auth_user = Winduser::where('id',$request->server('PHP_AUTH_USER'))->first();
    	$inputs = $request->all();
    		$auth_user->s_password = Hash::make($inputs['s_password']);
    		$auth_user->s_user_name = $inputs['s_user_name'];
    		$auth_user->s_user_id = $inputs['s_user_id'];
    		$auth_user->save();
    		$response = ['message' => 'details stored successfully'];
    		return response($response,200);
    }

     public function login(Request $request)
    {
    	$validator = Validator::make($request->all(),
            [
    		's_user_id' => 'required',
    		's_password' => 'required'
            ],
            [
    		's_user_id.required' => 'User id is required',
    		's_user_id.exists' => 'User_id does not exists',
    		's_password.required' => 'Enter the password',
            ]);
    	if($validator->fails())
    	{
    	$response = ['msessage' =>$validator->message()->all()[0], 'Validations' => $validator->message()->all()];
    	return response($response,422);
    	}
    	$inputs = $request->all(0);
    	$user = Winduser::where('s_user_id', $inputs['s_user_id'])->first();
    	if(Hash::check($inputs['s_password'], $user->password) ==false)
    	{
    		$response = ['message' => 'Your password does not match'];
    		return response($response,422);

    	}
    	$response = ['message' => 'Successfully loged in'];
        return response($response,200);

    	
    }
}



}
