<!-- Categories List Start -->
<div class="container-fluid products productList mt-5 overflow-hidden py-2" style="background-color: rgba(0,0,0,0.035)">

    <div class="row mb-5 position-relative">
        <h1 class="col-md-6 p-0 pb-1 {{$lang==='ar'? 'me-4':''}} text-center position-relative" style="left: -.5%;">{{__('front/labels.shop_by_category')}}</h1>
    </div>

    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">

        <div class="carousel-indicators">
            @foreach(collect($categories)->chunk(6) as $chunk)
                <button type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide-to="{{ $loop->index }}"
                        class="{{ $loop->first ? 'active' : '' }}"
                        aria-label="Slide {{ $loop->iteration }}"></button>
            @endforeach
        </div>

        <div class="carousel-inner">
            @foreach(collect($categories)->chunk(6) as $chunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="container ">
                        <div class="row g-3">
                            @foreach($chunk as $category)
                                <div class="col-md-4">
                                    {{--                                        {{ route('category.show', $category->slug) }}--}}
                                    <a href="{{ route('front.category.show', $category['slug']) }}" class="category-item d-block position-relative text-decoration-none">
                                        <img src="{{ $category['image_url'] }}" class="d-block  img-fluid rounded" alt="" style="height: 12.8rem; width: 100%;" >

                                        <div class="category-overlay d-flex align-items-center justify-content-center">
                                            <span class="category-name text-white fw-bold">{{ $category['name'] }}</span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev pe-sm-5" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon " aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next ps-sm-5" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

</div>
<!-- Categories List End -->
