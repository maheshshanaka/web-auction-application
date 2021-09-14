<section class="product-page-hader">
    <div class="container">
        <div class="wrap-product-page-hader">
            <div class="layout-filter">
                <a href="{{ route('items.index') }}" class="back-btn">
                    <span>Back</span>
                </a>
            </div>
            <h4>{{ $item->name ?? null }}</h4>
        </div>
    </div>
</section>
