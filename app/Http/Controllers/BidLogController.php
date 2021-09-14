<?php

namespace App\Http\Controllers;

use App\Http\Requests\BidLog\CreateRequest;
use Illuminate\Http\Request;
use App\Models\BidLog;
use App\Repositories\ItemRepository;
use App\Repositories\BidLogRepository;
use App\Repositories\AutoBidBotRepository;
use Yajra\DataTables\DataTables;
use Exception;


class BidLogController extends Controller
{

    private $autoBid;

    public function __construct()
    {
        $this->item = new ItemRepository;
        $this->bid = new BidLogRepository;
        $this->autoBidBot = new AutoBidBotRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $model = BidLog::query();

            return Datatables::of($model)
                ->editColumn('user_id', function ($model) {
                    return $model->user->name ?? null;
                })
                ->editColumn('created_at', function ($model) {
                    return $model->created_at->format('Y-m-d H:s');
                })
                ->editColumn('is_auto_bid', function ($model) {
                    return $model->is_auto_bid == true ? "YES" : "NO";
                })
                ->editColumn('amount', function ($model) {
                    return "$" . number_format($model->amount, 2);
                })->filter(function ($model) {
                    if (request()->has('id')) {
                        $model->where('item_id', Request('id'))->orderBy('amount', 'desc');
                    }
                })
                ->toJson();
        }

        return view('bid_logs.index');
    }


    // Placed bid items
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {

        try {
            $params = $request->all();
            $itemId = $params['item_id'];

            BidLog::create($params);

            // When someone bids on an item, the Auto Bid bot starts automatically.
            $this->autoBidBot->startAutoBidBot($itemId); //itemId

            return redirect()->route('items.show', $itemId)->with('success', 'Record created successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
