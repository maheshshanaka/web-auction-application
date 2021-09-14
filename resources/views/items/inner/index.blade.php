@extends('layouts.app', ['activePage' => 'items', 'titlePage' => __('Item Details')])

@section('content')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @include('items.inner.includes.header')
                @include('items.inner.includes.container')

            </div>
        </div>
    </div>
</div>
@endsection
