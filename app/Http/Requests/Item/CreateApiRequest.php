<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateApiRequest extends FormRequest
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
            'item_id' => 'required|integer|min:1',
            'user_id' => 'required|integer|min:1',
            'is_auto_bid' => 'required'
        ];
    }

    /**
     *
     * @return type
     */
    public function all($keys = null)
    {
        $data = parent::all();
        $data['user_id'] = Auth::User()->id;
        return $data;
    }
}
