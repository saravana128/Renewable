<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use App\Winduser;
use Hash;

class UsersController extends Controller
{
    public function details(Request $request)
    {
    	$validator=Validator::make($request->all(), [
    	'user_id' => 'required|exists|integer',
    	'user_name' => 'required|exists|string',
    	'password' => 'required|string'] ,
         [
    	'user_id.required' => 'user id is required',
    	'user_id.exists' => 'user id already exists',
    	'user_name.required' => 'user name is required',
    	'user_name.exists' => 'user already exists',
    	'password.required' => 'password is required',
    	]);
    	if($validator->fails())
    	{ 
    		$response = ['message' =>$validator->messages()->all()[0],'validations' => $validator->messages()->all()];
    		return response($response,422);
    	}
    	$auth_user = Winduser::where('id',$request->server('PHP_AUTH_USER'))->first();
    	$inputs = $request->all();
    		$auth_user->password = Hash::make($inputs['password']);
    		$auth_user->user_name = $inputs['user_name'];
    		$auth_user->user_id = $inputs['user_id'];
    		$auth_user->save();
    		$response = ['message' => 'details stored successfully'];
    		return response($response,200);
    }
    public function login(Request $request)
    {
    	$validator = Validator::make($request->all(),
            [
    		'user_id' => 'required',
    		'password' => 'required'
            ],
            [
    		'user_id.required' => 'User id is required',
    		'user_id.exists' => 'User_id does not exists',
    		'password.required' => 'Enter the password',
            ]);
    	if($validator->fails())
    	{
    	$response = ['message' =>$validator->message()->all()[0], 'Validations' => $validator->message()->all()];
    	return response($response,422);
    	}
    	$inputs = $request->all(0);
    	$user = Winduser::where('user_id', $inputs['user_id'])->first();
    	if(Hash::check($inputs['password'], $user->password) ==false)
    	{
    		$response = ['message' => 'Your password does not match'];
    		return response($response,422);

    	}
    	$response = ['message' => 'Successfully loged in'];
        return response($response,200);

    	
    }
    public function store_location(Request $request)
    {
        // Validate data
        $validator = Validator::make($request->all(), [
            'lat_from' => 'required|string',
            'lon_from' => 'required|string',
            'lat_to' => 'required|string',
            'lon_to' => 'required|string',
        ], [
            'lat_from.required' => 'current Latitude is required',
            'lon_from.required' => 'current longitude is required',
            'lat_to.required' => 'destination latitude is required',
            'lon_to.required' => 'destination longitude is required',
        ]);

        // Stop if validator fails
        if ($validator->fails())
        {
            $response = ['message' => $validator->messages()->all()[0], 'validations' => $validator->messages()->all()];
            return response($response,422);
        }

        // Authenticate user
        $auth_user = Winduser::where('id', $request->server('PHP_AUTH_USER'))->first();

        // Store all inputs
        $inputs = $request->all();

        // Store the location into the database
        $auth_user->lat_to = $inputs['lat_to'];
        $auth_user->lon_to = $inputs['lon_to'];
        $auth_user->lat_from = $inputs['lat_from'];
        $auth_user->lat_from = $inputs['lon_from'];
        $auth_user->save();

        // Return a success response
        $response = ['message' => 'Location stored successfully'];
        return response($response, 200);
    }

}
