<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="profile">
                        <div class="col-md-12">
                            <div class="card card-chart">
                                <div class="card-header card-header">
                                    <div class="ct-chart">
                                        <img width="100%" src="/images/{{ $item->images }}" alt="{{ $item->slug }}">
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title">{{ $item->name }}</h4>
                                    <p class="card-category">
                                        <span class="text-success">{{ $item->description }}</p>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <h4 class="card-title">
                                            Pirce: ${{ number_format($item->price, 2) }}
                                        </h4>
                                    </div>
                                    <div class="stats">
                                        <h3 class="card-title text-danger">
                                            Highest Bid: ${{ number_format($latestBid, 2) }}
                                        </h3>
                                    </div>
                                </div>

                                @if($auctionClosed ==false)
                                <div class="card-footer">
                                    <div class="stats">
                                        <h6 class="card-title">
                                            Ends in:
                                        </h6>
                                    </div>
                                </div>
                                <div data-date="{{ $item->auction_end_time }}" id="count-down"></div>
                                @endif

                                <div class="forms">
                                    <form action="{{ route('bid-logs.store') }}" method="POST">
                                        @csrf
                                        <div class="wrap-form">
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        Auto Bid
                                                        <input id="check-auto-bid" class="form-check-input" type="checkbox" {{ $auctionClosed ==true ? "disabled" : null }} {{ $isAutoBid == true ? "checked" : null }}>
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                {!! Form::hidden('item_id', $item->id,['id'=>"item_id"]) !!}
                                                <div class="form-group">
                                                    {!! Form::number('amount', null, [ 'id'=>"amount", $auctionClosed ==true ? "disabled" : null, 'class' => ['form-control',errorClass($errors,'amount')]]); !!}
                                                    {!! errorMessage($errors,'amount') !!}
                                                </div>
                                                @php
                                                $disabled = null;
                                                @endphp
                                                @if($auctionClosed == true || $isAutoBid == true)
                                                @php
                                                $disabled = "disabled";
                                                @endphp
                                                @endif
                                                <div class="card-footer ml-auto mr-auto">
                                                    <button id="submit-auto-bid" type="submit" class="btn btn-primary" {{ $disabled }}>SUBMIT</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header card-header-warning">
                <h4 class="card-title">Bidding List</h4>
                <p class="card-category"></p>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Auto Bid</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- @section('js') --}}

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<link rel="stylesheet" href="/timer/TimeCircles.css" />
<script src="/timer/TimeCircles.js"></script>

<script type="text/javascript">
    $("#count-down").TimeCircles();

/*
    $("#count-down").TimeCircles({
    text_size: 0.09
    , number_size: 0.09
    , bg_width: 0.3
    , fg_width: 0.03
    , bg_width: 0.03,

    }).getTime().rebuild();
*/

    $(function() {

        var table = $('.data-table').DataTable({
            processing: true
            , serverSide: true
            , ajax: "{{ route('bid-logs.index',array('id'=> $item->id )) }}"
            , columns: [

                {
                    data: 'user_id'
                    , name: 'user_id'
                }
                , {
                    data: 'amount'
                    , name: 'amount'
                }
                , {
                    data: 'is_auto_bid'
                    , name: 'is_auto_bid'
                }
                , {
                    data: 'created_at'
                    , name: 'created_at'
                },

            ]
        });

    });

</script>

@push('js')

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {


        $('#check-auto-bid').on('click', function(event) {
            //event.preventDefault();
            $.post("{{ route('api.set-auto-bid') }}", {

                item_id: $('#item_id').val()
                , is_auto_bid: $('#check-auto-bid').is(":checked")

            }, function(result) {

                if (result.data) {

                    alert('Record Updated');

                    $("#amount").prop("disabled", true);
                    $("#submit-auto-bid").prop("disabled", true);

                }
            });
        });

    });

</script>
@endpush
