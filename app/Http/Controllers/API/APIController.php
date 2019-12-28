<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Rest\RestResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class APIController extends Controller
{
    use RestResponse;

    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        return Validator::make($request->all(), $rules, $messages, $customAttributes);
    }

}
