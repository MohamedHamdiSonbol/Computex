<!-- Product List Satrt -->
<div class="container-fluid products productList mt-5 overflow-hidden py-2" style="background-color: rgba(0,0,0,0.035)">
    <div class="row mb-5 position-relative">
        <h1 class="col-md-6 p-0 pb-1 {{$lang==='ar'? 'me-5 pe-4':''}} text-center position-relative" style="left: -2.2%;">{{__('front/labels.shop_by_brand')}}</h1>
    </div>

    <div id="carouselBrandsIndicators" class="carousel slide" data-bs-ride="carousel">

        <div class="carousel-indicators">
            @foreach(collect($brands)->chunk(3) as $chunk)
                <button type="button" data-bs-target="#carouselBrandsIndicators"
                        data-bs-slide-to="{{ $loop->index }}"
                        class="{{ $loop->first ? 'active' : '' }}"
                        aria-label="Slide {{ $loop->iteration }}"></button>
            @endforeach
        </div>

        <div class="carousel-inner">
            @foreach(collect($brands)->chunk(3) as $chunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="container ">
                        <div class="row g-3">
                            @foreach($chunk as $brand)
                                <div class="col-md-4">
                                    {{--                                        {{ route('category.show', $category->slug) }}--}}
                                    <a href="{{ route('front.brand.show', $brand['slug']) }}" class="category-item d-block position-relative text-decoration-none">
                                        <img src="{{ $brand['image_url'] }}" class="d-block img-fluid rounded" alt="brand" style="height: 12.8rem; width: 100%;"  >

                                        <div class="category-overlay d-flex align-items-center justify-content-center">
                                            <span class="category-name text-white fw-bold">{{ $brand['name'] }}</span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev pe-sm-5" type="button" data-bs-target="#carouselBrandsIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next ps-sm-5" type="button" data-bs-target="#carouselBrandsIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

</div>
<!-- Product List End -->
