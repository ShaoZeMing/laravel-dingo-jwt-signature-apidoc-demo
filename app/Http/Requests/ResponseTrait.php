<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

trait ResponseTrait
{


    protected function failedValidation(Validator $validator)
    {
        //获得错误
        $errors = $validator->errors()->toArray();
        //如果有错误就获取到所有错误
        if ($errors) {
            $errors = array_first($errors);
            //抛出一个HttpResponseException异常,responseJson是我封装的response()->json()方法而已
            throw new HttpResponseException($this->responseJson(2002, array_first($errors)));
        }
    }


    public function responseJson($error, $msg, $data = null)
    {
        $output = [
            'error' => $error,
            'msg' => $msg,
        ];
        if (!is_null($data)) {
            $output['data'] = $data;
        }
        return \response()->json($output);
    }


}
