<?php

namespace App\Http\Controllers\Api\V1\BackingServices;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BackingServices\Telephony\Moizvonki;
use Validator;

class TelephonyController extends Controller
{
    protected $telephony = "";

    public function __construct(Moizvonki $telephony)
    {
        $this->telephony = $telephony;
    }

    public function getCallsList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from_date' => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $data = $this->telephony->GetCallsList($request->all());
        return response()->json($data, $data['statusCode']);
    }

    public function createEmployee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_user_name' => 'required|email',
            'employee_password' => 'required|string|min:6',
            'employee_display_name' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $data = $this->telephony->createEmployee($request->all());
        return response()->json($data, $data['statusCode']);
    }

    public function activateEmployee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_user_name' => 'required_without:employee_id|email',
            'employee_id' => 'required_without:employee_user_name|integer'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $data = $this->telephony->activateEmployee($request->all());
        return response()->json($data, $data['statusCode']);
    }

    public function deleteEmployee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_user_name' => 'required_without:employee_id|email',
            'employee_id' => 'required_without:employee_user_name|integer'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $data = $this->telephony->deleteEmployee($request->all());
        return response()->json($data, $data['statusCode']);
    }

    public function listEmployee(Request $request)
    {
        $data = $this->telephony->listEmployee($request->all());
        return response()->json($data, $data['statusCode']);
    }

    public function listGroup(Request $request)
    {
        $data = $this->telephony->listGroup($request->all());
        return response()->json($data, $data['statusCode']);
    }
}
