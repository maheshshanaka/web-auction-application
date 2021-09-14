<?php

namespace App\Repositories;

use App\Models\Item;
use App\Repositories\Repository;
use Exception;

class ItemRepository extends Repository
{

    private $item;

    public function __construct()
    {
        $this->item = new Item();
    }

    //checking bidding start or closed
    public function validateBiddingIsStarted($itemId)
    {
        $item = $this->item::find($itemId);
        if (is_null($item->auction_end_time)) {
            throw new Exception('Auction is not started');
        } else if ($item->auction_end_time < NOW()) {
            throw new Exception('Auction closed');
        }
    }

    // This function for search name and description of item list
    // Order price range
    public function searchItems($request)
    {
        $result = $this->item::when(isset($request['price']), function ($q) use ($request) {
            if ($request['price'] == "low") {
                $q->orderBy("price", "asc");
            } else {
                $q->orderBy("price", "desc");
            }
        })->when(isset($request['search']), function ($q) use ($request) {
            $search = $request['search'];
            $q->Where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        })->orderBy("name")
            ->paginate(10);
        return $result;
    }
}
