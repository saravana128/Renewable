<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use App\Solaruser;
use Hash;


class AuthensController extends Controller
{
     public function index()
    {
    	$response = ['name' => 'Renewable Energy','version' => '1.0'];
    	return response($response,200);
    }
    public function Signup(Request $request)
    {
    	$validator = Validator::make($request->all(0),[
    		's_user_id' => 'required',
    		's_user_name' => 'required',
    		's_password' => 'required|min:8',],
    		[
    		's_user_id.required' => 'User id is required',
    		
    		's_user_name.required' => 'user name is required',
    		  
    		's_password.required' => 'Password is required',
    		's_password.exists' => 'password already exists',
    		's_password.size' => 'password must be atleast 8 letters',]);
    	if($validator->fails())
    	{
    		$response = ['message' => $validator->messages()->all()[0],'validations' => $validator->messages()->all()];
    		return response($response,422);
    	}
    	$inputs = $request->all();
    	$user = Winduser::where('user_name',$inputs['user_name'])->first();
    	if(count($user) == 0)
    	{
    		$new_user = new Winduser;
    		$new_user->user_id = $inputs['user_id'];
    		$new_user->user_name = $inputs['user_name'];
    		$new_user->password = Hash::make($inputs['password']);
    		$new_user->save();
    		$response = ['message' => 'Signup Successful'];
    		return response($response,200);
    	}
    }

    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), 
        	[
  		    's_user_id' => 'required|exists:Winduser,user_id',
  			's_password' => 'required|string',], 
  		[
  			's_user_id.required' => 'User id is required',
  			's_user_id.exists' => 'User id not registered',
  			's_password.required' => 'Password  is required',
  		]);

  		// Stop if validation fails
  		if ($validator->fails())
  		{
  			$response = ['message' => $validator->messages()->all()[0], 'validations' => $validator->messages()->all()];
  			return response($response, 422);
  		}

      // Store all inputs
      $inputs = $request->all();

      // Select the user
      $user = Winduser::where('s_user_id', $inputs['s_user_id'])->first();

      //if (count($user) == 0)
      //{
        //  $response = ['message' => 'Invalid User id'];
          //return response($response, 422);
      //}

      // Verify access code
      //if (!Hash::check($inputs['password'], $user->password))
      //{
        //  $response = ['message' => 'Invalid Password'];
          //return response($response, 422);
      //}

      $response = ['message' => 'login success'];
      return response($response, 200);
    }
    public function cookie(Request $request)
    {
        // Validate data
        $validator = Validator::make($request->all(), [
            's_user_id' => 'required|exists:users,id',
            's_password' => 'required|string',
        ], [
            's_user_id.required' => 'User id is required',
            's_user_id.exists' => 'User does not exist',
            's_password.required' => 'Password is required',
        ]);

        // Stop if validation fails
        if ($validator->fails())
        {
            $response = ['message' => $validator->messages()->all()[0], 'validations' => $validator->messages()->all()];
            return response($response, 422);
        }

        // Store all inputs
        $inputs = $request->all();

        // Fetch the user
        $user = Solaruser::where('id', $inputs['id'])->first();

        // Reject if no user found
        if (count($user) == 0)
        {
            $response = ['message' => 'Invalid User id. Please use a valid one'];
            return response($response, 422);
        }

        // Reject if the credentials is incorrect
        if ($user->s_password != $inputs['s_password'])
        {
            $response = ['message' => 'Invalid password', 'token' => '', 'user' => ''];
            return response($response, 422);
        }

    }
}
