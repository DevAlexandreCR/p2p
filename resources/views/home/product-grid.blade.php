<div class="container">
    <div class="row my-3">
        @foreach($products as $product)
            <div class="col-lg-3 col-sm-6 col-md-4 mb-2">
                <div class="card">
                    <img src="{{ asset('images/' . $product->image) }}" class="card-img-top img-product-grid" alt="{{ $product->image }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-truncate" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $product->description }}">{{ $product->description }}</p>
                        <div class="row mb-2 align-items-baseline">
                            <div class="col-6 text-start d-inline-flex">
                                <a href="{{ route('home.show', ['product' => $product->slug]) }}" class="btn btn-primary"><i class="bi bi-eye-fill"></i></a>
                                @auth()
                                    <form action="{{ route('cart.store', auth()->user()) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="{{ 1 }}">
                                        <button type="submit" class="btn btn-primary ms-2"><i class="bi bi-cart-plus-fill"></i></button>
                                    </form>
                                @endauth
                            </div>
                            <div class="col-6 fw-bold text-end">$ {{ number_format($product->price) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
            <div class="row">
                <div class="col-sm-6 text-end align-items-lg-baseline">
                    <small class="small me-4">
                        {{ trans('showing ' . $products->lastItem() . ' of ' . $products->total()) }}
                    </small>
                </div>
                <div class="col-sm-6">
                    {{ $products->onEachSide(3)->withQueryString()->links() }}
                </div>
            </div>

        @if($products->count() === 0)
                <div class="alert alert-warning w-50 mx-auto mt-5 text-center" role="alert">
                    <strong>{{ trans_choice('products.found', 0, ['product_found' => 0]) }}</strong>
                    <a class="link" href="{{ route('home') }}">{{ trans('actions.view_all') }}</a>
                </div>
        @endif
    </div>
</div>

