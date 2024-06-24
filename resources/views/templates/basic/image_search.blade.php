@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class=" col-xl-4 search-page__filter">
                <div class="filter-sidebar--backdrop"></div>
                @include($activeTemplate . 'partials.search_bar')
            </div>
            <div class="filter-container col-xl-8">
                <div class="search-category col-12">
                    @php
                        $categories = App\Models\Category::active()
                            ->whereHas('images', function ($query) {
                                $query->where('status', 1);
                            })
                            ->orWhereHas('videos', function ($query) {
                                $query->where('status', 1);
                            })
                            ->get();
                    @endphp
                    <div id="owl_carousel_filter" class="owl-carousel d-flex justify-content-center">
                        @foreach ($categories as $category)
                            {{-- <div class="item"><h4>1</h4></div> --}}
                            <div class="search-category__list">
                                <button class="search-category__btn Shamel-SansOneBold-font text-gray201 search-param"
                                    data-param="category" data-param_value="{{ $category->slug }}"
                                    data-search_type="single">{{ __($category->name) }}</button>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Tab Menu  -->
                @if (request()->filter)
                    <h1 class="text-center text-muted my-4">@lang('Showing results for') <span
                            class="fw-bold text--dark">{{ request()->filter }}</span></h1>
                @endif

                <div class="tab-menu">
                    <div class="container-fluid">
                        <div class="row my-4">
                            <div class="col-12">
                                <div class="tab-menu__content">
                                    <a href="javascript:void(0)"
                                        class="tab-menu__link search-images @if (request()->type == 'image') active @endif">
                                        <i class="las la-image la-lg"></i> @lang('Images') ({{ $imageCount }}) </a>
                                    <a href="javascript:void(0)"
                                        class="tab-menu__link search-videos @if (request()->type == 'video') active @endif">
                                        <i class="las la-video la-lg"></i> @lang('videos') ({{ $videoCount }}) </a>
                                    <a href="javascript:void(0)"
                                        class="tab-menu__link search-collections @if (request()->type == 'collection') active @endif">
                                        <i class="las la-folder-plus la-lg"></i> @lang('Collections') ({{ $collectionCount }})
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Tab Menu End -->
                        @if (request()->type == 'image' && $images->count())
                            @include($activeTemplate . 'partials.image_grid', [
                                'images' => $images,
                                'class' => 'gallery',
                            ])
                            @if ($images->hasPages())
                                <div class="search-page__pagination text-center py-3">
                                    {{ $images->appends(request()->all())->links($activeTemplate . 'partials.paginate') }}
                                </div>
                            @endif
                        @elseif(request()->type == 'video' && $videos->count())
                            @include($activeTemplate . 'partials.video_grid', [
                                'videos' => $videos,
                                'class' => 'gallery',
                            ])
                            @if ($images->hasPages())
                                <div class="search-page__pagination text-center py-3">
                                    {{ $images->appends(request()->all())->links($activeTemplate . 'partials.paginate') }}
                                </div>
                            @endif
                        @elseif(request()->type == 'collection' && $collections->count())
                            <div class="pb-2">
                                <div class="row g-4 justify-content-center">
                                    @include($activeTemplate . 'partials.collection_grid', [
                                        'collections' => $collections,
                                    ])
                                </div>
                            </div>

                            @if ($collections->hasPages())
                                <div class="search-page__pagination text-center py-3">
                                    {{ $collections->appends(request()->all())->links($activeTemplate . 'partials.paginate') }}
                                </div>
                            @endif
                        @else
                            <div class="d-flex justify-content-center align-items-center my-4">
                                <img src="{{ getImage('assets/images/empty_message.png') }}" alt="@lang('Image')">
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('modal')
    @include($activeTemplate . 'partials.login_modal')
    @include($activeTemplate . 'partials.collection_modal')
    @include($activeTemplate . 'partials.share_modal')
@endpush

@push('script')
    <script>
        "use strict";

        let likeRoutes = {
            updateLike: "{{ route('user.image.like.update') }}"

        };
        let likeParams = {
            loggedStatus: @json(Auth::check()),
            csrfToken: "{{ csrf_token() }}"
        }
    </script>
    <script src="{{ asset($activeTemplateTrue . 'js/like.js') }}"></script>
@endpush
