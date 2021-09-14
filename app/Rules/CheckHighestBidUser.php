<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Repositories\AutoBidBotRepository;
use Illuminate\Support\Facades\Auth;

class CheckHighestBidUser implements Rule
{

    private $autoBid;
    /**
     * Create a new rule instance.
     *
     * @return void
     */


    public function __construct()
    {
        $this->autoBid = new AutoBidBotRepository;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

            if( Auth::id() != $this->autoBid->getHighestBidUser(Request('item_id'))) {
                return true;
            }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Bidded highest amount already' ;
    }
}
