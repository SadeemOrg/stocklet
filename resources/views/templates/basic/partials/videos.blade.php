@php
    $content = getContent('video.content', true);

    $videos = App\Models\Video::approved()
        ->inrandomOrder()
        ->limit(6)
        ->get();

@endphp
@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
@endpush

<section class="my-5">
    <div class="container custom--container">
        <div>
            <h2 class="section__title text-center mb-5">
                {{ __(@$content->data_values->title) }}
                <span class=" Fcolor--red">
                    {{ __(@$content->data_values->colortitle) }}
                </span>
            </h2>
        </div>
        <div class="row justify-content-center">
            @foreach ($videos as $video)
                <div class="col-sm-6 col-lg-4 mb-4">

                    <a href="{{ route('video.detail', [slug($video->title), $video->id]) }}">
                        <div class="video-wrap_homepage position-relative">

                            <div
                                class="video-overlay_homepage position-absolute w-100 h-100 unset-0 d-flex align-items-center justify-content-center">

                                <svg width="50" height="50" viewBox="0 0 82 82" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_141_3225)">
                                        <circle cx="40.3167" cy="40.3167" r="37.5833" fill="white" />
                                        <path
                                            d="M41 0C18.3563 0 0 18.3563 0 41C0 63.6437 18.3563 82 41 82C63.6437 82 82 63.6437 82 41C82 18.3563 63.6437 0 41 0ZM29.7975 58.8326V23.1674L60.6845 41L29.7975 58.8326Z"
                                            fill="#ED3126" />
                                    </g>

                                    <defs>
                                        <clipPath id="clip0_141_3225">
                                            <rect width="82" height="82" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>


                            </div>

                            @php
                                $file = getFilePath('stockImage') . '/' . $video->cover_image;
                            @endphp
                            <img class="w-100 h-100 video-img" src="/{{ $file }}" alt="">
                            <span class="gallery__premium ml-auto right-0 left-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 26 26" fill="none">
                                    <path
                                        d="M5.17307 20.8272H20.8276C21.4449 20.8272 21.9458 20.3263 21.9458 19.7091C21.9458 19.0918 21.4449 18.5909 20.8276 18.5909H5.17307C4.55584 18.5909 4.05489 19.0918 4.05489 19.7091C4.05489 20.3263 4.55584 20.8272 5.17307 20.8272Z"
                                        fill="#FDBF00"></path>
                                    <path
                                        d="M17.0805 12.2603C17.3064 12.2603 17.5351 12.1921 17.7324 12.0495L24.8351 6.93888C25.3361 6.57826 25.4507 5.8794 25.0895 5.37845C24.7289 4.87751 24.0306 4.76234 23.5291 5.12407L16.4264 10.2347C15.9254 10.5953 15.8108 11.2942 16.172 11.7951C16.39 12.0987 16.7328 12.2603 17.0805 12.2603Z"
                                        fill="#FDBF00"></path>
                                    <path
                                        d="M8.92023 12.2603C9.26798 12.2603 9.61015 12.0988 9.82875 11.7952C10.1899 11.2942 10.0753 10.5954 9.57437 10.2347L2.47167 5.12409C1.96961 4.76292 1.27186 4.87809 0.91125 5.37848C0.550077 5.87943 0.664692 6.57829 1.16564 6.9389L8.26833 12.0496C8.46625 12.1921 8.69435 12.2603 8.92023 12.2603Z"
                                        fill="#FDBF00"></path>
                                    <path
                                        d="M17.0801 12.2609C17.23 12.2609 17.3821 12.2301 17.528 12.1664C18.0938 11.9193 18.3521 11.2595 18.1038 10.6937L14.0247 1.36979C13.7776 0.803989 13.1184 0.545689 12.5521 0.793926C11.9863 1.04104 11.728 1.70077 11.9762 2.26657L16.0553 11.5905C16.2387 12.0098 16.6491 12.2609 17.0801 12.2609Z"
                                        fill="#FDBF00"></path>
                                    <path
                                        d="M8.92063 12.2609C9.35169 12.2609 9.76206 12.0104 9.94544 11.5905L14.0246 2.26656C14.2722 1.70076 14.0139 1.04159 13.4487 0.79391C12.8829 0.546233 12.2237 0.804532 11.9761 1.36977L7.89694 10.6937C7.64926 11.2595 7.90756 11.9187 8.4728 12.1664C8.61872 12.2301 8.77135 12.2609 8.92063 12.2609Z"
                                        fill="#FDBF00"></path>
                                    <path
                                        d="M20.8287 20.8272C21.3313 20.8272 21.7887 20.4862 21.9133 19.9757L25.2679 6.29815C25.4149 5.69824 25.0476 5.09275 24.4483 4.94571C23.8506 4.79922 23.2434 5.16543 23.0958 5.76533L19.7413 19.4429C19.5942 20.0428 19.9616 20.6483 20.5609 20.7954C20.6509 20.8166 20.7404 20.8272 20.8287 20.8272Z"
                                        fill="#FDBF00"></path>
                                    <path
                                        d="M5.17167 20.8273C5.26001 20.8273 5.34946 20.8167 5.43947 20.7949C6.03882 20.6478 6.40614 20.0423 6.2591 19.4424L2.90456 5.76481C2.75751 5.16547 2.15146 4.7987 1.55211 4.94519C0.952767 5.09223 0.585445 5.69772 0.732486 6.29763L4.08703 19.9752C4.21171 20.4857 4.66905 20.8273 5.17167 20.8273Z"
                                        fill="#FDBF00"></path>
                                    <path
                                        d="M5.17307 25.3H20.8276C21.4449 25.3 21.9458 24.7991 21.9458 24.1818C21.9458 23.5646 21.4449 23.0637 20.8276 23.0637H5.17307C4.55584 23.0637 4.05489 23.5646 4.05489 24.1818C4.05489 24.7991 4.55584 25.3 5.17307 25.3Z"
                                        fill="#FDBF00"></path>
                                </svg>
                            </span>
                        </div>
                    </a>
                </div>
            @endforeach


        </div>
    </div>
</section>

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        Fancybox.bind('[data-fancybox]', {
            // Custom options
        });
    </script>
@endpush
