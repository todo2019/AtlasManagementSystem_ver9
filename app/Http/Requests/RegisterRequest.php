<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
     public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
                'over_name' => 'required|string|max:10',
                'under_name' => 'required|string|max:10',
                'over_name_kana' => 'required|string|regex:/^[ァ-ヶー]+$/u|max:30',
                'under_name_kana' => 'required|string|regex:/^[ァ-ヶー]+$/u|max:30',
                'mail_address' => 'required|email|unique:users,mail_address|max:100',
                'sex' => 'required|in:1,2,3',
                'old_year'  => 'required|integer|between:2000,' . date('Y'),
                'old_month' => 'required|between:1,12',
                'old_day'   => 'required|between:1,31',
                'role'      => 'required|in:1,2,3,4',
                'password'  => 'required|min:8|max:30|confirmed',
        ];
    }
}
