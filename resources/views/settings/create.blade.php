@extends('layouts.app', ['activePage' => 'setting', 'titlePage' => __('Settings')])
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                {{ Form::open(['route' => ['settings.store']]) }}
                <div class="card ">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">{{ __('Edit Settings') }}</h4>
                        <p class="card-category">{{ __('Maximum bid Amount') }}</p>
                    </div>
                    <div class="card-body ">
                        <div class="row">
                            {{ Form::label(__('Maximum Bid Amount(USD)'), null, ['class' => 'col-sm-2 col-form-labe']) }}
                            <div class="col-sm-7">
                                <div class="form-group">
                                    {!! Form::number('max_bid_amount', $model->max_bid_amount ?? null, [ 'placeholder'=>'Enter the amount here..', 'class' => ['form-control',errorClass($errors,'max_bid_amount')]]); !!}
                                    {!! errorMessage($errors,'max_bid_amount') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ml-auto mr-auto">
                        {!! $model?updateButton():saveButton() !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
