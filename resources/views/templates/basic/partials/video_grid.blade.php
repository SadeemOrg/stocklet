@php
    $defaultvideoContent = getContent('default_images.content', true);
    $defaultImage = getImage('assets/images/frontend/default_images/' . @$defaultvideoContent->data_values->loading_image);
@endphp
<ul class="list list--row flex-wrap flex-images t-mb-50 {{ @$class ?? 'gallery' }}" id="flexBox">
    @foreach ($videos as $video)
        @php
            $imageUrl = imageUrl(getFilePath('stockImage'), $video->cover_image);
        @endphp
        <li class="item" data-w="{{ $video->image_width }}" data-h="{{ $video->image_height }}">
            <a class="position-absolute video-icon" href="{{ route('video.detail', [slug($video->title), $video->id]) }}">
                <svg class="position-absolute video-icon" width="50" height="50" viewBox="0 0 82 82" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_141_3225)">
                        <circle cx="40.3167" cy="40.3167" r="37.5833" fill="white"></circle>
                        <path d="M41 0C18.3563 0 0 18.3563 0 41C0 63.6437 18.3563 82 41 82C63.6437 82 82 63.6437 82 41C82 18.3563 63.6437 0 41 0ZM29.7975 58.8326V23.1674L60.6845 41L29.7975 58.8326Z" fill="#ED3126"></path>
                    </g>
                    <defs>
                        <clipPath id="clip0_141_3225">
                            <rect width="82" height="82" fill="white"></rect>
                        </clipPath>
                    </defs>
                </svg>
            </a>
            <a href="{{ route('video.detail', [slug($video->title), $video->id]) }}" class="gallery__link">
                <img src="{{ $defaultImage }}" data-image_src="{{ $imageUrl }}" alt="@lang('Image')" class="gallery__img lazy-loading-img" />
                @if (!$video->is_free)
                    <span class="gallery__premium {{app()->getLocale() === 'ar' ? 'ml-auto right-0 left-auto' : ''}}">
                        {{-- <i class="fas fa-crown"></i> --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 26 26" fill="none">
                            <path d="M5.17307 20.8272H20.8276C21.4449 20.8272 21.9458 20.3263 21.9458 19.7091C21.9458 19.0918 21.4449 18.5909 20.8276 18.5909H5.17307C4.55584 18.5909 4.05489 19.0918 4.05489 19.7091C4.05489 20.3263 4.55584 20.8272 5.17307 20.8272Z" fill="#FDBF00"/>
                            <path d="M17.0805 12.2603C17.3064 12.2603 17.5351 12.1921 17.7324 12.0495L24.8351 6.93888C25.3361 6.57826 25.4507 5.8794 25.0895 5.37845C24.7289 4.87751 24.0306 4.76234 23.5291 5.12407L16.4264 10.2347C15.9254 10.5953 15.8108 11.2942 16.172 11.7951C16.39 12.0987 16.7328 12.2603 17.0805 12.2603Z" fill="#FDBF00"/>
                            <path d="M8.92023 12.2603C9.26798 12.2603 9.61015 12.0988 9.82875 11.7952C10.1899 11.2942 10.0753 10.5954 9.57437 10.2347L2.47167 5.12409C1.96961 4.76292 1.27186 4.87809 0.91125 5.37848C0.550077 5.87943 0.664692 6.57829 1.16564 6.9389L8.26833 12.0496C8.46625 12.1921 8.69435 12.2603 8.92023 12.2603Z" fill="#FDBF00"/>
                            <path d="M17.0801 12.2609C17.23 12.2609 17.3821 12.2301 17.528 12.1664C18.0938 11.9193 18.3521 11.2595 18.1038 10.6937L14.0247 1.36979C13.7776 0.803989 13.1184 0.545689 12.5521 0.793926C11.9863 1.04104 11.728 1.70077 11.9762 2.26657L16.0553 11.5905C16.2387 12.0098 16.6491 12.2609 17.0801 12.2609Z" fill="#FDBF00"/>
                            <path d="M8.92063 12.2609C9.35169 12.2609 9.76206 12.0104 9.94544 11.5905L14.0246 2.26656C14.2722 1.70076 14.0139 1.04159 13.4487 0.79391C12.8829 0.546233 12.2237 0.804532 11.9761 1.36977L7.89694 10.6937C7.64926 11.2595 7.90756 11.9187 8.4728 12.1664C8.61872 12.2301 8.77135 12.2609 8.92063 12.2609Z" fill="#FDBF00"/>
                            <path d="M20.8287 20.8272C21.3313 20.8272 21.7887 20.4862 21.9133 19.9757L25.2679 6.29815C25.4149 5.69824 25.0476 5.09275 24.4483 4.94571C23.8506 4.79922 23.2434 5.16543 23.0958 5.76533L19.7413 19.4429C19.5942 20.0428 19.9616 20.6483 20.5609 20.7954C20.6509 20.8166 20.7404 20.8272 20.8287 20.8272Z" fill="#FDBF00"/>
                            <path d="M5.17167 20.8273C5.26001 20.8273 5.34946 20.8167 5.43947 20.7949C6.03882 20.6478 6.40614 20.0423 6.2591 19.4424L2.90456 5.76481C2.75751 5.16547 2.15146 4.7987 1.55211 4.94519C0.952767 5.09223 0.585445 5.69772 0.732486 6.29763L4.08703 19.9752C4.21171 20.4857 4.66905 20.8273 5.17167 20.8273Z" fill="#FDBF00"/>
                            <path d="M5.17307 25.3H20.8276C21.4449 25.3 21.9458 24.7991 21.9458 24.1818C21.9458 23.5646 21.4449 23.0637 20.8276 23.0637H5.17307C4.55584 23.0637 4.05489 23.5646 4.05489 24.1818C4.05489 24.7991 4.55584 25.3 5.17307 25.3Z" fill="#FDBF00"/>
                            </svg>
                    </span>
                @endif
                {{-- <figcaption class="gallery__content">
                    <span class="gallery__title">
                        {{ __($video->title) }}
                    </span>
                    <span class="gallery__footer">
                        <span class="gallery__author">
                            <span class="gallery__user">
                                <img src="{{ $defaultImage }}" data-image_src="{{ getImage(getFilePath('userProfile') . '/' . $video->user->image, null, 'user') }}" alt="@lang('Contributor')" class="gallery__user-img lazy-loading-img" />
                            </span>
                            <span class="gallery__user-name">{{ $video->user->fullname }}</span>
                        </span>
                        <span class="gallery__like">
                            <span class="gallery__like-icon">
                                <i class="fas fa-heart"></i>
                            </span>
                            <span class="gallery__like-num">{{ shortNumber($video->total_like) }}</span>
                        </span>
                    </span>
                </figcaption> --}}
            </a>

            @php
                $user = auth()->user();
                $like = $video->likes->where('user_id', @$user->id)->count();
                $collectionImage = $user ? $user->collectionImages->where('image_id', $video->id)->first() : null;
            @endphp



            <div class="gallery__share top-auto bottom-[15px] left-[50%] translate-x-[-50%]">
                {{-- <figcaption class="gallery__content" style="margin-bottom: 38px">
                    <span class="gallery__footer justify-content-center">
                        <span class="gallery__author">
                            <span class="gallery__user">
                                <img src="{{ $defaultImage }}" data-image_src="{{ getImage(getFilePath('userProfile') . '/' . $video->user->image, null, 'user') }}" alt="@lang('Contributor')" class="gallery__user-img lazy-loading-img" />
                            </span>
                            <span class="Shamel-SansOneBook-font font-400">@lang('Published by'):</span><span class="gallery__user-name"> {{ $video->user->fullname }}</span>
                        </span>
                    </span>
                </figcaption> --}}
                <div class="list gallery__list justify-content-center flex-row">
                    <div>
                        <button class="gallery__btn @if ($like) unlike-btn @else like-btn @endif" data-has_icon="1" data-bs-toggle="tooltip" data-bs-placement="top" title="@if ($like) @lang('Unlike') @else @lang('like') @endif" data-bs-custom-class="custom--tooltip" data-image="{{ $video->id }}">
                            @if ($like)
                                <i class="fas fa-heart text-[22px] text-[#ed3126]"></i>
                            @else
                                <i class="fas fa-heart text-[22px] text-white"></i>
                            @endif
                        </button>
                    </div>
                    <div>
                        <button class="gallery__btn collect-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="@if ($collectionImage) @lang('Collected') @else
                @lang('Collect') @endif" data-bs-custom-class="custom--tooltip" data-image_id="{{ $video->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 19 19" fill="none">
                                <g clip-path="url(#clip0_141_2558)">
                                <path d="M11.2812 0H2.17708C0.97375 0 0 0.97375 0 2.17708V14.4479C0 15.6513 0.97375 16.625 2.17708 16.625H7.39417C6.96667 15.7225 6.72917 14.7171 6.72917 13.6562C6.72917 12.7458 6.90333 11.875 7.22792 11.0754C7.19625 11.0833 7.16458 11.0833 7.125 11.0833H3.16667C2.73125 11.0833 2.375 10.7271 2.375 10.2917C2.375 9.85625 2.73125 9.5 3.16667 9.5H7.125C7.42583 9.5 7.695 9.67417 7.82167 9.9275C8.33625 9.12792 9.00125 8.44708 9.785 7.91667H3.16667C2.73125 7.91667 2.375 7.56042 2.375 7.125C2.375 6.68958 2.73125 6.33333 3.16667 6.33333H10.2917C10.7271 6.33333 11.0833 6.68958 11.0833 7.125C11.0833 7.16458 11.0833 7.19625 11.0754 7.22792C11.8117 6.92708 12.6192 6.75292 13.4583 6.73708V2.17708C13.4583 0.97375 12.4846 0 11.2812 0ZM6.33333 4.75H3.16667C2.73125 4.75 2.375 4.39375 2.375 3.95833C2.375 3.52292 2.73125 3.16667 3.16667 3.16667H6.33333C6.76875 3.16667 7.125 3.52292 7.125 3.95833C7.125 4.39375 6.76875 4.75 6.33333 4.75Z" fill="#fff"/>
                                <path d="M13.6562 8.3125C10.7097 8.3125 8.3125 10.7097 8.3125 13.6562C8.3125 16.6028 10.7097 19 13.6562 19C16.6028 19 19 16.6028 19 13.6562C19 10.7097 16.6028 8.3125 13.6562 8.3125ZM15.8333 14.4479H14.4479V15.8333C14.4479 16.2703 14.0933 16.625 13.6562 16.625C13.2193 16.625 12.8646 16.2703 12.8646 15.8333V14.4479H11.4792C11.0422 14.4479 10.6875 14.0933 10.6875 13.6562C10.6875 13.2193 11.0422 12.8646 11.4792 12.8646H12.8646V11.4792C12.8646 11.0422 13.2193 10.6875 13.6562 10.6875C14.0933 10.6875 14.4479 11.0422 14.4479 11.4792V12.8646H15.8333C16.2703 12.8646 16.625 13.2193 16.625 13.6562C16.625 14.0933 16.2703 14.4479 15.8333 14.4479Z" fill="#fff"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_141_2558">
                                <rect width="19" height="19" fill="white"/>
                                </clipPath>
                                </defs>
                                </svg>
                        </button>
                    </div>
                    <div>
                        <button class="gallery__btn share-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Share" data-bs-custom-class="custom--tooltip" data-route="{{ route('image.detail', [slug($video->title), $video->id]) }}" data-url_len_code="{{ urlencode(route('image.detail', [slug($video->title), $video->id])) }}" data-image_title="{{ $video->title }}">
                            {{-- <i class="las la-share"></i> --}}
                            <i class="fas fa-share-alt text-[20px] text-white"></i>
                        </button>
                    </div>
                </div>
            </div>
        </li>
    @endforeach
</ul>

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/jquery.flex-images.min.js') }}"></script>
@endpush
@push('script')
    <script>
        "use strict";
        $('#flexBox').flexImages({
            rowHeight: 240
        });
    </script>
@endpush
