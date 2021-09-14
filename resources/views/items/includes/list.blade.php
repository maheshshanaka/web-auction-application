<div class="row">
    @foreach ($items as $item)

    <div class="col-md-6">
        <div class="card card-chart">
            <div class="card-header card-header">
                <div class="ct-chart" style="text-align:center">
                    <img width=200px height=200px src="/images/{{ $item->images }}" alt="{{ $item->slug }}">
                </div>
            </div>
            <div class="card-body">
                <h4 class="card-title">{{ $item->name }}</h4>
                <p class="card-category">
                    <span class="text-success">{{ $item->description }}</p>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <h4>${{ number_format($item->price, 2) }}</h4>
                </div>
            </div>
            <div class="card-footer ml-auto mr-auto">
                <a href="{{ route('items.show', ['item' => $item->id]) }}" class="btn btn-primary btn-lg" role="button" aria-disabled="true">Bid Now</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
{{$items->links("pagination::bootstrap-4")}}
