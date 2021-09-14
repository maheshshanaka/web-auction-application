<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Repositories\AutoBidBotRepository;

class CheckBidAmount implements Rule
{

    private $autoBid, $highestValue;
    /**
     * Create a new rule instance.
     *
     * @return void
     */


    public function __construct($highestValue =null)
    {
        $this->autoBidBot = new AutoBidBotRepository;
        $this->highestValue = $highestValue;
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

        $this->highestValue  = $this->autoBidBot->getHighestBid(Request('item_id'));

        if( $value > $this->highestValue ) {
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

        return 'Minimum amount should be greater than $'.$this->highestValue ;
    }
}
