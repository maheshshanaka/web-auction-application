<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\CreateRequest;
use App\Http\Requests\Item\CreateApiRequest;
use App\Models\AutoBid;
use App\Models\Item;
use App\Repositories\BidLogRepository;
use App\Repositories\ItemRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    private $bid, $item;

    public function __construct()
    {
        $this->bid = new BidLogRepository;
        $this->item = new ItemRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view(
            'items.index',
            [
                'items' => Item::paginate(10)
                // 'items' => Item::auctionEndTime()->paginate(10)
            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function searchItems(Request $request)
    {
        if ($request->ajax()) {
            $items = $this->item->searchItems($request->all());
            $data = view('items.includes.list', compact('items'))->render();
            return response()->json(['data' => $data]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(
            'items.create',
            [
                'items' => Item::orderBy('name')->pluck('name', 'id'),
            ]
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        try {
            Item::where('id', $request->get('id'))
                ->update(['auction_end_time' => $request->get('auction_end_time')]);
            return redirect()->route('items.index')->with('success', 'Record updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    // Bid items inner page
    public function show(Item $item)
    {

        $auctionClosed = false;
        if (is_null($item->auction_end_time) || $item->auction_end_time < now()) {
            $auctionClosed = true;
        }
        $isAutoBid = AutoBid::where([
            'item_id' => $item->id,
            'user_id' => Auth::id()
        ])->first()->is_auto_bid ?? false;

        return view(
            'items.inner.index',
            [
                'item' => $item,
                'auctionClosed' => $auctionClosed,
                'isAutoBid' => $isAutoBid,
                'latestBid' => $this->bid->getLatestBid($item->id),
            ]
        );

        return abort(404);
    }


    // set auto bid api when check Auto Bid check box
    public function setAutoBid(CreateApiRequest $request)
    {
        if ($request->ajax()) {
            $params = $request->all();
            $result = AutoBid::updateOrCreate(
                ['user_id' => $params['user_id'], 'item_id' => $params['item_id']],
                [
                    'is_auto_bid'  => $params['is_auto_bid'] == 'true' ? 1 : 0
                ]
            );
            if ($result) {
                $data = true;
            } else {
                $data = false;
            }
            return response()->json(['data' => $data]);
        }
    }
}
