<?php

namespace App\Repositories;

use App\Models\AutoBid;
use App\Models\BidLog;
use App\Models\Setting;
use App\Models\Item;
use App\Repositories\Repository;
// use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class AutoBidBotRepository extends Repository
{

    private $bidLog, $setting, $autoBid;

    public function __construct()
    {
        $this->bidLog = new BidLog;
        $this->setting = new Setting;
        $this->autoBid = new AutoBid;
        $this->item = new Item;
    }

    // When someone bids on an item, the Auto Bid bot starts automatically.
    public function startAutoBidBot($itemId = null)
    {
        $filteredUsers = [];
        $highestBid = $this->getHighestBid($itemId);
        $bidUsers = $this->getAutoBidUsersByItems($itemId, $highestBid);
        $availbleBidAmount = 0;
        foreach ($bidUsers as $bidUser) {
            $availbleBidAmount =  $this->getAvailbleBidAmount($bidUser->user_id, $itemId);
            if (($availbleBidAmount > $highestBid)) {
                $filteredUsers[] = array(
                    'availble_bid_amount' => $availbleBidAmount,
                    'last_bid' => $highestBid,
                    'user_id' => $bidUser->user_id,
                    'item_id' => $itemId
                );
            }
        }
        if (!empty($filteredUsers)) {
            return $this->createBid($filteredUsers);
        } else {
            // because no need to display unnecessary error messages.
            return false;
            // throw new Exception('No Autobid users found');
        }
    }

    // get auto bid users for given items
    public function getAutoBidUsersByItems($itemId = null, $lastBid = 0)
    {
        return $this->autoBid::select('auto_bids.user_id')
            ->join('settings', 'settings.user_id', '=', 'auto_bids.user_id')
            ->where(function ($q) use ($itemId,  $lastBid) {
                $q->where("auto_bids.item_id", $itemId)
                    ->where("auto_bids.user_id", "!=", Auth::id())
                    ->where("auto_bids.is_auto_bid", 1)
                    ->where("settings.max_bid_amount", ">", $lastBid);
            })
            ->groupBy("auto_bids.user_id")
            ->groupBy("auto_bids.item_id")
            // ->orderBy("settings.max_bid_amount", "desc")
            ->get();
    }

    public function createBid($filteredBidInfos)
    {
        $collection = new Collection($filteredBidInfos);
        //  no contest with bidders
        if ($collection->count() == 1) {
            $data['user_id'] = $collection[0]['user_id'];
            $data['item_id'] = $collection[0]['item_id'];
            $data['amount'] = $collection[0]['last_bid'] + 1;
            $data['is_auto_bid'] = true;
        } else {
            $collectionSortByDesc = $collection->sortByDesc('availble_bid_amount')->values()->all();
            //
            // get Auto bid user who possible to pay highest amount
            $data['user_id'] = $collectionSortByDesc[0]['user_id'];
            $data['item_id'] = $collectionSortByDesc[0]['item_id'];
            $data['amount'] = $collectionSortByDesc[1]['availble_bid_amount'] + 1; // second higher auto bidder value
            $data['is_auto_bid'] = true;
        }
        $result = $this->bidLog::create($data);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }


    // get last bid amount of the item
    public function getHighestBid($itemId)
    {
        $bidLogAmount =  $this->bidLog::where('item_id', '=', $itemId)
            ->orderBy('amount', 'desc')
            ->first();
        // if not bid
        if (isset($bidLogAmount->amount) && $bidLogAmount->amount > 0) {
            return $bidLogAmount->amount;
        } else {
            return $this->item::find($itemId)->price ?? null;
        }
    }

    // get last bid amount of the item
    public function getHighestBidUser($itemId)
    {
        return $this->bidLog::where('item_id', '=', $itemId)
            ->orderBy('amount', 'desc')
            ->first()->user_id ?? null;
    }


    // get availble bid amount amount of the user
    public function getAvailbleBidAmount($userId = null, $itemId = null)
    {
        return  $this->getMaxBidAmount($userId) - $this->getSpentAmount($userId, $itemId);
    }


    // get total spent amount for other items
    // skip going to be bid item
    public function getSpentAmount($userId = null, $itemId = null)
    {
        $spentValues = $this->bidLog::selectRaw('distinct(max(amount)) as spentValue')
            ->where('user_id', $userId)
            ->where('item_id', "!=", $itemId)
            ->groupBy('bid_logs.item_id')
            ->get();
        $totalSpentValue = 0;
        foreach ($spentValues as $spentValue) {
            $totalSpentValue += $spentValue->spentValue ?? 0;
        }
        return $totalSpentValue;
    }


    // get maximum Bid amount of the user
    public function getMaxBidAmount($userId)
    {
        return $this->setting::where('user_id', $userId)->orderBy('created_at', 'desc')->first()->max_bid_amount ?? 0;
    }
}
