<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AksesPintuRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required',
            'id_rfid' => 'required',
            'pin' => 'required|same:pin_confirmation',
            'pin_confirmation' => 'required',
        ];
    }
}
