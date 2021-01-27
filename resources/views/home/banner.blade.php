<div class="container">
    <div class="row row-cols-3 pt-3">
        <div class="col-sm-4">
            <order-by-component :form-id="'searchProductHome'"></order-by-component>
        </div>
        <div class="col-sm-4 d-inline-flex">
            <label for="customRange1" class="form-label">min</label>
            <input type="range" class="form-range" id="customRange1">
            <label for="customRange2" class="form-label">max</label>
            <input type="range" class="form-range" id="customRange2">
        </div>
        <div class="col-sm-4">
            <form class="d-flex" action="{{ route('home') }}" method="get" id="searchProductHome">
                <input class="form-control me-2" type="search" name="name" value="{{ request()->get('name') }}"
                       placeholder="{{ trans('actions.search') }}" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">{{ trans('actions.search') }}</button>
            </form>
        </div>
    </div>
</div>