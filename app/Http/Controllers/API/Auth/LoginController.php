<?php


namespace App\Http\Controllers\API\Auth;


use App\Http\Controllers\API\APIController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends APIController
{

    public function __construct()
    {

    }


    /**
     * perform login action
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */

    public function login(Request $request)
    {
        $credentials = $request->only('email','password');
        if (!$token = Auth::attempt($credentials) ){
            return $this->respondUnauthorized('Sorry, credentials not correct');
        }
        return $this->token($token);
    }

    /**
     * Refresh user token before it expires
     * @return
     */
    public function refresh()
    {
        $token = Auth::refresh();
        return $this->token($token);
    }

    /**
     * get logged user profile
     *
     */
    public function me()
    {

        Auth::logout();
        return $this->respondWithSuccess('Logout successfully.');
    }

    /**
     * Send a reset password link to user
     */
    public function forgotPassword(Request $request)
    {
        $user = User::query()->where('email', $request->email);
        if ($user){

        }

    }

    /**
     * Reset user password
     * @param Request $request
     * @param $code
     */
    public function resetPassword(Request $request, $code)
    {

    }

    /**
     * Change Password
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function changePassword(Request $request)
    {

        $validate = $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);
        if ($validate->fails()){
            return $this->respondUnprocessableEntity('Input errors.',
                $validate->errors());
        }
        $user = Auth::user();
        if (!Hash::check($request->old_password, $user->password)){
            return $this->respondWithError('Password not correct.');
        }
        //update password
        $user->password = Hash::make($request->new_password);
        $user->save();
        return $this->respondWithSuccess('Password updated successfully.');

    }

    /**
     * Return user details with access token
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function token($token)
    {
        return $this->respondWithSuccess('Login Successfully',[
            'access_token' => $token,
            'token_type' => 'bearer',
            'account' => Auth::user()
        ]);
    }
}
