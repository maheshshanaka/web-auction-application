@extends('layouts.app', ['activePage' => 'items', 'titlePage' => __('Item List')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">

            <form class="navbar-form">
                <div class="input-group no-border">
                    <div class="dropdown" style="margin-right:50px;margin-left:20px">
                        @php
                        $priceOrder = ['low'=>'Price Low to High', 'high' =>'Price High to Low'];

                        @endphp
                        {!! Form::select('item_id', $priceOrder, null, [ 'id'=>'price-range','placeholder'=>'Price Range','class'=>['btn btn-secondary dropdown-toggle']]); !!}

                    </div>

                    <input id ="search-value" type="text" value="" class="form-control" placeholder="Search...">
                    <button id ="search" type="submit" class="btn btn-white btn-round btn-just-icon">
                        <i class="material-icons">search</i>
                        <div class="ripple-container"></div>
                    </button>
                </div>
            </form>
            <div class="col-md-12" id="wrap-item-section">
                @include('items.includes.list')
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

<script type="text/javascript">
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {

             $('#price-range').on('change', function(event) {
                event.preventDefault();

                $.post("{{ route('api.search-items') }}", {
                    price: $(this).val()
                }, function(result) {
                    $('#wrap-item-section').empty().append(result.data);
                });
            });

             $('#search').on('click', function(event) {
                event.preventDefault();

                $.post("{{ route('api.search-items') }}", {
                    search: $('#search-value').val()
                }, function(result) {
                    $('#wrap-item-section').empty().append(result.data);
                });
            });
        });

</script>
@endpush

