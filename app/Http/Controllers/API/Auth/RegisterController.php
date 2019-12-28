<?php


namespace App\Http\Controllers\API\Auth;


use App\Http\Controllers\API\APIController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends APIController
{

    public function __construct()
    {

    }

    /**
     * Register a new user account
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {

        $validate = $this->validate($request,[
           'name' => 'required|min:3',
           'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);
        if ($validate->fails()){
            return $this->respondUnprocessableEntity('Input Error.',
                $validate->errors());
        }
        $user = User::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verification_code' => Str::random(32)
        ]);
        //implement notification
        //$user->notify('')
        return $this->respondWithSuccess('User created successfully.', $user);
    }


    /** Verify email address through code sent to the email when registering
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyEmail($code)
    {
        $user = User::query()->where('verification_code', $code)->first();
        if ($user){
            if (is_null($user->email_verified_at)){
                $user->email_verified_at =  now();
                $user->save();
                return $this->respondWithSuccess('Account verified successfully', $user);
            }
            return $this->respondWithSuccess('Email verified already.', $user);

        }

        return $this->respondNotFound('No account found.');
    }

    /**
     * Resend verification email
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendEmailVerification($id)
    {

        $user = User::query()->find($id);
        if ($user){
            //implement notification
            //$user->notify();
            return $this->respondWithSuccess('Email sent successfully.');
        }

        return $this->respondNotFound('Account not found.');

    }
}
