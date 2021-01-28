<div class="container">
    <div class="row pt-3">
        <div class="col-sm-4">
            <order-by-component
                    :order-selected="'{{request()->get('order', 'Asc')}}'"
                    :order-by-selected="'{{request()->get('orderBy', 'Order by')}}'"
                    :form-id="'searchProductHome'">
            </order-by-component>
        </div>
        <div class="col-sm-4 py-2"></div>
        <div class="col-sm-4">
            <form class="d-flex" action="{{ route('home') }}" method="get" id="searchProductHome">
                <input class="form-control me-2" type="search" name="name" value="{{ request()->get('name') }}"
                       placeholder="{{ trans('actions.search') }}" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">{{ trans('actions.search') }}</button>
            </form>
        </div>
    </div>
</div>