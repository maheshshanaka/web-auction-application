<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|integer|min:1',
            'max_bid_amount' => 'required|numeric|min:1',
        ];
    }

    /**
     *
     * @return type
     */
    public function all($keys = null)
    {
        $data = parent::all();
        $data['user_id'] = Auth::User()->id ?? null;
        return $data;
    }
}
