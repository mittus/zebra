<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenders;
use App\Http\Resources\TendersResource;
use Validator;

class TendersApiController extends Controller
{
    public function index()
    {
        $result = Tenders::orderBy('id', 'desc')->get();
        return BaseController::response(TendersResource::collection($result));
    }

    public function tender($code)
    {
        $result = Tenders::where('code', $code)->get();
        if(!$result->count()) {
            return BaseController::error("Запись с идентификатором $code не обнаружена"); 
        }
        return BaseController::response(TendersResource::collection($result));
    }

    public function filter_tenders($string)
    {
        $result = Tenders::search($string, null, true, true)->orderBy('id', 'desc')->get();

        if(!$result->count()) {
            return BaseController::error('Подходящих записей не обнаружено'); 
        }

        return BaseController::response($result);
    }

    public function add_tender(Request $request) {

        $validate = Validator::make($request->all(), [
            'code' => 'required|integer|unique:tenders,code|regex:/^([0-9]{1,10})$/',
            'number' => 'required|string|max:255',
            'name' => 'required|string|min:3|max:255',
        ]);

        if($validate->fails()) {
            return BaseController::error('Получены некорректные данные', $validate->errors());
        };

        $insertData = [
            'code' => $request->code,
            'number' => $request->number,
            'status' => $request->status ?? '',
            'name' => $request->name,
        ];

        if(Tenders::insert($insertData)) {
            return BaseController::response($insertData, 'Запись успешно добавлена');
        }
    }
}
