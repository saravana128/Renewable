<?php

namespace App\Http\Middleware;

use Closure;

class Authentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
         $request->request->add(['user_id' => $request->server('PHP_AUTH_USER')]);
        $request->request->add(['password' => $request->server('PHP_AUTH_PW')]);

        // Validate the request
        $validator = Validator::make($request->all(), [
          'user_id' => 'required',
          'password' => 'required',
        ], [
          'user_id.required' => 'Missing ID',
          'password.required' => 'Missing password'
        ]);

        // If validator fails
        if ($validator->fails())
        {
          $validation = $validator->messages()->all();
          $response['message'] = 'Authentication error';
          $response['validation'] = $validator;
          return response($response, 422);
        }

        // Store all inputs
        $inputs = $request->all();

        // Get the user count
        $user_count = User::where('id', $inputs['user_id'])->where('password', $inputs['password'])->count();

        // If there are no user
        if ($user_count == 0)
        {
          $response['message'] = 'You are not authorised to make this action';
          return response($response, 403);
        }
        return $next($request);
    }
}
