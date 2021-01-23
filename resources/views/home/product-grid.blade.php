<div class="container">
    <div class="row">
        @foreach($products as $product)
            <div class="col-sm-3 my-2">
                <div class="card">
                    <img src="{{ asset('images/' . $product->image) }}" class="card-img-top img-product-grid" alt="{{ $product->image }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-truncate" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $product->description }}">{{ $product->description }}</p>
                        <a href="#" class="btn btn-primary"><i class="bi bi-cart-plus-fill"></i></a>
                        <a href="{{ route('home.show', ['product' => $product->slug]) }}" class="btn btn-primary"><i class="bi bi-eye-fill"></i></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $products->links() }}
</div>

