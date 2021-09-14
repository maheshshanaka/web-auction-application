@extends('layouts.app', ['activePage' => 'admin', 'titlePage' => __('Admin Settings')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                {{ Form::open(['route' => ['items.store']]) }}
                <div class="card ">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">{{ __('Auction End Time') }}</h4>
                        <p class="card-category">{{ __('Admin Settings') }}</p>
                    </div>
                    <div class="card-body ">
                        <div class="row">
                            {{ Form::label(__('Item Name'), null, ['class' => 'col-sm-2 col-form-labe']) }}
                            <div class="col-sm-7">
                                <div class="form-group">
                                    {!! Form::select('item_id', $items,null, ['placeholder'=>'Please select','class'=>['form-control',errorClass($errors,'item_id')]]); !!}
                                    {!! errorMessage($errors,'item_id') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            {{ Form::label(__('Auction End Time'), null, ['class' => 'col-sm-2 col-form-labe']) }}
                            <div class="col-sm-7">
                                <div class="form-group">
                                    {!! Form::date('auction_end_time', $items, [ 'class' => ['form-control',errorClass($errors,'auction_end_time')]]); !!}
                                    {!! errorMessage($errors,'auction_end_time') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ml-auto mr-auto">
                        {!! saveButton() !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
