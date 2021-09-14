<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Http\Requests\Setting\UpdateRequest;
use Illuminate\Support\Facades\Auth;
use Exception;

class SettingController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = Setting::where('user_id', Auth::user()->id)->first();
        return view('settings.create', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateRequest $request)
    {
        $params = $request->all();
        try {
            Setting::updateOrCreate(
                ['user_id' => $params['user_id']],
                [
                    'max_bid_amount'  => $params['max_bid_amount']
                ]
            );
            return redirect()->route('items.index')->with('success', 'Record created successfully');
        } catch (Exception $e) {
            return redirect()->route('settings.create')->with('error', $e->getMessage());
        }
    }
}
