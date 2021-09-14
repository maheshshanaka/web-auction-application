<?php

namespace App\Repositories;

use App\Models\BidLog;
use App\Repositories\Repository;
use Exception;

class BidLogRepository extends Repository
{

    private $bidLog;

    public function __construct()
    {
        $this->bidLog = new BidLog();
    }

    public function validateLatestBid($itemId, $userId, $amount)
    {

        $latestBid = $this->bidLog::where('item_id', '=', $itemId)
            ->orderBy('amount', 'DESC')
            ->first();
        if ($latestBid) {
            if ($amount <= $latestBid->amount) {
                throw new Exception('Bid amount should be greater than (USD)' . number_format($latestBid->amount, 2));
            } else if ($userId == $latestBid->user_id) {
                throw new Exception('Bidded highest amount already');
            }
        }
    }

    public function getLatestBid($itemId)
    {
        return  $this->bidLog::where('item_id', $itemId)
            ->orderBy('amount', 'DESC')
            ->first()->amount ?? 0;
    }
}
