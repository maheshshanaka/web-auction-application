<?php

namespace App\Http\Requests\BidLog;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckBidAmount;
use App\Rules\CheckHighestBidUser;
use Illuminate\Support\Facades\Auth;

class CreateRequest extends FormRequest
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
            'amount' =>  [
                'required','numeric',
                new CheckBidAmount(),  // check amount should be greater than highest bid amount or not
                new CheckHighestBidUser(), // check highest bid user
            ],
            'item_id' => 'required|integer|min:1'
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
