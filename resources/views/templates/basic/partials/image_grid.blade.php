@php
    $defaultImageContent = getContent('default_images.content', true);
    $defaultImage = getImage('assets/images/frontend/default_images/' . @$defaultImageContent->data_values->loading_image);
@endphp
<ul class="list list--row flex-wrap flex-images t-mb-50 {{ @$class ?? 'gallery' }}" id="flexBox">
    @foreach ($images as $image)
        @php
            $imageUrl = imageUrl(getFilePath('stockImage'), $image->thumb);
        @endphp
        <li class="item" data-w="{{ $image->image_width }}" data-h="{{ $image->image_height }}" style="">
            <a href="{{ route('image.detail', [slug($image->title), $image->id]) }}" class="gallery__link">
                <img src="{{ $defaultImage }}" data-image_src="{{ $imageUrl }}" alt="@lang('Image')"
                    class="gallery__img lazy-loading-img" />
                @if (!$image->is_free)
                    <span class="gallery__premium {{ app()->getLocale() === 'ar' ? 'ml-auto right-0 left-auto' : '' }}">
                        {{-- <i class="fas fa-crown"></i> --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 26 26"
                            fill="none">
                            <path
                                d="M5.17307 20.8272H20.8276C21.4449 20.8272 21.9458 20.3263 21.9458 19.7091C21.9458 19.0918 21.4449 18.5909 20.8276 18.5909H5.17307C4.55584 18.5909 4.05489 19.0918 4.05489 19.7091C4.05489 20.3263 4.55584 20.8272 5.17307 20.8272Z"
                                fill="#FDBF00" />
                            <path
                                d="M17.0805 12.2603C17.3064 12.2603 17.5351 12.1921 17.7324 12.0495L24.8351 6.93888C25.3361 6.57826 25.4507 5.8794 25.0895 5.37845C24.7289 4.87751 24.0306 4.76234 23.5291 5.12407L16.4264 10.2347C15.9254 10.5953 15.8108 11.2942 16.172 11.7951C16.39 12.0987 16.7328 12.2603 17.0805 12.2603Z"
                                fill="#FDBF00" />
                            <path
                                d="M8.92023 12.2603C9.26798 12.2603 9.61015 12.0988 9.82875 11.7952C10.1899 11.2942 10.0753 10.5954 9.57437 10.2347L2.47167 5.12409C1.96961 4.76292 1.27186 4.87809 0.91125 5.37848C0.550077 5.87943 0.664692 6.57829 1.16564 6.9389L8.26833 12.0496C8.46625 12.1921 8.69435 12.2603 8.92023 12.2603Z"
                                fill="#FDBF00" />
                            <path
                                d="M17.0801 12.2609C17.23 12.2609 17.3821 12.2301 17.528 12.1664C18.0938 11.9193 18.3521 11.2595 18.1038 10.6937L14.0247 1.36979C13.7776 0.803989 13.1184 0.545689 12.5521 0.793926C11.9863 1.04104 11.728 1.70077 11.9762 2.26657L16.0553 11.5905C16.2387 12.0098 16.6491 12.2609 17.0801 12.2609Z"
                                fill="#FDBF00" />
                            <path
                                d="M8.92063 12.2609C9.35169 12.2609 9.76206 12.0104 9.94544 11.5905L14.0246 2.26656C14.2722 1.70076 14.0139 1.04159 13.4487 0.79391C12.8829 0.546233 12.2237 0.804532 11.9761 1.36977L7.89694 10.6937C7.64926 11.2595 7.90756 11.9187 8.4728 12.1664C8.61872 12.2301 8.77135 12.2609 8.92063 12.2609Z"
                                fill="#FDBF00" />
                            <path
                                d="M20.8287 20.8272C21.3313 20.8272 21.7887 20.4862 21.9133 19.9757L25.2679 6.29815C25.4149 5.69824 25.0476 5.09275 24.4483 4.94571C23.8506 4.79922 23.2434 5.16543 23.0958 5.76533L19.7413 19.4429C19.5942 20.0428 19.9616 20.6483 20.5609 20.7954C20.6509 20.8166 20.7404 20.8272 20.8287 20.8272Z"
                                fill="#FDBF00" />
                            <path
                                d="M5.17167 20.8273C5.26001 20.8273 5.34946 20.8167 5.43947 20.7949C6.03882 20.6478 6.40614 20.0423 6.2591 19.4424L2.90456 5.76481C2.75751 5.16547 2.15146 4.7987 1.55211 4.94519C0.952767 5.09223 0.585445 5.69772 0.732486 6.29763L4.08703 19.9752C4.21171 20.4857 4.66905 20.8273 5.17167 20.8273Z"
                                fill="#FDBF00" />
                            <path
                                d="M5.17307 25.3H20.8276C21.4449 25.3 21.9458 24.7991 21.9458 24.1818C21.9458 23.5646 21.4449 23.0637 20.8276 23.0637H5.17307C4.55584 23.0637 4.05489 23.5646 4.05489 24.1818C4.05489 24.7991 4.55584 25.3 5.17307 25.3Z"
                                fill="#FDBF00" />
                        </svg>
                    </span>
                @endif
            </a>

            @php
                $user = auth()->user();
                $like = $image->likes->where('user_id', @$user->id)->count();
                $collectionImage = $user ? $user->collectionImages->where('image_id', $image->id)->first() : null;
            @endphp



            <div class="gallery__share top-auto bottom-[15px] left-[50%] translate-x-[-50%]">
                <div class="list gallery__list justify-content-center flex-row">
                    <div>
                        <button class="gallery__btn @if ($like) unlike-btn @else like-btn @endif"
                            data-has_icon="1" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="@if ($like) @lang('Unlike') @else @lang('like') @endif"
                            data-bs-custom-class="custom--tooltip" data-image="{{ $image->id }}">
                            @if ($like)
                                <i class="fas fa-heart text-[22px] text-[#ed3126]"></i>
                            @else
                                <i class="fas fa-heart text-[22px] text-white"></i>
                            @endif
                        </button>
                    </div>
                    <div>
                        <button class="gallery__btn collect-btn" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="@if ($collectionImage) @lang('Collected') @else
                            @lang('Collect') @endif"
                            data-bs-custom-class="custom--tooltip" data-image_id="{{ $image->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" enable-background="new 0 0 512 512"
                                viewBox="0 0 512 512" width="20" height="20" style="&#10;    fill: #fff;&#10;">
                                <g clip-rule="evenodd" fill-rule="evenodd">
                                    <path
                                        d="m17.27 0h160.27c9.5 0 17.26 7.77 17.26 17.26v160.27c0 9.5-7.77 17.26-17.26 17.26h-160.27c-9.5.01-17.27-7.76-17.27-17.25v-160.27c0-9.5 7.77-17.27 17.27-17.27z" />
                                    <path
                                        d="m399.57 0h30.08c7.34 0 13.35 6.01 13.35 13.35v55.65h55.64c7.34 0 13.35 6.01 13.35 13.35v30.08c0 7.34-6.01 13.35-13.35 13.35h-55.64v55.64c0 7.37-6.01 13.38-13.35 13.38h-30.08c-7.34 0-13.35-6.01-13.35-13.38v-55.64h-55.64c-7.34 0-13.35-6.01-13.35-13.35v-30.08c0-7.34 6.01-13.35 13.35-13.35h55.64v-55.65c0-7.34 6.01-13.35 13.35-13.35z" />
                                    <path
                                        d="m17.27 317.23h160.27c9.5 0 17.26 7.77 17.26 17.23v160.3c0 9.47-7.77 17.23-17.26 17.23h-160.27c-9.5.01-17.27-7.76-17.27-17.23v-160.3c0-9.46 7.77-17.23 17.27-17.23z" />
                                    <path
                                        d="m334.46 317.23h160.3c9.5 0 17.23 7.77 17.23 17.23v160.3c0 9.47-7.74 17.23-17.23 17.23h-160.3c-9.47 0-17.23-7.77-17.23-17.23v-160.3c0-9.46 7.77-17.23 17.23-17.23z" />
                                </g>
                            </svg>
                        </button>
                    </div>
                    <div>
                        <button class="gallery__btn share-btn" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Share" data-bs-custom-class="custom--tooltip"
                            data-route="{{ route('image.detail', [slug($image->title), $image->id]) }}"
                            data-url_len_code="{{ urlencode(route('image.detail', [slug($image->title), $image->id])) }}"
                            data-image_title="{{ $image->title }}">
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
