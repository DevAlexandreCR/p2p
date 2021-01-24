<div class="container">
    <div class="row row-cols-2 pt-3">
        <div class="col-sm-8 d-inline-flex align-items-lg-baseline">
            <small class="small me-4">{{ trans('showing ' . $products->lastItem() . ' of ' . $products->total()) }}</small> {{ $products->links() }}
        </div>
        <div class="col-sm-4">
            <form class="d-flex" action="{{ route('home') }}" method="get">
                <input class="form-control me-2" type="search" name="name" value="{{ request()->get('name') }}"
                       placeholder="{{ trans('actions.search') }}" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">{{ trans('actions.search') }}</button>
            </form>
        </div>
    </div>
</div>