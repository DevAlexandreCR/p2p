<div class="container">
    <div class="row mb-5">
        @foreach($products as $product)
            <div class="col-sm-3 mb-2">
                <div class="card">
                    <img src="{{ asset('images/' . $product->image) }}" class="card-img-top img-product-grid" alt="{{ $product->image }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-truncate" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $product->description }}">{{ $product->description }}</p>
                    </div>
                    <div class="row container mb-2 align-items-baseline">
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
                        <div class="col-6 pe-0 fw-bold text-end">$ {{ number_format($product->price) }}</div>
                    </div>
                </div>
            </div>
        @endforeach

        @if($products->count() === 0)
                <div class="alert alert-warning w-50 mx-auto mt-5 text-center" role="alert">
                    <strong>{{ trans_choice('products.found', 0, ['product_found' => 0]) }}</strong>
                    <a class="link" href="{{ route('home') }}">{{ trans('actions.view_all') }}</a>
                </div>
        @endif
    </div>
</div>

