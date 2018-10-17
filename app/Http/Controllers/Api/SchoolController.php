<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\School;

class SchoolController extends Controller
{
    public function create(Request $request)
    {

        $school_dto = $request->only([
            'name',
            'location'
        ]);

        $validator = Validator::make($school_dto, [
            'name'     => 'required|string|max:191',
            'location' => 'required|string|max:191',
        ]);

        if ($validator->fails()) {
            
            $errors = $validator->errors()->all();
            
            return response([
                'message' => "validation failed",
                'errors'  => $errors
            ],400);
        }

        try {
            $school = School::create($school_dto);
            //TODO 생성 요청 사용자가 관리자가 된다.
            
            return response($school,201);
        }catch(\Exception $e){
            return response([
                'message' => "validation failed",
                'errors'  => [$e->getMessage()]
            ],400);
        }
        
    }
}
